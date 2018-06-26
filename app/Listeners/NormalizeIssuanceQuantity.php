<?php

namespace App\Listeners;

use App\Events\IssuanceWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NormalizeIssuanceQuantity
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
        $event->issuance->update([
            'quantity_normalized' => $event->issuance->divisible ? fromSatoshi($event->issuance->quantity) : sprintf("%.8f", $event->issuance->quantity)
        ]);
    }
}
