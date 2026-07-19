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


        Route::get(
            '/visits/create',
            [VisitsController::class, 'create']
        )
            ->name('visits.create');


        Route::post(
            '/visits',
            [VisitsController::class, 'store']
        )
            ->name('visits.store');


        Route::get(
            '/visits/{id}/edit',
            [VisitsController::class, 'edit']
        )
            ->name('visits.edit');


        Route::put(
            '/visits/{id}',
            [VisitsController::class, 'update']
        )
            ->name('visits.update');


        Route::delete(
            '/visits/{id}',
            [VisitsController::class, 'destroy']
        )
            ->name('visits.destroy');
    });
