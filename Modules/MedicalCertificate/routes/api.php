<?php

use Illuminate\Support\Facades\Route;
use Modules\MedicalCertificate\Http\Controllers\MedicalCertificateController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('medicalcertificates', MedicalCertificateController::class)->names('medicalcertificate');
});
