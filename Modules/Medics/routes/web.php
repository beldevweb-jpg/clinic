<?php

use Illuminate\Support\Facades\Route;
use Modules\Medics\Http\Controllers\MedicsController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/medics', [MedicsController::class, 'index'])
        ->name('medics.index');

    Route::get('/medics/create', [MedicsController::class, 'create'])
        ->name('medics.create');

    Route::post('/medics/store', [MedicsController::class, 'store'])
        ->name('medics.store');

    Route::get('/medics/edit/{medic}', [MedicsController::class, 'edit'])
        ->name('medics.edit');

    Route::put('/medics/{medic}', [MedicsController::class, 'update'])
        ->name('medics.update');

    Route::get('/medics/profile/{id}', [MedicsController::class, 'profile'])
        ->name('medics.profile');

    Route::delete('/medics/{medic}', [MedicsController::class, 'destroy'])
        ->name('medics.destroy');
});
