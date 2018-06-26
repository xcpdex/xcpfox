<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReportMempoolCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:mempool';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report Mempool';

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
        // TXs waiting an hour or more
        $mempool_size = \App\Mempool::doesntHave('transaction')
            ->where('created_at', '<', \Carbon\Carbon::now()->subHours(1))
            ->where('created_at', '>', \Carbon\Carbon::now()->subDays(1))
            ->count();

        if(\Cache::get('report_mempool'))
        {
            // Reporting threshold
            if($mempool_size < 20)
            {
                $text = $this->getAlertText($mempool_size, false);

                \App\Jobs\SendTelegramMessage::dispatch($text);

                \Cache::forget('report_mempool');
            }
        }
        else
        {
            // Reporting threshold
            if($mempool_size > 200)
            {
                $text = $this->getAlertText($mempool_size);

                \App\Jobs\SendTelegramMessage::dispatch($text);

                \Cache::put('report_mempool', true, 60  * 24);
            }
        }
    }

    /**
     * Alert Text
     */
    private function getAlertText($count, $active=true)
    {
        $link_one = url(route('mempool.index'));
        $link_two = 'https://jochen-hoenicke.de/queue/';

        if($active)
        {
            return "*Alert:* Mempool Rising ({$count}+)\n([XCP]($link_one)) ([BTC]($link_two))";
        }
        else
        {
            return "*Alert:* Mempool Cleared\n([XCP]($link_one)) ([BTC]($link_two))";
        }
    }
}