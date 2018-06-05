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
        $data = $this->getBlock();

        $this->block->updateBlock($data);
    }

    /**
     * Bitcoin API
     */
    private function getBlock()
    {
        return $this->bitcoin->execute('getblock', [$this->block->block_hash]);
    }
}