<?php

use Illuminate\Support\Facades\Route;
use Modules\Branchs\Http\Controllers\BranchsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/branchs', [BranchsController::class, 'index'])
        ->name('branchs.index');

    Route::get('/branchs/create', [BranchsController::class, 'create'])
        ->name('branchs.create');

    Route::post('/branchs/store', [BranchsController::class, 'store'])
        ->name('branchs.store');

    Route::get('/branchs/edit/{medic}', [BranchsController::class, 'edit'])
        ->name('branchs.edit');

    Route::put('/branchs/{medic}', [BranchsController::class, 'update'])
        ->name('branchs.update');

    Route::delete('/branchs/{medic}', [BranchsController::class, 'destroy'])
        ->name('branchs.destroy');
});
