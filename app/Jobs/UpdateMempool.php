<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateMempool implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $counterparty;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->counterparty = new \JsonRPC\Client(env('CP_API'));
        $this->counterparty->authentication(env('CP_USER'), env('CP_PASS'));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get Mempool
        $mempool = $this->getMempool();

        foreach($mempool as $message)
        {
            if($message['command'] === 'insert')
            {
                \App\Mempool::firstOrCreate($message);
            }
        }
    }

    /**
     * Counterparty API
     * https://counterparty.io/docs/api/#get_table
     */
    private function getMempool()
    {
        return $this->counterparty->execute('get_mempool');
    }
}