<?php

use Illuminate\Support\Facades\Route;
use Modules\Patient\Http\Controllers\PatientController;

Route::middleware(['auth'])->group(function () {
    Route::get('/patient', [PatientController::class, 'index'])->name('patient.index');

    
    Route::get('/patient/create', [PatientController::class, 'create'])->name('patient.create');
    Route::POST('/store', [PatientController::class, 'store'])->name('patient.store');
    Route::get('/patient/{id}', [PatientController::class, 'edit'])->name('patient.edit');
    Route::PUT('/update/{id}', [PatientController::class, 'update'])->name('patient.update');
    Route::get('/show/{id}', [PatientController::class, 'show'])->name('patient.show');

    Route::get('/patient/check-cid/{cid}', [PatientController::class, 'checkCid'])
        ->name('patient.checkCid');
});
