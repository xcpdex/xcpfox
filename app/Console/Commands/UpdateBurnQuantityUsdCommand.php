<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateBurnQuantityUsdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:burns:usd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Burns USD';

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
        $burns = \App\Burn::where('burned', '>', 0)
            ->where('burned_usd', '=', 0)
            ->orWhere('earned', '>', 0)
            ->where('earned_usd', '=', 0)
            ->orderBy('confirmed_at', 'desc')
            ->get();

        foreach($burns as $burn)
        {
            $confirmed_at = $burn->confirmed_at->toDateString('America/New_York');

            $historical = \App\PriceHistory::where('ticker', '=', 'BTC')
                ->where('quality_score', '=', 1)
                ->where('confirmed_at', 'like', $confirmed_at . '%')
                ->first();

            if($historical)
            {
                $burn->update([
                    'burned_usd' => fromSatoshi($historical->price * $burn->burned),
                    'earned_usd' => fromSatoshi($historical->price * $burn->burned),
                    'quality_score' => $historical->quality_score,
                ]);
            }
        }
    }
}