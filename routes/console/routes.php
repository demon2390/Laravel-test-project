<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schedule;

// Deleting expires password reset tokens
Schedule::command('auth:clear-resets')->everyFifteenMinutes();

Schedule::command('ping')->everyMinute();
