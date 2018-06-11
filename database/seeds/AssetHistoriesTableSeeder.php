<?php

use Illuminate\Database\Seeder;

class AssetHistoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
                    if(\App\AssetHistory::whereType('price')->whereAsset($ticker)->where('confirmed_at', 'like', $data[0] . '%')->exists()) continue;

                    \App\AssetHistory::firstOrCreate([
                        'type' => 'price',
                        'asset' => $ticker,
                        'value' => $data[1] * 100000000,
                        'timestamp' => \Carbon\Carbon::createFromFormat('Y-m-d', $data[0])->timestamp,
                        'quality_score' => 1,
                    ],[
                        'confirmed_at' => \Carbon\Carbon::createFromFormat('Y-m-d', $data[0]),
                    ]);

                }
            }
            fclose($handle);
        }
    }
}
