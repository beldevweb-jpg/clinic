<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Modules\AuditLog\Observers\AuditObserver;


// Models ที่ต้องเก็บ Audit
use Modules\Patient\Models\Patient;
use Modules\Document\Models\Document;
use Modules\Document\Models\Pt33;
use Modules\Document\Models\Pt28;
use Modules\Visits\Models\Visits;

use Modules\MedicalCertificate\Models\MedicalCertificate;

use Modules\Medics\Models\medics;

use Modules\Branchs\Models\Branchs;


class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        //
    }


    public function boot(): void
    {

        patient::observe(
            AuditObserver::class
        );


        Document::observe(
            AuditObserver::class
        );


        pt33::observe(
            AuditObserver::class
        );


        Pt28::observe(
            AuditObserver::class
        );


        Visits::observe(
            AuditObserver::class
        );


        MedicalCertificate::observe(
            AuditObserver::class
        );


        medics::observe(
            AuditObserver::class
        );


        Branchs::observe(
            AuditObserver::class
        );
    }
}
