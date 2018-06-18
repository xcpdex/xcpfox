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
        $schedule->command('update:bitcoin')->cron('0 */2 * * *');
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
