<?php

use Illuminate\Support\Facades\Route;
use Modules\EKYC\Http\Controllers\SmartCardController;
use Modules\EKYC\Http\Controllers\EKYCController;



Route::prefix('ekyc')->group(function () {

    Route::get(
        '/status',
        [SmartCardController::class, 'status']
    );


    Route::get(
        '/read',
        [SmartCardController::class, 'read']
    );

    Route::post('/lookup', [
        EKYCController::class,
        'lookup'
    ]);

    Route::get('/check-card', [
        EKYCController::class,
        'checkCard'
    ]);
});
