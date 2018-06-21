<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\BlockHeightCommand::class,
        Commands\UpdateBitcoinBalancesCommand::class,
        Commands\UpdateBlocksCommand::class,
        Commands\UpdateMempoolCommand::class,
        Commands\UpdatePriceHistoriesCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('block:height')->everyMinute();
        $schedule->command('update:mempool')->everyMinute();
        $schedule->command('horizon:snapshot')->everyFiveMinutes();
        $schedule->command('update:bitcoin 0 20000')->twiceDaily(1, 13);
        $schedule->command('update:bitcoin 20000 20000')->twiceDaily(2, 14);
        $schedule->command('update:bitcoin 40000 20000')->twiceDaily(3, 15);
        $schedule->command('update:bitcoin 60000 20000')->twiceDaily(4, 16);
        $schedule->command('update:bitcoin 80000 20000')->twiceDaily(5, 17);
        $schedule->command('update:bitcoin 100000 20000')->twiceDaily(6, 18);
        $schedule->command('update:bitcoin 120000 20000')->twiceDaily(7, 19);
        $schedule->command('update:bitcoin 140000 20000')->twiceDaily(8, 20);
        $schedule->command('update:bitcoin 160000 20000')->twiceDaily(9, 21);
        $schedule->command('update:bitcoin 180000 20000')->twiceDaily(10, 22);
        $schedule->command('update:bitcoin 200000 20000')->twiceDaily(11, 23);
        $schedule->command('update:price')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
