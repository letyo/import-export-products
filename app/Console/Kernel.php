<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ImportProductsFromCsv;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ImportProductsFromCsv::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // Schedule commands here
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
        \App\Console\Commands\ImportProductsFromCsv::class,
        \App\Console\Commands\GenerateProductFeed::class,
    }
}