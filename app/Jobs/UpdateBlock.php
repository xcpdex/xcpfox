<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateBlock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bitcoin;
    protected $block;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(\App\Block $block)
    {
        $this->bitcoin = new \JsonRPC\Client(env('BC_API'));
        $this->bitcoin->authentication(env('BC_USER'), env('BC_PASS'));
        $this->block = $block;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try
        {
            $block_data = $this->getBlock($this->block->block_hash);

            $this->block->update([
                'next_block_hash' => isset($block_data['nextblockhash']) ? $block_data['nextblockhash'] : null,
                'merkle_root' => $block_data['merkleroot'],
                'chainwork' => $block_data['chainwork'],
                'nonce' => $block_data['nonce'],
                'size' => $block_data['size'],
                'stripped_size' => $block_data['strippedsize'],
                'weight' => $block_data['weight'],
                'tx_count' => count($block_data['tx']),
                'confirmed_at' => \Carbon\Carbon::createFromTimestamp($block_data['time']),
                'processed_at' => \Carbon\Carbon::now(),
            ]);
        }
        catch(\Exception $e)
        {
            \Storage::append('failed.log', 'Update Block: ' . serialize($e->getMessage()));
        }
    }

    /**
     * Bitcoin API
     */
    private function getBlock($block_hash)
    {
        return $this->bitcoin->execute('getblock', [$block_hash]);
    }
}