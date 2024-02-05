<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Mixins;
use App\Models\Tenant;
use App\Service\TenantServcie;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\DatabaseBackUp',
        'App\Console\Commands\DBBackUp',
        'App\Console\Commands\Report',


    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $tenants = Tenant::get();
        $tenants->each(
            function ($tenant) use($schedule){
                (new TenantServcie)->switchToTenant($tenant);
                $send_time = Mixins::select('send_time')->where('id', 1)->first();
                $schedule->command('send:Report')->dailyAt($send_time->send_time);
            }
        );
        $schedule->command('database:backup')->everyThreeHours();
        $schedule->command('DB:BackUp')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
