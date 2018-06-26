<?php

namespace App\Listeners;

use App\Events\IssuanceWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AssetUpdateFromIssuance
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  IssuanceWasCreated  $event
     * @return void
     */
    public function handle(IssuanceWasCreated $event)
    {
        // Get Asset By Name From Issuance
        $asset = \App\Asset::whereAssetName($event->issuance->asset)->firstOrFail(); // Should not fail

        // Check If Issuance Is Creation Event
        // Only Update On Subsequent Issuances
        if($asset->tx_index !== $event->issuance->tx_index)
        {
            $asset->update([
                'owner' => $event->issuance->issuer,
                'description' => $event->issuance->description,
                'issuance' => $asset->issuance + $event->issuance->quantity,
                'issuance_normalized' => $asset->issuance_normalized + $event->issuance->quantity_normalized,
                'locked' => ! $asset->locked && $event->issuance->locked ? 1 : $asset->locked,
                'confirmed_at' => $asset->confirmed_at,
            ]);
        }
    }
}
