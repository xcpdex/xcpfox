<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateBetMatchQuantityUsdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:betmatches:usd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Bet Matches USD';

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
        $bet_matches = \App\BetMatch::where('forward_quantity', '>', 0)
            ->where('forward_quantity_usd', '=', 0)
            ->orWhere('backward_quantity', '>', 0)
            ->where('backward_quantity_usd', '=', 0)
            ->orderBy('confirmed_at', 'desc')
            ->get();

        foreach($bet_matches as $bet_match)
        {
            $confirmed_at = $bet_match->confirmed_at->toDateString('America/New_York');

            $historical = \App\PriceHistory::where('ticker', '=', 'XCP')
                ->where('quality_score', '=', 1)
                ->where('confirmed_at', 'like', $confirmed_at . '%')
                ->first();

            if($historical)
            {
                $bet_match->update([
                    'forward_quantity_usd' => fromSatoshi($historical->price * $bet_match->forward_quantity),
                    'backward_quantity_usd' => fromSatoshi($historical->price * $bet_match->backward_quantity),
                    'quality_score' => $historical->quality_score,
                ]);
            }
        }
    }
}