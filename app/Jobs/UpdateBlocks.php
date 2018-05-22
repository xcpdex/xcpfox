<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateBlocks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $counterparty;
    protected $first_block;
    protected $last_block;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($first_block, $last_block)
    {
        $this->counterparty = new \JsonRPC\Client(env('CP_API'));
        $this->counterparty->authentication(env('CP_USER'), env('CP_PASS'));
        $this->first_block = $first_block;
        $this->last_block = $last_block;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get Blocks
        $blocks = $this->getBlocks($this->first_block, $this->last_block);

        foreach($blocks as $block_data)
        {
            // Create Block
            \App\Block::updateOrCreateBlock($block_data);

            // Add Messages
            $this->processMessages($block_data['_messages'], $block_data['block_time']);
        }

        // Useful When Syncing
        exec('php /var/www/xcpfox.com/artisan update:blocks');
    }

    /**
     * Counterparty API
     * https://counterparty.io/docs/api/#get_blocks
     */
    private function getBlocks($first_block, $last_block)
    {
        $block_indexes = range($first_block, $last_block);

        return $this->counterparty->execute('get_blocks', [
            'block_indexes' => $block_indexes,
        ]);
    }

    /**
     * Execute Messages
     * Use the messages to build the local database.
     */
    private function processMessages($messages, $block_time)
    {
        // Inserts Before Updates
        usort($messages, function ($message1, $message2) {
            return $message1['command'] <=> $message2['command'];
        });

        foreach($messages as $message)
        {
            // Save Message
            \App\Message::updateOrCreateMessage($message, $block_time);

            // Get Bindings
            $bindings = $this->getBindings($message, $block_time);

            if($message['command'] === 'insert')
            {
                $this->createModel($message, $bindings);
            }
            elseif($message['command'] === 'update')
            {
                $this->updateModel($message, $bindings);
            }
            elseif($message['command'] === 'reorg')
            {
                // Undecided
            }
        }
    }

    /**
     * Get Bindings
     * Nice array for avoiding database calls.
     */
    private function getBindings($message, $block_time)
    {
        $bindings = get_object_vars(json_decode($message['bindings']));

        return array_merge($bindings, ['confirmed_at' => \Carbon\Carbon::createFromTimestamp($block_time, 'America/New_York')]);
    }

    /**
     * Convert Category
     * Returns corresponding model class.
     */
    private function getModelName($message)
    {
        // These two are str_singular edge cases
        if($message['category'] === 'rps') return '\\App\\Rps';
        if($message['category'] === 'rpsresolves') return '\\App\\Rpsresolve';

        return '\\App\\' . ucfirst(camel_case(str_singular($message['category'])));
    }

    /**
     * Create Model
     * Logic applies to any message type.
     */
    private function createModel($message, $bindings)
    {
        // Record Transaction Data
        $this->updateOrCreateTransaction($message, $bindings);

        // Only Save Valid Messages
        if($this->guardAgainstInvalidMessages($message, $bindings))
        {
            // Store Any New Addresses
            \App\Address::firstOrCreateAddress($message, $bindings);

            // Assets/Balances/Replace
            $this->handleAssetsBalancesReplace($message, $bindings);

            // Get Model Name From Category Type
            $model_name = $this->getModelName($message);

            try
            {
                // Oo la la
                $model_name::firstOrCreate($bindings);
            }
            catch(\Exception $e)
            {
                \Storage::append('failed.log', 'Insert: ' . $message['message_index'] . ' ' . serialize($e->getMessage()));
            }
        }
    }

    /**
     * Update Existing Model
     * Logic applies to any message type.
     */
    private function updateModel($message, $bindings)
    {
        // Lookup Keys for Model and Bindings
        $lookup = $this->getLookupKeys($message, $bindings);

        // Save As Variables Before Unsetting
        $key = $lookup['model_key'];
        $value = $bindings[$lookup['bindings_key']];

        // Unset the Lookup Binding Value Used
        unset($bindings[$lookup['bindings_key']]);

        // Get Model Name From Category Type
        $model_name = $this->getModelName($message);

        try
        {
            // Oo la la
            return $model_name::updateOrCreate([$key => $value], $bindings);
        }
        catch(\Exception $e)
        {
            \Storage::append('failed.log', 'Update: ' . $message['message_index'] . ' ' . serialize($e->getMessage()));
        }
    }

    /**
     * Update or Create Transaction
     * Transaction is a subset of messages.
     */
    private function updateOrCreateTransaction($message, $bindings)
    {
        // Not every message is a tx
        if(isset($bindings['tx_index']))
        {
            $transaction = \App\Transaction::updateOrCreateTransaction($message, $bindings);

            if($transaction->processed_at === null)
            {
                // Turn Off While Syncing
                // \App\Jobs\UpdateTransaction::dispatch($transaction);
            }
        }
    }

    /**
     * Handle Assets, Balances, Replace
     * This is data that is not always present.
     */
    private function handleAssetsBalancesReplace($message, $bindings)
    {
        if($message['category'] === 'issuances')
        {
            \App\Asset::updateOrCreateAsset($message, $bindings);
        }
        elseif($message['category'] === 'credits' || $message['category'] === 'debits')
        {
            \App\Balance::updateOrCreateBalance($message, $bindings, str_singular($message['category']));
        }
        elseif($message['category'] === 'replace')
        {
            \App\Address::updateAddressOptions($bindings);
        }
    }

    /**
     * Determine Keys
     * So we can use re-use update logic.
     */
    private function getLookupKeys($message, $bindings)
    {
        // Symmetric Keys
        if($message['category'] === 'bets' || $message['category'] === 'orders')
        {
            $model_key = $bindings_key = 'tx_hash';
        }
        elseif($message['category'] === 'rps')
        {
            $model_key = $bindings_key = 'tx_index';
        }
        else
        {
            $model_key = $bindings_key = str_replace('_matches', '_match_id', $message['category']);
        }

        // Divergent Keys
        if($message['category'] === 'order_matches' || $message['category'] === 'bet_matches' || $message['category'] === 'rps_matches')
        {
            $model_key = 'id';
        }

        // Edge Case Keys
        if($message['category'] === 'rps' && ! isset($bindings[$bindings_key]))
        {
            // RPS seems to use tx_index OR tx_hash
            $model_key = $bindings_key = 'tx_hash';
        }

        return [
            'model_key' => $model_key,
            'bindings_key' => $bindings_key,
        ];
    }

    private function guardAgainstInvalidMessages($message, $bindings)
    {
        if(isset($bindings['status']) && strpos($bindings['status'], 'invalid') === true)
        {
            return false;
        }

        return true;
    }
}