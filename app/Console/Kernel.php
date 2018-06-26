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
        Commands\UpdateAssetHistoriesCommand::class,
        Commands\UpdateBitcoinBalancesCommand::class,
        Commands\UpdateBlocksCommand::class,
        Commands\UpdateMempoolCommand::class,
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
        $schedule->command('update:mempool')->everyFiveMinutes();
        $schedule->command('horizon:snapshot')->everyFiveMinutes();
        $schedule->command('update:histories')->hourly();
        $schedule->command('update:supply')->hourly();
        $schedule->command('report:mempool')->hourly();
        $schedule->command('report:prices')->twiceDaily(12, 22);
        $schedule->command('update:bitcoin 0 20000')->dailyAt('00:30');
        $schedule->command('update:bitcoin 20000 20000')->dailyAt('01:00');
        $schedule->command('update:bitcoin 40000 20000')->dailyAt('01:30');
        $schedule->command('update:bitcoin 60000 20000')->dailyAt('02:00');
        $schedule->command('update:bitcoin 80000 20000')->dailyAt('02:30');
        $schedule->command('update:bitcoin 100000 20000')->dailyAt('03:00');
        $schedule->command('update:bitcoin 120000 20000')->dailyAt('03:30');
        $schedule->command('update:bitcoin 140000 20000')->dailyAt('04:00');
        $schedule->command('update:bitcoin 160000 20000')->dailyAt('04:30');
        $schedule->command('update:bitcoin 180000 20000')->dailyAt('05:00');
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
