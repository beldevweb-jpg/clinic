<?php

use Illuminate\Support\Facades\Route;
use Modules\EKYC\Http\Controllers\EKYCController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('ekycs', EKYCController::class)->names('ekyc');
});
