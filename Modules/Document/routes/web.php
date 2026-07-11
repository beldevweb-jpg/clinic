<?php

use Illuminate\Support\Facades\Route;
use Modules\Document\Http\Controllers\DocumentController;

Route::middleware(['auth'])->group(function () {
    // Route::resource('documents', DocumentController::class)->names('document');

    Route::get('/documents/index', [DocumentController::class, 'index'])
        ->name('documents.index');

    Route::get('/documents/pt33', [DocumentController::class, 'pt33'])
        ->name('pt33.index');

    Route::POST('/documents/pt33/stor', [DocumentController::class, 'pt33_store'])
        ->name('pt33.store');

    Route::get(
        '/documents/{id}/edit',
        [DocumentController::class, 'edit']
    )->name('documents.edit');


    Route::put(
        '/documents/{id}',
        [DocumentController::class, 'update']
    )->name('documents.update');


    Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    Route::get('/documents/{id}/view', [DocumentController::class, 'view'])->name('documents.view');



    Route::get('/documents/pt28', [DocumentController::class, 'pt28'])
        ->name('pt28.index');

    Route::POST('/documents/pt28/stor', [DocumentController::class, 'pt28_store'])
        ->name('pt28.store');

    Route::get(
        '/documents/pt28/preview/{id}',
        [DocumentController::class, 'pt28_preview']
    )->name('pt28.preview');
});
