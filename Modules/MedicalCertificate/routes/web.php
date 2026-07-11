<?php

use Illuminate\Support\Facades\Route;
use Modules\MedicalCertificate\Http\Controllers\MedicalCertificateController;

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::resource('medicalcertificates', MedicalCertificateController::class)->names('medicalcertificate');

    route::get('medical-certificate/create', [MedicalCertificateController::class, 'create'])->name('medical-certificate.create');
    
    route::get('medical-certificate/store', [MedicalCertificateController::class, 'store'])->name('medical-certificate.store');
});
