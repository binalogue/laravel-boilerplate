<?php

namespace Support\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule): void
    {
        if (config('telescope.enabled')) {
            $schedule
                ->command('telescope:prune --hours=72')
                ->daily();
        }

        $schedule
            ->command('horizon:snapshot')
            ->everyFiveMinutes();
    }

    protected function commands(): void
    {
        $this->load(base_path('app/App/Console'));

        require base_path('routes/console.php');
    }
}
