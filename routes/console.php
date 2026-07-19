<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('audit:clean')
    ->monthly();

Schedule::command('backup:run')
    ->daily();
