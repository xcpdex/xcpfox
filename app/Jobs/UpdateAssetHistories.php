<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateAssetHistories implements ShouldQueue
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

            $asset = $this->ticker;
            if($this->ticker === 'DTB') $asset = 'DATABITS';
            if($this->ticker === 'BCY') $asset = 'BITCRYSTALS';
            if($this->ticker === 'TRIG') $asset = 'TRIGGERS';

            foreach(['market_cap', 'price', 'volume'] as $type)
            {
                $last = $this->getLastAssetHistory($type, $asset);

                foreach($data->{$type} as $result)
                {
                    // Timestamp
                    $timestamp = round($result[0] / 1000);

                    // Skip Old
                    if($last && $last->timestamp > $timestamp) continue;

                    // Value
                    $value = $type === 'price' ? $result[1] * 100000000 : $result[1];

                    // Existing
                    $asset_history = $this->getExistingHistory($type, $asset, $timestamp);

                    if($asset_history)
                    {
                        $this->updateAssetHistory($asset_history, $value, $timestamp);
                    }
                    else
                    {
                        $this->createAssetHistory($type, $asset, $result, $value, $timestamp);
                    }
                }
            }
        }
        catch(\Exception $e)
        {
        }
    }

    /**
     * Last History
     */
    private function getLastAssetHistory($type, $asset)
    {
        return \App\AssetHistory::where('type', '=', $type)
            ->where('asset', '=', $asset)
            ->where('quality_score', '=', 1)
            ->latest('confirmed_at')
            ->first();
    }

    /**
     * Get Existing 
     */
    private function getExistingHistory($type, $asset, $timestamp)
    {
        $confirmed_at = \Carbon\Carbon::createFromTimestamp($timestamp)->toDateString();
 
        return \App\AssetHistory::where('type', '=', $type)
            ->where('asset', '=', $asset)
            ->where('quality_score', '=', 1)
            ->where('confirmed_at', 'like', $confirmed_at . '%')
            ->first();
    }

    /**
     * Create History 
     */
    private function createAssetHistory($type, $asset, $result, $value, $timestamp)
    {
        return \App\AssetHistory::firstOrCreate([
            'type' => $type,
            'asset' => $asset,
            'value' => $value,
            'timestamp' => $timestamp,
            'quality_score' => 1,
        ],[
            'confirmed_at' => \Carbon\Carbon::createFromTimestamp($timestamp),
        ]);
    }

    /**
     * Update History 
     */
    private function updateAssetHistory($asset_history, $value, $timestamp)
    {
        if($this->isToday($asset_history->confirmed_at->toDateString()))
        {
            return $asset_history->update([
                'value' => $value,
                'timestamp' => $timestamp,
                'quality_score' => 1,
                'confirmed_at' => \Carbon\Carbon::createFromTimestamp($timestamp),
            ]);
        }
    }

    /**
     * Is Today 
     */
    private function isToday($confirmed_at)
    {
        return $confirmed_at === \Carbon\Carbon::now()->toDateString();
    }
}