<?php

use Illuminate\Support\Facades\Route;
use Modules\MedicalCertificate\Http\Controllers\MedicalCertificateController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::resource('medicalcertificates', MedicalCertificateController::class)->names('medicalcertificate');


});
