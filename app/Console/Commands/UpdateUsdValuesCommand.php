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
    protected $signature = 'update:usd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update USD Values';

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
        $txs = \App\Transaction::where('quantity', '>', 0)
            ->where('quantity_usd', '=', 0)
            ->orWhere('fee', '>', 0)
            ->where('fee_usd', '=', 0)
            ->get();

        foreach($txs as $tx)
        {
            $price = \App\AssetHistory::where('asset', '=', 'BTC')
                ->where('type', '=', 'price')
                ->where('confirmed_at', 'like', $tx->confirmed_at->toDateString() . '%')
                ->first();

            if($price)
            {
                $tx->update([
                    'quantity_usd' => fromSatoshi($tx->quantity * $price->value),
                    'fee_usd' => fromSatoshi($tx->fee * $price->value),
                ]);
            }
            else
            {
                $tx->update([
                    'quantity_usd' => 0,
                    'fee_usd' => 0,
                ]);
            }
        }
    }
}