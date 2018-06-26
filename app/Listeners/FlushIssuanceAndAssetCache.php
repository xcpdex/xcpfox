<?php

namespace App\Listeners;

use App\Events\IssuanceWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FlushIssuanceAndAssetCache
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
        \Cache::tags([
            'issuance_flush',
            $event->issuance->asset
        ])->flush();
    }
}
