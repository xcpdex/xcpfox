<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateBetQuantityUsdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:bets:usd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Bets USD';

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
        $bets = \App\Bet::where('wager_quantity', '>', 0)
            ->where('wager_quantity_usd', '=', 0)
            ->orWhere('counterwager_quantity', '>', 0)
            ->where('counterwager_quantity_usd', '=', 0)
            ->orderBy('confirmed_at', 'desc')
            ->get();

        foreach($bets as $bet)
        {
            $confirmed_at = $bet->confirmed_at->toDateString('America/New_York');

            $historical = \App\PriceHistory::where('ticker', '=', 'XCP')
                ->where('quality_score', '=', 1)
                ->where('confirmed_at', 'like', $confirmed_at . '%')
                ->first();

            if($historical)
            {
                $bet->update([
                    'wager_quantity_usd' => fromSatoshi($historical->price * $bet->wager_quantity),
                    'wager_remaining_usd' => fromSatoshi($historical->price * $bet->wager_remaining),
                    'counterwager_quantity_usd' => fromSatoshi($historical->price * $bet->counterwager_quantity),
                    'counterwager_remaining_usd' => fromSatoshi($historical->price * $bet->counterwager_remaining),
                    'quality_score' => $historical->quality_score,
                ]);
            }
        }
    }
}