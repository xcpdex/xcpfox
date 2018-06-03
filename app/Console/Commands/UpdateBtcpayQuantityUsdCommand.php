<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateBtcpayQuantityUsdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:btcpays:usd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update BTCPays USD';

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
        $btcpays = \App\Btcpay::where('btc_amount', '>', 0)
            ->where('btc_amount_usd', '=', 0)
            ->orderBy('confirmed_at', 'desc')
            ->get();

        foreach($btcpays as $btcpay)
        {
            $confirmed_at = $btcpay->confirmed_at->toDateString('America/New_York');

            $historical = \App\PriceHistory::where('ticker', '=', 'BTC')
                ->where('quality_score', '=', 1)
                ->where('confirmed_at', 'like', $confirmed_at . '%')
                ->first();

            if($historical)
            {
                $btcpay->update([
                    'btc_amount_usd' => fromSatoshi($historical->price * $btcpay->btc_amount),
                    'quality_score' => $historical->quality_score,
                ]);
            }
        }
    }
}