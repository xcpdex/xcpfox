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
    protected $signature = 'update:sends:usd {quality_score}';

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
        // Set Quality Score
        $quality_score = $this->argument('quality_score');

        // Get Asset Tickers
        $tickers = $this->getPriceHistoryTickers($quality_score);

        // Estimate Send USD
        foreach($tickers as $ticker)
        {
            \App\Jobs\UpdateSendQuantityUsd::dispatch($ticker->ticker, $quality_score);
        }
    }

    private function getPriceHistoryTickers($quality_score)
    {
        if($quality_score < 4)
        {
            return \App\PriceHistory::where('quality_score', '=', $quality_score)
                ->select('ticker')
                ->groupBy('ticker')
                ->get();
        }
        else
        {
            return \App\PriceHistory::select('ticker')
                ->groupBy('ticker')
                ->get();
        }
    }
}