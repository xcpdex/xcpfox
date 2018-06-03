<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateOrderMatchQuantityUsd implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ticker;
    protected $quality_score;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ticker, $quality_score)
    {
        $this->ticker = $ticker;
        $this->quality_score = $quality_score;
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
            // Re-Use Code for Forwards + Backwards
            foreach(['forward', 'backward'] as $key)
            {
                // Dynamic Keys
                $key_asset = "{$key}_asset";
                $key_quantity = "{$key}_quantity";
                $key_quantity_usd = "{$key}_quantity_usd";

                // Get Order Matches w/ No QS or Lower QS
                \App\OrderMatch::where($key_asset, '=', $this->ticker)
                    ->where('quality_score', '=', 0)
                    ->orWhere($key_asset, '=', $this->ticker)
                    ->where('quality_score', '>', $this->quality_score)
                    ->orderBy('confirmed_at', 'desc')
                    ->chunk(1000, function ($order_matches) use ($key_asset, $key_quantity, $key_quantity_usd)
                {
                    // Iterate Through Order Matches
                    foreach($order_matches as $order_match)
                    {
                        // Get USD Price
                        $historical = $this->getHistoricalPriceData($order_match);

                        // Update or Skip
                        if($historical)
                        {
                            $relation = camel_case($key_asset) . 'Model';
                            $quantity_usd = $order_match->{$relation}->divisible ? bcdiv(bcmul($historical->price, $order_match->{$key_quantity}), 100000000) : bcmul($historical->price, $order_match->{$key_quantity});

                            $order_match->update([
                                $key_quantity_usd => $quantity_usd,
                                'quality_score' => $this->quality_score,
                            ]);
                        }
                    }
                });
            }

            // Forward USD Known - Backward USD Unknown
            $order_matches = \App\OrderMatch::where('forward_quantity', '>', 0)
                ->where('forward_quantity_usd', '>', 0)
                ->where('backward_quantity', '>', 0)
                ->where('backward_quantity_usd', '=', 0)
                ->where('quality_score', '=', $this->quality_score)
                ->get();

            foreach($order_matches as $order_match)
            {
                $order_match->update([
                    'backward_quantity_usd' => $order_match->forward_quantity_usd,
                ]);
            }

            // Forward USD Unknown - Backward USD Known
            $order_matches = \App\OrderMatch::where('forward_quantity', '>', 0)
                ->where('forward_quantity_usd', '=', 0)
                ->where('backward_quantity', '>', 0)
                ->where('backward_quantity_usd', '>', 0)
                ->where('quality_score', '=', $this->quality_score)
                ->get();

            foreach($order_matches as $order_match)
            {
                $order_match->update([
                    'forward_quantity_usd' => $order_match->backward_quantity_usd,
                ]);
            }
        }
        catch(\Exception $e)
        {
            \Storage::append('failed.log', 'Order Match USD: ' . serialize($e->getMessage()));
        }
    }

    private function getHistoricalPriceData($order_match)
    {
        if($this->quality_score < 4)
        {
            // Get Send Date
            $confirmed_at = $order_match->confirmed_at->toDateString('America/New_York');

            return \App\PriceHistory::where('ticker', '=', $this->ticker)
                ->where('quality_score', '=', $this->quality_score)
                ->where('confirmed_at', 'like', $confirmed_at . '%')
                ->first();
        }
        else
        {
            // Get Send Date +3
            $after_date = $order_match->confirmed_at->addDays(3);

            // Get Send Date -3
            $before_date = $order_match->confirmed_at->subDays(3);

            return \App\PriceHistory::where('ticker', '=', $this->ticker)
                ->where('confirmed_at', '<', $after_date)
                ->where('confirmed_at', '>', $before_date)
                ->orderBy('quality_score', 'asc')
                ->first();
        }
    }
}