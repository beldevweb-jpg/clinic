<?php

namespace Modules\PDF\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\Document\Models\Pt33;
use Modules\Setting\Models\Setting;
use Modules\Patient\Models\Patient;
use Modules\Medics\Models\Medics;
use Modules\Document\Models\Document;
use App\Helpers\ThaiHelper;
use Modules\Document\Models\Pt28;



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
        $setting = Setting::first();

        $medic = Medics::with('professions.profession')
            ->findOrFail($medicId);


        $pt33->load([
            'patient',
            'visit.medic'
        ]);


        $pdf = Pdf::loadView('pdf::pt33', [
            'pt33' => $pt33,
            'patient' => $pt33->patient,
            'setting' => $setting,
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
        \Log::info('PT28 PDF START');

        $setting = Setting::first();

        \Log::info('SETTING OK');


        $pt28->load([
            'details.patient'
        ]);

        \Log::info('RELATION LOAD OK', [
            'details' => $pt28->details->count()
        ]);


        $pages = $pt28->details->chunk(14);

        \Log::info('CHUNK OK');


        $pdf = Pdf::loadView('pdf::pt28', [
            'pt28' => $pt28,
            'pages' => $pages,
            'setting' => $setting,
        ])
            ->setPaper('a4')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'chroot' => public_path(),   // <-- เพิ่มบรรทัดนี้
                'defaultFont' => 'thsarabunnew',
            ]);

        \Log::info('LOAD VIEW OK');


        $filename = $pt28->document_no . '.pdf';

        $path = 'documents/PT28/' . $filename;


        Storage::disk('public')
            ->makeDirectory('documents/PT28');


        \Log::info('BEFORE PDF OUTPUT');

        $pdfContent = $pdf->output();

        \Log::info('AFTER PDF OUTPUT', [
            'size' => strlen($pdfContent)
        ]);


        Storage::disk('public')->put(
            $path,
            $pdfContent
        );

        \Log::info('SAVE PDF OK', [
            'path' => $path
        ]);


        return $path;
    }
}
