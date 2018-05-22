<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateStaticPriceHistoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:price:static';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Static Price Histories';

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
        $files = glob('/var/www/xcpfox.com/storage/app/prices/*.csv');

        foreach($files as $file)
        {
            $ticker = str_replace('.csv', '', str_replace('/var/www/xcpfox.com/storage/app/prices/', '', $file));

            if(($handle = fopen($file, "r")) !== FALSE)
            {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
                {
                    if(empty($data[1])) continue;
                    if(\App\PriceHistory::whereTicker($ticker)->where('confirmed_at', 'like', $data[0] . '%')->exists()) continue;

                    \App\PriceHistory::firstOrCreate([
                        'ticker' => $ticker,
                        'price' => $data[1] * 100000000,
                        'timestamp' => \Carbon\Carbon::createFromFormat('Y-m-d', $data[0])->timestamp,
                    ],[
                        'confirmed_at' => \Carbon\Carbon::createFromFormat('Y-m-d', $data[0]),
                    ]);

                }
            }
            fclose($handle);
        }
    }
}