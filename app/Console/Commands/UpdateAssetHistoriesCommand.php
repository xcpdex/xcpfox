<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateAssetHistoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:histories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Asset Histories';

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
        $tickers = ['BTC', 'XCP', 'PEPECASH', 'FLDC', 'BCY', 'DTB', 'TRIG'];

        foreach($tickers as $ticker)
        {
            \App\Jobs\UpdateAssetHistories::dispatch($ticker);
        }
    }
}