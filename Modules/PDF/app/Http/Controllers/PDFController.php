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


    // public function previewPT33(Pt33 $pt33, $medicId)
    // {
    //     $setting = Setting::first();

    //     $medic = Medics::with('professions.profession')
    //         ->findOrFail($medicId);

    //     $patient = $pt33->patient;$pdf = Pdf::loadView('pdf::pt33'

    //     return view('pdf::pt33', compact(
    //         'pt33',
    //         'patient',
    //         'setting',
    //         'medic'
    //     ));
    // }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pdf::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('pdf::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('pdf::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
