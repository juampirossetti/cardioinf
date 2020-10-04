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
        //
        '\App\Console\Commands\DeleteOldReservations',
        '\App\Console\Commands\SendVouchers'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('inspire')
        //         ->everyMinute();
        //eliminar turnos reservados con antiguedad
        $schedule->command('DeleteOldReservations:deletereservations')->everyFiveMinutes();

        //enviar los emails con recordatorios de los turnos proximos (48 hs antes)
        //$schedule->command('SendVouchers:send')->everyFiveMinutes();
        $schedule->command('SendVouchers:send')->dailyAt('02:00');

        //backup de la base de datos a dropbox
        
        $schedule->command('db:backup --database=mysql --destination=dropbox --destinationPath=sismed_ --timestamp="d-m-Y H:i" --compression=gzip')
                 ->appendOutputTo(storage_path('logs/cron/backup.cron.log'))
                 ->hourly();
        
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
