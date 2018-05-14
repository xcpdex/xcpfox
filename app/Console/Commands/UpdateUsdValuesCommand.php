<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateUsdValuesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usd:values';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'USD Values';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \App\Transaction::where('fee_usd', '=', 0)->chunk(500, function ($transactions)
        {
            foreach($transactions as $transaction)
            {
              $transaction->update([
                    'fee_usd' => $this->getUSD($transaction, $transaction->fee),
                    'quantity_usd' => $this->getUSD($transaction, $transaction->quantity),
                ]);
            }
        });
    }

    private function getUSD($transaction, $satoshis)
    {
        if(is_null($satoshis)) $satoshis = 0;

        $confirmed_at = $transaction->confirmed_at->toDateString() . '%';

        try
        {
            $historical = \App\PriceHistory::whereTicker('BTC')->where('confirmed_at', 'like', $confirmed_at)->latest('confirmed_at')->firstOrFail();
        }
        catch(\Exception $e)
        {
            $historical = \App\PriceHistory::whereTicker('BTC')->latest('confirmed_at')->first();
        }

        return $historical->price * $satoshis / 100000000;
    }
}