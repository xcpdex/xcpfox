<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReportPricesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report Prices';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $text = $this->getAlertText();

        \App\Jobs\SendTelegramMessage::dispatch($text);
    }

    /**
     * Alert Text
     */
    private function getAlertText()
    {
        $histories = \App\AssetHistory::latest('confirmed_at')
            ->distinct('asset')
            ->take(7)
            ->get()
            ->sortByDesc('value');

        $text = "*Market Prices*";

        foreach($histories as $history)
        {
            $asset = $history->asset;
            $price = '$' . number_format(fromSatoshi($history->value), 2);
            $link = url(route('assets.show', ['asset' => $asset]));
            $spaces = $this->getSpaces($asset);

            $text .= "\n[{$asset}]({$link}) {$spaces} {$price}";
        }

        return $text;
    }

    private function getSpaces($asset)
    {
        $spaces = [
            'BTC' => '................',
            'XCP' => '.......................',
            'TRIGGERS' => '.............',
            'DATABITS' => '..............',
            'BITCRYSTALS' => '........',
            'PEPECASH' => '............',
            'FLDC' => '......................',
        ];

        return $spaces[$asset];
    }
}