<?php

namespace Modules\Dashboards\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Patient\Models\patient;
use Modules\Medics\Models\medics;
use Modules\MedicalCertificate\Models\MedicalCertificate;
use Modules\Document\Models\Document;
use Modules\Document\Models\Visit;

class DashboardsController extends Controller
{
    public function index()
    {
        $data = [
            'patients' => patient::count(),
            'medics' => medics::count(),
            'certificates' => MedicalCertificate::count(),
            'documents' => Document::count(),
            'visits' => Visit::count(),
        ];

        return view('dashboards::dashboards.index', $data);
    }
}
