<?php

use Illuminate\Support\Facades\Route;
use Modules\Branchs\Http\Controllers\BranchsController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('branchs', BranchsController::class)->names('branchs');
});
