<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $counterparty;
    protected $transaction;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(\App\Transaction $transaction)
    {
        $this->counterparty = new \JsonRPC\Client(env('CP_API'));
        $this->counterparty->authentication(env('CP_USER'), env('CP_PASS'));
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if(! $this->transaction->processed_at)
        {
            $raw = $this->getRawTransaction();

            $data = $this->getTxInfo($raw);

            $this->transaction->updateTransaction($raw, $data);
        }
    }

    /**
     * Counterparty API
     * getrawtransaction
     */
    private function getRawTransaction()
    {
        return $this->counterparty->execute('getrawtransaction', [
            'tx_hash' => $this->transaction->tx_hash,
            'verbose' => true,
        ]);
    }

    /**
     * Counterparty API
     * getrawtransaction
     */
    private function getTxInfo($raw)
    {
        return $this->counterparty->execute('get_tx_info', [
            'tx_hex' => $raw['hex'],
            'block_index' => $this->transaction->block_index,
        ]);
    }
}
