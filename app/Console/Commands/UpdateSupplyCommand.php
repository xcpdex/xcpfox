<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateSupplyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:supply';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update BTC/XCP Supply';

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
        $assets = \App\Asset::whereIn('asset_name', ['BTC', 'XCP'])->get();

        foreach($assets as $asset)
        {
            \App\Jobs\UpdateSupply::dispatch($asset);
        }
    }
}