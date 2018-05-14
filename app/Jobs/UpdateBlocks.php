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
        $blocks = $this->getBlocks($this->first_block, $this->last_block);

        foreach($blocks as $data)
        {
            $this->updateOrCreateBlock($data);
            $this->processMessages($data['_messages'], $data['block_time']);
        }
    }

    private function getBlocks($first_block, $last_block)
    {
        $block_indexes = range($first_block, $last_block);

        return $this->counterparty->execute('get_blocks', [
            'block_indexes' => $block_indexes,
        ]);
    }

    private function updateOrCreateBlock($data)
    {
        try
        {
            return \App\Block::updateOrCreate([
                'block_index' => $data['block_index'],
            ],[
                'block_hash' => $data['block_hash'],
                'ledger_hash' => $data['ledger_hash'],
                'txlist_hash' => $data['txlist_hash'],
                'messages_hash' => $data['messages_hash'],
                'previous_block_hash' => $data['previous_block_hash'],
                'difficulty' => $data['difficulty'],
                'timestamp' => $data['block_time'],
                'confirmed_at' => \Carbon\Carbon::createFromTimestamp($data['block_time'], 'America/New_York'),
            ]);
        }
        catch(\Exception $e)
        {
        }
    }

    private function processMessages($messages, $block_time)
    {
        foreach($messages as $message)
        {
            try
            {
                \App\Message::updateOrCreate([
                    'message_index' => $message['message_index'],
                ],[
                    'block_index' => $message['block_index'],
                    'command' => $message['command'],
                    'category' => isset($message['category']) ? $message['category'] : '',
                    'bindings' => $message['bindings'],
                    'timestamp' => $message['timestamp'],
                    'confirmed_at' => \Carbon\Carbon::createFromTimestamp($block_time, 'America/New_York'),
                ]);

                if($message['command'] === 'insert')
                {
                    $this->updateOrCreateTransaction($message, $block_time);
                }
            }
            catch(\Exception $e)
            {
            }
        }
    }

    private function updateOrCreateTransaction($message, $block_time)
    {
        $data = json_decode($message['bindings']);

        if(isset($data->tx_index))
        {
            try
            {
                $transaction = \App\Transaction::updateOrCreate([
                    'tx_index' => $data->tx_index,
                ],[
                    'type' => $message['category'],
                    'source' => $data->source,
                    'tx_hash' => $data->tx_hash,
                    'block_index' => $data->block_index,
                    'destination' => isset($data->destination) ? $data->destination : null,
                    'timestamp' => $block_time,
                    'confirmed_at' => \Carbon\Carbon::createFromTimestamp($block_time, 'America/New_York'),
                ]);

                if($transaction->processed_at === null)
                {
                    \App\Jobs\UpdateTransaction::dispatch($transaction);
                }
            }
            catch(\Exception $e)
            {
            }
        }
    }
}