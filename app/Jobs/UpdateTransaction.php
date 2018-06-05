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
        try
        {
            $this->counterparty = new \JsonRPC\Client(env('CP_API'));
            $this->counterparty->authentication(env('CP_USER'), env('CP_PASS'));
            $this->transaction = $transaction;
        }
        catch(\Exception $e)
        {
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->transaction->processed_at) return true;

        try
        {
            $rt_data = $this->counterparty->execute('getrawtransaction', [
                'tx_hash' => $this->transaction->tx_hash,
                'verbose' => true,
            ]);

            $tx_data = $this->counterparty->execute('get_tx_info', [
                'tx_hex' => $rt_data['hex'],
                'block_index' => $this->transaction->block_index,
            ]);

            $this->transaction->update([
                'destination' => $tx_data[1],
                'quantity' => is_null($tx_data[2]) ? 0 : $tx_data[2],
                'quantity_usd' => $this->getUSD($this->transaction, $tx_data[2]),
                'fee' => $tx_data[3],
                'fee_usd' => $this->getUSD($this->transaction, $tx_data[3]),
                'size' => $rt_data['size'],
                'vsize' => $rt_data['vsize'],
                'inputs' => count($rt_data['vin']),
                'outputs' => count($rt_data['vout']),
                'raw' => $rt_data,
                'quality_score' => 1,
                'confirmed_at' => $this->transaction->confirmed_at,
                'processed_at' => \Carbon\Carbon::now(),
            ]);
        }
        catch(\Exception $e)
        {
            \Storage::append('failed.log', 'Update TX: ' . serialize($e->getMessage()));
        }
    }

    private function getUSD($transaction, $satoshis)
    {
        if(is_null($satoshis)) $satoshis = 0;

        $confirmed_at = $transaction->confirmed_at->toDateString() . '%';

        try
        {
            $historical = \App\AssetHistory::whereType('price')
                ->whereQualityScore(1)
                ->whereAsset('BTC')
                ->where('confirmed_at', 'like', $confirmed_at)
                ->latest('confirmed_at')
                ->firstOrFail();
        }
        catch(\Exception $e)
        {
            return 0;
        }

        return $historical->value * $satoshis / 100000000;
    }
}
