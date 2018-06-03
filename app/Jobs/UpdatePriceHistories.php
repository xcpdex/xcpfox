<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdatePriceHistories implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ticker;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ticker)
    {
        $this->ticker = $ticker;
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
            $data = json_decode(file_get_contents('https://coincap.io/history/' . $this->ticker, true));

            $this_ticker = $this->ticker;
            if($this->ticker === 'DTB') $this_ticker = 'DATABITS';
            if($this->ticker === 'BCY') $this_ticker = 'BITCRYSTALS';

            $last = \App\AssetHistory::where('type', '=', 'price')
                ->where('asset', '=', $this_ticker)
                ->where('quality_score', '=', 1)
                ->latest('confirmed_at')
                ->first();

            foreach($data->price as $result)
            {
                if($last && $last->timestamp > round($result[0] / 1000)) continue;

                $confirmed_at = \Carbon\Carbon::createFromTimestamp(round($result[0] / 1000))->toDateString();

                $price_exists = \App\AssetHistory::where('type', '=', 'price')
                    ->where('asset', '=', $this_ticker)
                    ->where('quality_score', '=', 1)
                    ->where('confirmed_at', 'like', $confirmed_at . '%')
                    ->exists();

                if($price_exists) continue;

                \App\AssetHistory::firstOrCreate([
                    'type' => 'price',
                    'asset' => $this_ticker,
                    'value' => $result[1] * 100000000,
                    'timestamp' => round($result[0] / 1000),
                    'quality_score' => 1,
                ],[
                    'confirmed_at' => \Carbon\Carbon::createFromTimestamp(round($result[0] / 1000)),
                ]);
            }
        }
        catch(\Exception $e)
        {
        }
    }
}