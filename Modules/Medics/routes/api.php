<?php

use Illuminate\Support\Facades\Route;
use Modules\Medics\Http\Controllers\MedicsController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('medics', MedicsController::class)->names('medics');
});
