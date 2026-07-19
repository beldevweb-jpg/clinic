<?php

namespace Modules\MedicalCertificate\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Patient\Models\Patient;
use Modules\Branchs\Models\Branchs;
use Modules\Medics\Models\Medics;
use Modules\PDF\Http\Controllers\PDFController;
use Modules\MedicalCertificate\Models\MedicalCertificate;
use Modules\Document\Models\Document;
use Illuminate\Support\Facades\Auth;
use DB;





class MedicalCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('medicalcertificate::medicalcertificate.index');
    }


    public function create()
    {
        $patients = patient::get();
        $branchs = Branchs::get();
        $medics = medics::get();
        return view('medicalcertificate::MedicalCertificate.create', compact('patients', 'branchs', 'medics'));
    }

    public function store(Request $request)
    {
        $branch_id = auth()->user()->branch_id;

        $validated = $request->validate([
            'medic_id' => 'required|exists:medics,id',
            'exam_date' => 'required|date',
            'rest_days' => 'nullable|integer',
            'diagnosis' => 'nullable|string',
            'patient_id' => 'required|exists:patient,id',
        ]);


        DB::beginTransaction();

        try {
            $branch_id = auth()->user()->branch_id;

            $certificate = MedicalCertificate::create([

                'branch_id' => $branch_id,
                'document_no' => 'MC-' . now()->format('YmdHis'),
                'certificate_date' => $validated['exam_date'],
                'patient_id' => $validated['patient_id'],
                'symptom' => $validated['diagnosis'] ?? null,
                'treatment_recommendation' => null,
                'rest_days' => $validated['rest_days'] ?? 0,
                'medic_id' => $validated['medic_id'],
            ]);


            DB::commit();


            // Generate PDF เหมือน PT33
            $pdfPath = app(PDFController::class)
                ->generateMedicalCertificate(
                    $certificate
                );

            // update pdf_path
            $certificate->update([
                'pdf_path' => $pdfPath,
            ]);

            // Save document เหมือน PT33
            Document::create([
                'branch_id' => $branch_id,
                'patient_id' => $validated['patient_id'],
                'document_no' => $certificate->document_no,
                'type' => 'MedicalCertificate',
                'status' => 'completed',
                'document_date' => now(),
                'pdf_path' => $pdfPath,
                'created_by' => Auth::id() ?? 1,
            ]);


            return response()->file(
                storage_path('app/public/' . $pdfPath)
            );
        } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }


    public function edit($id)
    {
        return view('medicalcertificate::medicalcertificate.edit');
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patient,id',
            'medic_id' => 'required|exists:medics,id',
            'exam_date' => 'required|date',
            'rest_days' => 'nullable|integer',
            'diagnosis' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $certificate = MedicalCertificate::findOrFail($id);
            // update ใบรับรองแพทย์
            $certificate->update([
                'certificate_date' => $validated['exam_date'],
                'patient_id' => $validated['patient_id'],
                'symptom' => $validated['diagnosis'] ?? null,
                'rest_days' => $validated['rest_days'] ?? 0,
                'medic_id' => $validated['medic_id'],
            ]);

            DB::commit();

            // ลบ PDF เก่า
            if ($certificate->pdf_path) {

                Storage::disk('public')
                    ->delete($certificate->pdf_path);
            }

            // สร้าง PDF ใหม่
            $pdfPath = app(PDFController::class)
                ->generateMedicalCertificate(
                    $certificate
                );

            // update path pdf
            $certificate->update([

                'pdf_path' => $pdfPath,

            ]);

            // update document เดิม
            Document::where('document_no', $certificate->document_no)
                ->update([

                    'patient_id' => $validated['patient_id'],

                    'document_date' => now(),

                    'pdf_path' => $pdfPath,

                    'status' => 'completed',

                ]);


            return response()->file(
                storage_path('app/public/' . $pdfPath)
            );
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
