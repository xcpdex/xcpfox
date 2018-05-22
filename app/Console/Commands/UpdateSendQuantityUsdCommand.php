<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateSendQuantityUsdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:sends:usd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Sends USD';

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
        $price_histories = \App\PriceHistory::orderBy('confirmed_at', 'desc')->get();

        foreach($price_histories as $historical)
        {
            $sends = \App\Send::whereAsset($historical->ticker)->where('quantity', '>', 0)->whereQuantityUsd(0)->where('confirmed_at', 'like', $historical->confirmed_at->toDateString('America/New_York') . '%')->get();

            foreach($sends as $send)
            {
                $send->update([
                    'quantity_usd' => fromSatoshi($historical->price * $send->quantity),
                ]);
            }
        }
    }
}