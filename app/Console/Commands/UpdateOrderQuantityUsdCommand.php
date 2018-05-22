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
        $price_histories = \App\PriceHistory::get();

        foreach($price_histories as $historical)
        {
            $orders = \App\Order::whereGetAsset($historical->ticker)->where('get_quantity', '>', 0)->whereGetQuantityUsd(0)->where('confirmed_at', 'like', $historical->confirmed_at->toDateString('America/New_York') . '%')->get();

            foreach($orders as $order)
            {
                $order->update([
                    'get_quantity_usd' => fromSatoshi($historical->price * $order->get_quantity),
                    'get_remaining_usd' => fromSatoshi($historical->price * $order->get_remaining),
                ]);
            }

            $orders = \App\Order::whereGiveAsset($historical->ticker)->where('give_quantity', '>', 0)->whereGiveQuantityUsd(0)->where('confirmed_at', 'like', $historical->confirmed_at->toDateString('America/New_York') . '%')->get();

            foreach($orders as $order)
            {
                $order->update([
                    'give_quantity_usd' => fromSatoshi($historical->price * $order->give_quantity),
                    'give_remaining_usd' => fromSatoshi($historical->price * $order->give_remaining),
                ]);
            }
        }
    }
}