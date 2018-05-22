<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdatePriceHistoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Price Histories';

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
        $tickers = ['BTC', 'XCP', 'PEPECASH', 'FLDC', 'BCY', 'DTB'];

        foreach($tickers as $ticker)
        {
            \App\Jobs\UpdatePriceHistories::dispatch($ticker);
        }
    }
}