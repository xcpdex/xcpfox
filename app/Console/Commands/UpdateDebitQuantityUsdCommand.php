<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateDebitQuantityUsdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:debits:usd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Debits USD';

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

        $debits = \App\Debit::whereIn('asset', $assets)
            ->where('quantity', '>', 0)
            ->where('quantity_usd', '=', 0)
            ->orderBy('confirmed_at', 'desc')
            ->get();

        foreach($debits as $debit)
        {
            $confirmed_at = $debit->confirmed_at->toDateString('America/New_York');

            $historical = \App\PriceHistory::where('ticker', '=', $debit->asset)
                ->where('quality_score', '=', 1)
                ->where('confirmed_at', 'like', $confirmed_at . '%')
                ->first();

            if($historical)
            {
                $debit->update([
                    'quantity_usd' => fromSatoshi($historical->price * $debit->quantity),
                    'quality_score' => $historical->quality_score,
                ]);
            }
        }
    }
}