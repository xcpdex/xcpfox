<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateSupply implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $counterparty;
    protected $asset;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(\App\Asset $asset)
    {
        $this->counterparty = new \JsonRPC\Client(env('CP_API'));
        $this->counterparty->authentication(env('CP_USER'), env('CP_PASS'));
        $this->asset = $asset;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try
        {
            $issuance = $this->getSupply();

            $this->asset->update([
                'issuance' => $issuance,
                'issuance_normalized' => fromSatoshi($issuance),
                'confirmed_at' => $this->asset->confirmed_at,
            ]);
        }
        catch(\Exception $e)
        {
            // API 404s Frequently
        }
    }

    /**
     * Counterparty API
     * https://counterparty.io/docs/api/#get_supply
     */
    private function getSupply()
    {
        return $this->counterparty->execute('get_supply', ['asset' => $this->asset->asset_name]);
    }
}