<?php

use Illuminate\Database\Seeder;

class AssetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Asset::create([
            'asset_id' => 0,
            'asset_name' => 'BTC',
            'block_index' => 0,
            'asset_longname' => null,
            'confirmed_at' => '2009-01-03 18:15:05'
        ]);

        \App\Asset::create([
            'asset_id' => 1,
            'asset_name' => 'XCP',
            'block_index' => 278319,
            'asset_longname' => null,
            'confirmed_at' => '2014-01-02 17:19:37'
        ]);
    }
}
