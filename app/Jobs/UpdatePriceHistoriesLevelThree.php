<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdatePriceHistoriesLevelThree implements ShouldQueue
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
            // Level 3 - Base Asset
            $base_asset = \App\Asset::where('asset_name', '=', $this->ticker)->first();

            // Order Match Daily Summaries (Forward)
            $forward = \App\OrderMatch::where('forward_asset', '=', $base_asset->asset_name)
                ->where('quality_score', '=', 2)
                ->selectRaw('DATE(confirmed_at) as date,
                             SUM(backward_quantity) as backward_quantity,
                             SUM(backward_quantity_usd) as backward_quantity_usd,
                             SUM(forward_quantity) as forward_quantity,
                             SUM(forward_quantity_usd) as forward_quantity_usd')
                ->groupBy('date')
                ->get();

            // Iterate Through Days
            foreach($forward as $f)
            {
                // Order Match Summary Today (Backward)
                $b = \App\OrderMatch::where('backward_asset', '=', $base_asset->asset_name)
                    ->where('confirmed_at', 'like', $f->date . '%')
                    ->where('quality_score', '=', 2)
                    ->selectRaw('SUM(backward_quantity) as backward_quantity,
                                 SUM(backward_quantity_usd) as backward_quantity_usd,
                                 SUM(forward_quantity) as forward_quantity,
                                 SUM(forward_quantity_usd) as forward_quantity_usd')
                    ->first();

                $price_exists = \App\PriceHistory::where('ticker', '=', $base_asset->asset_name)
                    ->where('confirmed_at', 'like', $f->date . '%')
                    ->where('quality_score', '=', 3)
                    ->exists();

                if($price_exists) continue;

                $quantity_normalized = $base_asset->divisible ? bcdiv($f->forward_quantity + $b->backward_quantity, 100000000) : $f->forward_quantity + $b->backward_quantity;
                $volume_usd = $f->forward_quantity_usd + $b->backward_quantity_usd;

                $price = round($volume_usd / $quantity_normalized);

                \App\PriceHistory::firstOrCreate([
                    'ticker' => $base_asset->asset_name,
                    'price' => $price,
                    'timestamp' => \Carbon\Carbon::createFromFormat('Y-m-d', $f->date, 'America/New_York')->timestamp,
                    'quality_score' => 3,
                ],[
                    'confirmed_at' => \Carbon\Carbon::createFromFormat('Y-m-d', $f->date, 'America/New_York'),
                ]);
            }
        }
        catch(\Exception $e)
        {
        }
    }
}