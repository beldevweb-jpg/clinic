<?php

use Illuminate\Support\Facades\Route;
use Modules\Document\Http\Controllers\DocumentController;

Route::middleware(['auth'])->group(function () {
    // Route::resource('documents', DocumentController::class)->names('document');

    Route::get('/documents/pt33', [DocumentController::class, 'pt33'])
        ->name('pt33.index');

    Route::get('/documents/pt28', [DocumentController::class, 'pt28'])
        ->name('pt28.index');
});
