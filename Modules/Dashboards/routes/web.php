<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboards\Http\Controllers\DashboardsController;


Route::get('/dashboard', function () {
    return redirect()->route('dashboards.index');
})->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboards', [
        DashboardsController::class,
        'index'
    ])->name('dashboards.index');

    Route::get('/visits/visitsList',[DashboardsController::class,'visitsList'])->name('visitsList');
});
