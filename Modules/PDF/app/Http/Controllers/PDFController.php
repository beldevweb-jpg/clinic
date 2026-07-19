<?php

namespace Modules\PDF\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\Document\Models\PT33;
use Modules\Branchs\Models\Branchs;
use Modules\Patient\Models\Patient;
use Modules\Medics\Models\Medics;
use Modules\Document\Models\Document;
use App\Helpers\ThaiHelper;
use Modules\Document\Models\PT28;
use Modules\MedicalCertificate\Models\MedicalCertificate;



class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pdf::index');
    }
    public function generatePT33(Pt33 $pt33, $medicId)
    {
        $branchs = Branchs::first();

        $medic = Medics::with('professions.profession')
            ->findOrFail($medicId);


        $pt33->load([
            'patient',
            'visit.medic'
        ]);


        $pdf = Pdf::loadView('pdf::pt33', [
            'pt33' => $pt33,
            'patient' => $pt33->patient,
            'branchs' => $branchs,
            'medic' => $medic,
        ])
            ->setPaper('a4')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'TH Sarabun New',
            ]);


        $filename = $pt33->document_no . '.pdf';

        $path = 'documents/PT33/' . $filename;


        Storage::disk('public')
            ->makeDirectory('documents/PT33');


        Storage::disk('public')->put(
            $path,
            $pdf->output()
        );


        return $path;
    }

    public function generatePT28(Pt28 $pt28)
    {
        $branchs = Branchs::first();

        $pt28->load([
            'details.patient'
        ]);

        $pages = $pt28->details->chunk(14);

        $pdf = Pdf::loadView('pdf::pt28', [
            'pt28' => $pt28,
            'pages' => $pages,
            'branchs' => $branchs,
        ])
            ->setPaper('a4')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'chroot' => public_path(),   // <-- เพิ่มบรรทัดนี้
                'defaultFont' => 'thsarabunnew',
            ]);

        $filename = $pt28->document_no . '.pdf';

        $path = 'documents/PT28/' . $filename;

        Storage::disk('public')
            ->makeDirectory('documents/PT28');

        $pdfContent = $pdf->output();

        Storage::disk('public')->put(
            $path,
            $pdfContent
        );
        return $path;
    }

    public function generateMedicalCertificate(MedicalCertificate $certificate)
    {
        $branchs = Branchs::first();

        $certificate->load([
            'patient',
            'medic'
        ]);

        $pdf = Pdf::loadView('pdf::medical-certificate', [
            'certificate' => $certificate,
            'branchs' => $branchs,
        ])
            ->setPaper('A4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'chroot' => public_path(),
                'defaultFont' => 'thsarabunnew',
            ]);

        $filename = 'MC-' . $certificate->id . '.pdf';

        $path = 'documents/MedicalCertificate/' . $filename;

        Storage::disk('public')->makeDirectory(
            'documents/MedicalCertificate'
        );

        Storage::disk('public')->put(
            $path,
            $pdf->output()
        );

        return $path;
    }
}
