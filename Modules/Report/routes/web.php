<?php

use Illuminate\Support\Facades\Route;
use Modules\Report\Http\Controllers\ReportController;

Route::middleware(['auth'])->group(function () {
    Route::resource('reports', ReportController::class)->names('report');
});
