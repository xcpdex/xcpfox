<?php

namespace App\Listeners;

use App\Events\AssetWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportAssetCreation
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
     * @param  AssetWasCreated  $event
     * @return void
     */
    public function handle(AssetWasCreated $event)
    {
        $text = $this->getAlertText($event);

        \App\Jobs\SendTelegramMessage::dispatch($text);
    }

    /**
     * Alert Text
     */
    private function getAlertText($event)
    {
        $asset = $event->asset->display_name;
        $link = $event->asset->transaction->url;

        return "*{$asset}* was registered. ([view]({$link}))";
    }
}
