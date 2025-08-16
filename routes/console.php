<?php

use Illuminate\Support\Facades\Schedule;

// daily - run every minute (for testing)
Schedule::command('report:send daily')->dailyAt('09:00');
// Schedule::command('report:send daily')->everyMinute();

// weekly - run every minute (for testing)
Schedule::command('report:send weekly')->weeklyOn(1, '09:00');

// monthly - run every minute (for testing)
Schedule::command('report:send monthly')->monthlyOn(1, '09:00');

