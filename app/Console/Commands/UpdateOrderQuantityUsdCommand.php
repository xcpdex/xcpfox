<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateOrderQuantityUsdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:orders:usd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Orders USD';

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
        $assets = [];

        $tickers = \App\PriceHistory::select('ticker')->groupBy('ticker')->get();

        foreach($tickers as $ticker)
        {
            $assets[] = $ticker->ticker;
        }

        foreach(['get', 'give'] as $key)
        {
            $key_asset = "{$key}_asset";
            $key_quantity = "{$key}_quantity";
            $key_quantity_usd = "{$key}_quantity_usd";
            $key_remaining = "{$key}_remaining";
            $key_remaining_usd = "{$key}_remaining_usd";

            $orders = \App\Order::whereIn($key_asset, $assets)
                ->where($key_quantity, '>', 0)
                ->where($key_quantity_usd, '=', 0)
                ->orderBy('confirmed_at', 'desc')
                ->get();

            foreach($orders as $order)
            {
                $confirmed_at = $order->confirmed_at->toDateString('America/New_York');

                $historical = \App\PriceHistory::where('ticker', '=', $order->{$key_asset})
                    ->where('quality_score', '=', 1)
                    ->where('confirmed_at', 'like', $confirmed_at . '%')
                    ->first();

                if($historical)
                {
                    $order->update([
                        $key_quantity_usd => fromSatoshi($historical->price * $order->{$key_quantity}),
                        $key_remaining_usd => fromSatoshi($historical->price * $order->{$key_remaining}),
                        'quality_score' => $historical->quality_score,
                    ]);
                }
            }
        }
    }
}