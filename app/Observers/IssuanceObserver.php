<?php

namespace App\Observers;

class IssuanceObserver
{
    /**
     * Listen to the Issuance created event.
     *
     * @param  \App\Issuance  $issuance
     * @return void
     */
    public function created(\App\Issuance  $issuance)
    {
        // Normalization
        $issuance->update([
            'quantity_normalized' => $issuance->divisible ? fromSatoshi($issuance->quantity) : sprintf("%.8f", $issuance->quantity)
        ]);

        // Create Asset
        $asset = \App\Asset::firstOrCreateAsset($issuance);

        // Update Asset
        if(! $asset->wasRecentlyCreated)
        {
            $asset->update([
                'owner' => $issuance->issuer,
                'description' => $issuance->description,
                'issuance' => $asset->issuance + $issuance->quantity,
                'issuance_normalized' => $asset->issuance_normalized + $issuance->quantity_normalized,
                'locked' => ! $asset->locked && $issuance->locked ? 1 : $asset->locked,
                'confirmed_at' => $asset->confirmed_at,
            ]);
        }

        \Cache::tags(['issuance_flush', $asset->asset_name])->flush();
    }
}