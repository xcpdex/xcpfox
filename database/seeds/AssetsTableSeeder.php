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
            'type' => 'asset',
            'divisible' => 1,
            'issuance' => $this->getSupply('BTC'),
            'issuance_normalized' => fromSatoshi($this->getSupply('BTC')),
            'asset_name' => 'BTC',
            'block_index' => 0,
            'asset_longname' => null,
            'confirmed_at' => '2009-01-03 18:15:05'
        ]);

        \App\Asset::create([
            'type' => 'asset',
            'divisible' => 1,
            'issuance' => $this->getSupply('XCP'),
            'issuance_normalized' => fromSatoshi($this->getSupply('XCP')),
            'asset_name' => 'XCP',
            'block_index' => 278319,
            'asset_longname' => null,
            'confirmed_at' => '2014-01-02 17:19:37'
        ]);
    }

    private function getSupply($asset)
    {
        $counterparty = new \JsonRPC\Client(env('CP_API'));
        $counterparty->authentication(env('CP_USER'), env('CP_PASS'));

        return $counterparty->execute('get_supply', ['asset' => $asset]);
    }
}
