<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateRpsQuantityUsdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:rps:usd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update RPS USD';

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
        $rps_results = \App\Rps::where('wager', '>', 0)
            ->where('wager_usd', '=', 0)
            ->orderBy('confirmed_at', 'desc')
            ->get();

        foreach($rps_results as $rps)
        {
            $confirmed_at = $rps->confirmed_at->toDateString('America/New_York');

            $historical = \App\PriceHistory::where('ticker', '=', 'XCP')
                ->where('quality_score', '=', 1)
                ->where('confirmed_at', 'like', $confirmed_at . '%')
                ->first();

            if($historical)
            {
                $rps->update([
                    'wager_usd' => fromSatoshi($historical->price * $rps->wager),
                    'quality_score' => $historical->quality_score,
                ]);
            }
        }
    }
}