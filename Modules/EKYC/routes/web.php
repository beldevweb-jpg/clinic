<?php

use Illuminate\Support\Facades\Route;
use Modules\EKYC\Http\Controllers\EKYCController;

Route::middleware(['auth'])->group(function () {
    Route::resource('ekycs', EKYCController::class)->names('ekyc');
});
