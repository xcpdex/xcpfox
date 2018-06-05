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
    protected $syncing;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($first_block, $last_block, $syncing=false)
    {
        $this->counterparty = new \JsonRPC\Client(env('CP_API'));
        $this->counterparty->authentication(env('CP_USER'), env('CP_PASS'));
        $this->first_block = $first_block;
        $this->last_block = $last_block;
        $this->syncing = $syncing;
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
            $block = \App\Block::firstOrCreateBlock($block_data);

            // Update Block
            if(! $this->syncing && ! $block->processed_at)
            {
                \App\Jobs\UpdateBlock::dispatch($block);
            }

            // Add Messages
            $this->processMessages($block_data['_messages'], $block_data['block_time']);
        }

        if($this->syncing)
        {
            // Keep Going
            exec('php /var/www/xcpfox.com/artisan update:blocks');
        }
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
            // Get Bindings
            $bindings = $this->getBindings($message, $block_time);

            // Save Message
            if(\App\Message::firstOrCreateMessage($message, $bindings))
            {
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
                    $this->handleReorg($message, $bindings);
                }
            }
        }
    }

    /**
     * Create Model
     * Logic applies to any message type.
     */
    private function createModel($message, $bindings)
    {
        // Record Transaction Data
        if(isset($bindings['tx_index']))
        {
            $transaction = \App\Transaction::firstOrCreateTransaction($message, $bindings);

            // Update Transaction
            if(! $this->syncing && $transaction->processed_at === null)
            {
                \App\Jobs\UpdateTransaction::dispatch($transaction);
            }
        }

        // Only Save Valid Messages
        if($this->guardAgainstInvalidMessages($message, $bindings))
        {
            // Addresses/Assets/Balances/Replace
            $this->handleAddressesAssetsBalancesReplace($message, $bindings);

            // Get Model Name From Category Type
            $model_name = getModelNameFromType($message['category']);

            // Lookup Keys for Model and Bindings
            $lookup = getCreateLookupKeys($message, $bindings);

            if($lookup)
            {
                // Save As Variables Before Unsetting
                $key = $lookup['model_key'];
                $value = $bindings[$lookup['bindings_key']];

                // Unset the Lookup Binding Value Used
                unset($bindings[$lookup['bindings_key']]);

                // Oo la la
                $model_name::firstOrCreate([$key => $value], $bindings);
            }
            else
            {
                // Oo la la
                $model_name::firstOrCreate($bindings);
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
        $lookup = getUpdateLookupKeys($message, $bindings);

        // Save As Variables Before Unsetting
        $key = $lookup['model_key'];
        $value = $bindings[$lookup['bindings_key']];

        // Unset the Lookup Binding Value Used
        unset($bindings[$lookup['bindings_key']]);

        // Get Model Name From Category Type
        $model_name = getModelNameFromType($message['category']);

        // Oo la la
        return $model_name::updateOrCreate([$key => $value], $bindings);
    }

    /**
     * Halt and Rollback
     * Delete everything after given block height.
     */
    private function handleReorg($message, $bindings)
    {
        // Activate a Rollback
        $rollback = \App\Rollback::firstOrCreate([
          'message_index' => $message['message_index'],
          'block_index' => $bindings['block_index'],
        ]);

        if($rollback->wasRecentlyCreated)
        {
            // Clear the Job Queue
            \Redis::connection()->del('queues:high');
            \Redis::connection()->del('queues:default');

            // Delete All the Things
            \DB::transaction(function () use($bindings, $rollback)
            {
                $tables = ['blocks', 'comments', 'messages', 'transactions', 'bet_expirations', 'bet_match_expirations', 'bet_match_resolutions', 'bet_matches', 'bets', 'broadcasts', 'btcpays', 'burns', 'cancels', 'credits', 'debits', 'destructions', 'dividends', 'issuances', 'order_expirations', 'order_match_expirations', 'order_matches', 'orders', 'replaces', 'rps', 'rps_expirations', 'rps_match_expirations', 'rpsresolves', 'sends', 'addresses', 'assets', 'balances'];

                foreach($tables as $table)
                {
                   \DB::table($table)->where('block_index', '>', $bindings['block_index'])->delete();
                }

                // Mark Completed
                $rollback->update(['processed_at' => \Carbon\Carbon::now()]);
            });
        }
    }

    /**
     * Handle Assets, Balances, Replace
     * This is data that is not always present.
     */
    private function handleAddressesAssetsBalancesReplace($message, $bindings)
    {
        \App\Address::firstOrCreateAddress($message, $bindings);

        if($message['category'] === 'issuances')
        {
            \App\Asset::updateOrCreateAsset($message, $bindings);
        }
        elseif($message['category'] === 'credits' || $message['category'] === 'debits')
        {
            \App\Balance::updateOrCreateBalance($message, $bindings);
        }
        elseif($message['category'] === 'replace')
        {
            \App\Address::updateAddressOptions($bindings);
        }
    }

    /**
     * Get Bindings
     * Nice array for avoiding database calls.
     */
    private function getBindings($message, $block_time)
    {
        $bindings = get_object_vars(json_decode($message['bindings']));
        $confirmed_at = \Carbon\Carbon::createFromTimestamp($block_time)->toDateTimeString();

        return array_merge($bindings, ['confirmed_at' => $confirmed_at]);
    }

    private function guardAgainstInvalidMessages($message, $bindings)
    {
        if(isset($bindings['status']) && substr(trim($bindings['status']), 0, 7) === 'invalid')
        {
            return false;
        }

        return true;
    }
}