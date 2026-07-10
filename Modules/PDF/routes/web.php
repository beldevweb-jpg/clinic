<?php

use Illuminate\Support\Facades\Route;
use Modules\PDF\Http\Controllers\PDFController;

Route::middleware(['auth'])->group(function () {
    Route::resource('pdfs', PDFController::class)->names('pdf');

    Route::get('/pt33/{pt33}/{medic}/preview', [PDFController::class, 'previewPT33'])
        ->name('pdf.pt33.preview');
});
