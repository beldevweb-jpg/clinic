<?php

use Illuminate\Support\Facades\Route;
use Modules\Visits\Http\Controllers\VisitsController;


Route::middleware(['auth'])
    ->group(function () {

        Route::get(
            '/visits',
            [VisitsController::class, 'index']
        )
            ->name('visits.index');
    });
