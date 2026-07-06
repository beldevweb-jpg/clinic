<?php

use Illuminate\Support\Facades\Route;
use Modules\PDF\Http\Controllers\PDFController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('pdfs', PDFController::class)->names('pdf');
});
