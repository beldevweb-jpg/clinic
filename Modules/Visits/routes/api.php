<?php

use Illuminate\Support\Facades\Route;
use Modules\Visits\Http\Controllers\VisitsController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('visits', VisitsController::class)->names('visits');
});
