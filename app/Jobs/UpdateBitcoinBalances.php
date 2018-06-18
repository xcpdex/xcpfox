<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateBitcoinBalances implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \App\Address::where('type', '!=', 'multisig')->chunk(1000, function($targets)
        {
            $addresses = $targets->pluck('address')->toArray();

            $api = $this->getBalances($addresses);

            $this->updateBalances($api);

            sleep(30);
        });
    }

    private function getBalances($addresses)
    {
        $message = json_encode(['addr' => implode(' ', $addresses)]);

        // API URL
        $url = 'https://www.blockonomics.co/api/balance';

        // Define headers
        $headers = [
            'Content-Type:application/json',
            'Authorization: Bearer ' . env('BLOCKONOMICS_API_KEY')
        ];

        // Send a POST message to API URL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }


    private function updateBalances($api)
    {
        if(isset($api->response))
        {
            foreach($api->response as $result)
            {
                $this->updateOrCreateBalance($result);
            }
        }
    }

    private function updateOrCreateBalance($result)
    {
        if($block_index = \Cache::get('block_height'))
        {
            return \App\Balance::updateOrCreate([
                'address' => $result->addr,
                'asset' => 'BTC',
                'current' => 1,
            ],[
                'quantity' => $result->confirmed,
                'block_index' => $block_index,
                'confirmed_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}