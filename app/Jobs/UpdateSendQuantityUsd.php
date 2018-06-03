<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateSendQuantityUsd implements ShouldQueue
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
            // Get Sends w/ No QS or Lower QS
            \App\Send::where('asset', '=', $this->ticker)
                ->where('quality_score', '=', 0)
                ->orWhere('asset', '=', $this->ticker)
                ->where('quality_score', '>', $this->quality_score)
                ->orderBy('confirmed_at', 'desc')
                ->chunk(1000, function ($sends)
            {
                // Iterate Through Sends
                foreach($sends as $send)
                {
                    // Get USD Price
                    $historical = $this->getHistoricalPriceData($send);

                    // Update or Skip
                    if($historical)
                    {
                        $quantity_usd = $send->assetModel->divisible ? bcdiv(bcmul($historical->price, $send->quantity), 100000000) : bcmul($historical->price, $send->quantity);

                        $send->update([
                            'quantity_usd' => $quantity_usd,
                            'quality_score' => $historical->quality_score,
                        ]);
                    }
                }
            });
        }
        catch(\Exception $e)
        {
            \Storage::append('failed.log', 'Sends USD: ' . serialize($e->getMessage()));
        }
    }

    private function getHistoricalPriceData($send)
    {
        if($this->quality_score < 4)
        {
            // Get Send Date
            $confirmed_at = $send->confirmed_at->toDateString('America/New_York');

            return \App\PriceHistory::where('ticker', '=', $this->ticker)
                ->where('quality_score', '=', $this->quality_score)
                ->where('confirmed_at', 'like', $confirmed_at . '%')
                ->first();
        }
        else
        {
            // Get Send Date +3
            $after_date = $send->confirmed_at->addDays(3);

            // Get Send Date -3
            $before_date = $send->confirmed_at->subDays(3);

            return \App\PriceHistory::where('ticker', '=', $this->ticker)
                ->where('confirmed_at', '<', $after_date)
                ->where('confirmed_at', '>', $before_date)
                ->orderBy('quality_score', 'asc')
                ->first();
        }
    }
}