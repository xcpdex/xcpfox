<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateBetMatchResolutionQuantityUsdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:betmatchresolutions:usd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Bet Match Resolutions USD';

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
        $bet_match_resolutions = \App\BetMatchResolution::where('bull_credit', '>', 0)
            ->where('bull_credit_usd', '=', 0)
            ->orWhere('bear_credit', '>', 0)
            ->where('bear_credit_usd', '=', 0)
            ->orWhere('fee', '>', 0)
            ->where('fee_usd', '=', 0)
            ->orWhere('escrow_less_fee', '>', 0)
            ->where('escrow_less_fee_usd', '=', 0)
            ->orderBy('confirmed_at', 'desc')
            ->get();

        foreach($bet_match_resolutions as $bet_match_resolution)
        {
            $confirmed_at = $bet_match_resolution->confirmed_at->toDateString('America/New_York');

            $historical = \App\PriceHistory::where('ticker', '=', 'XCP')
                ->where('quality_score', '=', 1)
                ->where('confirmed_at', 'like', $confirmed_at . '%')
                ->first();

            if($historical)
            {
                $bet_match_resolution->update([
                    'bull_credit_usd' => fromSatoshi($historical->price * $bet_match_resolution->bull_credit),
                    'bear_credit_usd' => fromSatoshi($historical->price * $bet_match_resolution->bear_credit),
                    'escrow_less_fee_usd' => fromSatoshi($historical->price * $bet_match_resolution->escrow_less_fee),
                    'fee_usd' => fromSatoshi($historical->price * $bet_match_resolution->fee),
                    'quality_score' => $historical->quality_score,
                ]);
            }
        }
    }
}