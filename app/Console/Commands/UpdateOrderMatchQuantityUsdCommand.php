<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateOrderMatchQuantityUsdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:ordermatches:usd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Order Matches USD';

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
            $order_matches = \App\OrderMatch::whereForwardAsset($historical->ticker)->where('forward_quantity', '>', 0)->whereForwardQuantityUsd(0)->where('confirmed_at', 'like', $historical->confirmed_at->toDateString('America/New_York') . '%')->get();

            foreach($order_matches as $order_match)
            {
                $order_match->update([
                    'forward_quantity_usd' => fromSatoshi($historical->price * $order_match->forward_quantity),
                ]);
            }

            $order_matches = \App\OrderMatch::whereBackwardAsset($historical->ticker)->where('backward_quantity', '>', 0)->whereBackwardQuantityUsd(0)->where('confirmed_at', 'like', $historical->confirmed_at->toDateString('America/New_York') . '%')->get();

            foreach($order_matches as $order_match)
            {
                $order_match->update([
                    'backward_quantity_usd' => fromSatoshi($historical->price * $order_match->backward_quantity),
                ]);
            }
        }
    }
}