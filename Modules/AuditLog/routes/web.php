<?php

use Illuminate\Support\Facades\Route;
use Modules\AuditLog\Http\Controllers\AuditLogController;


Route::middleware(['auth'])
    ->prefix('audit-log')
    ->name('audit.')
    ->group(function () {

        Route::get(
            '/',
            [AuditLogController::class, 'index']
        )->name('index');


        Route::get(
            '/{id}',
            [AuditLogController::class, 'show']
        )->name('show');
    });
