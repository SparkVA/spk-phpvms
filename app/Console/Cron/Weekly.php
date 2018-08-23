<?php

namespace App\Console\Cron;

use App\Console\Command;
use App\Events\CronWeekly;

/**
 * This just calls the CronWeekly event, so all of the
 * listeners, etc can just be called to run those tasks.
 *
 * The actual cron tasks are in app/Cron
 *
 * @package App\Console\Cron
 */
class Weekly extends Command
{
    protected $signature = 'cron:weekly';
    protected $description = 'Run the weekly cron tasks';
    protected $schedule;

    /**
     *
     */
    public function handle(): void
    {
        $this->redirectLoggingToStdout('cron');
        event(new CronWeekly());
    }
}
