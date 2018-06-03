<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateDividendQuantityUsdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:dividends:usd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Dividends USD';

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

        $dividends = \App\Dividend::whereIn('dividend_asset', $assets)
            ->where('quantity_per_unit', '>', 0)
            ->where('quantity_per_unit_usd', '=', 0)
            ->orWhereIn('dividend_asset', $assets)
            ->where('fee_paid', '>', 0)
            ->where('fee_paid_usd', '=', 0)
            ->orderBy('confirmed_at', 'desc')
            ->get();

        foreach($dividends as $dividend)
        {
            $confirmed_at = $dividend->confirmed_at->toDateString('America/New_York');

            $historical = \App\PriceHistory::where('ticker', '=', $dividend->dividend_asset)
                ->where('quality_score', '=', 1)
                ->where('confirmed_at', 'like', $confirmed_at . '%')
                ->first();

            $historical_xcp = \App\PriceHistory::where('ticker', '=', 'XCP')
                ->where('quality_score', '=', 1)
                ->where('confirmed_at', 'like', $confirmed_at . '%')
                ->first();

            if($historical && $historical_xcp)
            {
                $dividend->update([
                    'quantity_per_unit_usd' => fromSatoshi($historical->price * $dividend->quantity_per_unit),
                    'fee_paid_usd' => fromSatoshi($historical_xcp->price * $dividend->fee_paid),
                    'quality_score' => $historical->quality_score,
                ]);
            }
            elseif($historical)
            {
                $dividend->update([
                    'quantity_per_unit_usd' => fromSatoshi($historical->price * $dividend->quantity_per_unit),
                    'quality_score' => $historical->quality_score,
                ]);
            }
            elseif($historical_xcp)
            {
                $dividend->update([
                    'fee_paid_usd' => fromSatoshi($historical_xcp->price * $dividend->fee_paid),
                    'quality_score' => $historical_xcp->quality_score,
                ]);
            }
        }

        $dividends = \App\Dividend::where('fee_paid', '>', 0)
            ->where('fee_paid_usd', '=', 0)
            ->orderBy('confirmed_at', 'desc')
            ->get();

        foreach($dividends as $dividend)
        {
            $confirmed_at = $dividend->confirmed_at->toDateString('America/New_York');

            $historical_xcp = \App\PriceHistory::where('ticker', '=', 'XCP')
                ->where('quality_score', '=', 1)
                ->where('confirmed_at', 'like', $confirmed_at . '%')
                ->first();

            if($historical_xcp)
            {
                $dividend->update([
                    'fee_paid_usd' => fromSatoshi($historical_xcp->price * $dividend->fee_paid),
                    'quality_score' => $historical_xcp->quality_score,
                ]);
            }
        }
    }
}