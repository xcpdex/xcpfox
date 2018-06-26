<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\AssetWasCreated' => [
            'App\Listeners\ReportAssetCreation',
        ],
        'App\Events\IssuanceWasCreated' => [
            'App\Listeners\NormalizeIssuanceQuantity',
            'App\Listeners\AssetCreateFromIssuance',
            'App\Listeners\AssetUpdateFromIssuance',
            'App\Listeners\FlushIssuanceAndAssetCache',
        ],
        'App\Events\SendWasCreated' => [
            'App\Listeners\ReportLargeDeposits',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
