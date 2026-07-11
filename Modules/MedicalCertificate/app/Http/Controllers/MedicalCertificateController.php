<?php

namespace Modules\MedicalCertificate\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Patient\Models\patient;
use Modules\Setting\Models\setting;
use Modules\Medics\Models\medics;

class MedicalCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('medicalcertificate::medicalcertificate.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = patient::get();
        $setting = setting::get();
        $medics = medics::get();
        return view('medicalcertificate::MedicalCertificate.create', compact('patients', 'setting', 'medics'));
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
        return view('medicalcertificate::medicalcertificate.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('medicalcertificate::medicalcertificate.edit');
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
