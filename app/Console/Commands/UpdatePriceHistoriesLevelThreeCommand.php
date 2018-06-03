<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdatePriceHistoriesLevelThreeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:price:three';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Price Histories (Level 3)';

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
        $forward_assets = \App\OrderMatch::where('quality_score', '=', 2)
            ->selectRaw('forward_asset as asset')
            ->orderBy('asset', 'desc')
            ->groupBy('asset')
            ->get();

        $backward_assets = \App\OrderMatch::where('quality_score', '=', 2)
            ->selectRaw('backward_asset as asset')
            ->orderBy('asset', 'desc')
            ->groupBy('asset')
            ->get();

        $assets = $forward_assets->concat($backward_assets);

        $tickers = $assets->unique('asset');

        foreach($tickers as $ticker)
        {
            \App\Jobs\UpdatePriceHistoriesLevelThree::dispatch($ticker->asset);
        }
    }
}