<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboards\Http\Controllers\DashboardsController;

Route::middleware(['auth', 'role:1'])->group(function () {
    Route::resource('dashboards', DashboardsController::class);
});
