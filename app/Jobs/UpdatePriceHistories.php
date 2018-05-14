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
        $data = json_decode(file_get_contents('https://coincap.io/history/' . $this->ticker, true));

        $last = \App\PriceHistory::whereTicker($this->ticker)->latest('confirmed_at')->first();

        foreach($data->price as $result)
        {
            $price = $result[1] * 100000000;
            $timestamp = round($result[0] / 1000);

            if($last && $last->timestamp > $timestamp) continue;

            \App\PriceHistory::firstOrCreate([
                'ticker' => $this->ticker,
                'price' => $price,
                'timestamp' => $timestamp,
            ],[
                'confirmed_at' => \Carbon\Carbon::createFromTimestamp($timestamp, 'America/New_York'),
            ]);
        }
    }
}