<?php

namespace App\Listeners;

use App\Events\SendWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportLargeDeposits
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
     * @param  SendWasCreated  $event
     * @return void
     */
    public function handle(SendWasCreated $event)
    {
        if($this->isTrackedAddress($event->send->destination) &&
           $this->isTrackedAsset($event->send->asset) &&
           $this->isReportWorthy($event->send->asset, $event->send->quantity))
        {
            $text = $this->getAlertText($event);

            \App\Jobs\SendTelegramMessage::dispatch($text);
        }
    }

    /**
     * Alert Text
     */
    private function getAlertText($event)
    {
        $asset = $event->send->asset;
        $link = $event->send->transaction->url;
        $quantity = number_format($event->send->quantity_normalized);
        $exchange = $this->getExchangeName($event->send->destination);
        $exchange_link = $this->getExchangeLink($event->send->destination, $event->send->asset);

        return "*{$quantity} {$asset}* sent to [{$exchange}]({$exchange_link}). ([view]({$link}))";
    }

    /**
     * Exchanges
     */
    private function isTrackedAddress($address)
    {
        return in_array($address, [
            '1AeqgtHedfA2yVXH6GiKLS2JGkfWfgyTC6',
            '1FoWyxwPXuj4C6abqwhjDWdz6D4PZgYRjA',
            '1PNkBxnz5ePW8FeK6CSs8V2fGHcN9B6HNk',
            '1AqUTSTGB6coR5AYcwFFM6nXoULapXqtdL',
            '1XCPdWb6kk7PGfvbdRbRuNh51aPc4vqC7',
            '1SJCXrYsuWmZzmAhA9K4fYkKqgGyLim79',
            '1BCYpzZAmH3pX7EXU6s4gxtG1AoVMn2NfJ',
            '1FLDCfr9iG7n6bAdGsqBXmhaLgC4aSze72',
        ]);
    }

    /**
     * Exchange Name
     */
    private function getExchangeName($address)
    {
        $exchanges = [
            '1AeqgtHedfA2yVXH6GiKLS2JGkfWfgyTC6' => 'Bittrex',
            '1FoWyxwPXuj4C6abqwhjDWdz6D4PZgYRjA' => 'Binance',
            '1PNkBxnz5ePW8FeK6CSs8V2fGHcN9B6HNk' => 'Zaif',
            '1AqUTSTGB6coR5AYcwFFM6nXoULapXqtdL' => 'Tux',
            '1XCPdWb6kk7PGfvbdRbRuNh51aPc4vqC7' => 'Poloniex',
            '1SJCXrYsuWmZzmAhA9K4fYkKqgGyLim79' => 'Poloniex',
            '1BCYpzZAmH3pX7EXU6s4gxtG1AoVMn2NfJ' => 'Poloniex',
            '1FLDCfr9iG7n6bAdGsqBXmhaLgC4aSze72' => 'Poloniex',
        ];

        return $exchanges[$address];
    }

    /**
     * Exchange Link
     */
    private function getExchangeLink($address, $asset)
    {
        $exchanges = [
            '1AeqgtHedfA2yVXH6GiKLS2JGkfWfgyTC6' => [
                'BITCRYSTALS' => 'https://bittrex.com/Market/Index?MarketName=BTC-BCY',
                'DATABITS' => 'https://bittrex.com/Market/Index?MarketName=BTC-DTB',
                'FLDC' => 'https://bittrex.com/Market/Index?MarketName=BTC-FLDC',
                'TRIGGERS' => 'https://bittrex.com/Market/Index?MarketName=BTC-TRIG',
                'XCP' => 'https://bittrex.com/Market/Index?MarketName=BTC-XCP',
            ],
            '1FoWyxwPXuj4C6abqwhjDWdz6D4PZgYRjA' => [
                'TRIGGERS' => 'https://www.binance.com/en/trade/TRIG_BTC',
            ],
            '1PNkBxnz5ePW8FeK6CSs8V2fGHcN9B6HNk' => [
                'BITCRYSTALS' => 'https://zaif.jp/trade/bitcrystals_btc',
                'PEPECASH' => 'https://zaif.jp/token_trade/pepecash_btc',
                'SJCX' => 'https://zaif.jp/trade/sjcx_btc',
                'XCP' => 'https://zaif.jp/trade/xcp_btc',
            ],
            '1AqUTSTGB6coR5AYcwFFM6nXoULapXqtdL' => [
                'BITCRYSTALS' => 'https://tuxexchange.com/trade?coin=BCY&market=BTC',
                'DATABITS' => 'https://tuxexchange.com/trade?coin=DTB&market=BTC',
                'PEPECASH' => 'https://tuxexchange.com/trade?coin=PEPECASH&market=BTC',
                'XCP' => 'https://tuxexchange.com/trade?coin=XCP&market=BTC',
            ],
            '1XCPdWb6kk7PGfvbdRbRuNh51aPc4vqC7' => [
                'XCP' => 'https://poloniex.com/exchange#btc_xcp',
            ],
            '1SJCXrYsuWmZzmAhA9K4fYkKqgGyLim79' => [
                'SJCX' => 'https://poloniex.com/exchange#btc_sjcx',
            ],
            '1BCYpzZAmH3pX7EXU6s4gxtG1AoVMn2NfJ' => [
                'BITCRYSTALS' => 'https://poloniex.com/exchange#btc_bcy',
            ],
            '1FLDCfr9iG7n6bAdGsqBXmhaLgC4aSze72' => [
                'FLDC' => 'https://poloniex.com/exchange#btc_fldc',
            ],
        ];

        return $exchanges[$address][$asset];
    }

    /**
     * Assets
     */
    private function isTrackedAsset($asset)
    {
        return in_array($asset, [
            'XCP',
            'TRIGGERS',
            'FLDC',
            'BITCRYSTALS',
            'PEPECASH',
            'DATABITS',
        ]);
    }

    /**
     * Report?
     */
    private function isReportWorthy($asset, $quantity)
    {
        return $quantity > $this->getReportThreshold($asset);
    }

    /**
     * Threshold
     */
    private function getReportThreshold($asset)
    {
        $thresholds = [
            'BITCRYSTALS' => 1000000000000,
            'FLDC' => 10000000000000,
            'PEPECASH' => 10000000000000,
            'DATABITS' => 1000000000000,
            'TRIGGERS' => 10000000000000,
            'XCP' => 20000000000,
        ];

        return $thresholds[$asset];
    }
}
