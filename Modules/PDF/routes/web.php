<?php

use Illuminate\Support\Facades\Route;
use Modules\PDF\Http\Controllers\PDFController;

Route::middleware(['auth'])->group(function () {
    Route::resource('pdfs', PDFController::class)->names('pdf');
});
