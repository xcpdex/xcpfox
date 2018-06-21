<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateEnhancedAssetInfo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $asset;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(\App\Asset $asset)
    {
        $this->asset = $asset;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $context = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ];

        if('http' != substr($this->asset->description, 0, 4))
        {
            $url_http = 'http://' . $this->asset->description;
            $url_https = 'https://' . $this->asset->description;

            try {
                $data = file_get_contents($url_http, false, stream_context_create($context));
            } catch (\Exception $e) {
                try {
                    $data = file_get_contents($url_https, false, stream_context_create($context));
                } catch(\Exception $e) {}
            }
        }
        else
        {
            try {
                $data = file_get_contents($this->asset->description, false, stream_context_create($context));
            } catch (\Exception $e) {}
        }

        if(isset($data))
        {
            try {
                $this->asset->update(['meta' => $data]);
            } catch (\Exception $e) {
                $this->asset->update(['meta' => mb_convert_encoding($data, 'UTF-8', 'UTF-8')]);
            }
        }
    }
}
