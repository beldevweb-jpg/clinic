<?php

namespace Modules\Document\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Document\Models\pt33;
use Modules\Document\Models\pt28;
use Modules\branches\Models\branches;
use Modules\Patient\Models\Patient;
use Modules\Medics\Models\Medics;
use Modules\Document\Models\Document;
use Modules\Document\Models\Pt28Detail;
use Illuminate\Support\Facades\File;


use Modules\PDF\Http\Controllers\PDFController as PDFGenerator;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function pt33()
    {
        $pt33 = Pt33::all();

        $patients = Patient::orderBy('firstname')->get();

        $branches = branches::first();

        $medics = Medics::with('professions.profession')
            ->where('status', 1)
            ->orderBy('firstname')
            ->get();

        return view('document::document.pt33', compact(
            'pt33',
            'patients',
            'branches',
            'medics'
        ));
    }

    public function pt33_store(Request $request)
    {

        $validated = $request->validate([
            'patient_id'   => 'required|exists:patient,id',
            'medic_id'     => 'required|exists:medics,id',
            'diagnosis'    => 'required|string',
            'gram'         => 'required|numeric|min:0.01',
            'days'         => 'required|integer|min:1|max:30',
            'total'        => 'required|numeric|min:0.01',

            'profession'   => 'nullable|array',
            'profession.*' => 'string',
        ]);


        DB::beginTransaction();

        try {

            $visitId = DB::table('visits')->insertGetId([
                'patient_id' => $validated['patient_id'],
                'visit_no'   => 'VISIT-' . now()->format('YmdHis'),
                'visit_date' => now()->toDateString(),
                'medic_id'   => $validated['medic_id'],
                'diagnosis'  => $validated['diagnosis'],
                'created_by' => Auth::id() ?? 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $pt33 = Pt33::create([
                'patient_id' => $validated['patient_id'],
                'visit_id' => $visitId,
                'document_no' => 'PT33-' . now()->format('YmdHis'),
                'issue_date' => now()->toDateString(),
                'profession' => isset($validated['profession'])
                    ? json_encode($validated['profession'], JSON_UNESCAPED_UNICODE)
                    : null,

                'diagnosis' => $validated['diagnosis'],
                'cannabis_dosage' => $validated['gram'],
                'cannabis_use_days' => $validated['days'],
                'cannabis_dosage_unit' => $validated['total'],
            ]);



            DB::commit();

            // Generate PDF
            $pdfPath = app(PDFGenerator::class)
                ->generatePT33(
                    $pt33,
                    $validated['medic_id']
                );


            // update pdf_path กลับเข้า PT33
            $pt33->update([
                'pdf_path' => $pdfPath,
            ]);

            // Save document
            Document::create([
                'patient_id' => $validated['patient_id'],
                'document_no' => $pt33->document_no,
                'type' => 'PT33',
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
        $document = Document::findOrFail($id);

        switch ($document->type) {

            case 'PT33':

                $document->load([
                    'pt33.visits.medic',
                    'patient'
                ]);

                $pt33 = $document->pt33;

                $patients = Patient::orderBy('firstname')->get();

                $branches = branches::first();

                $medics = Medics::with('professions.profession')
                    ->where('status', 1)
                    ->orderBy('firstname')
                    ->get();


                return view(
                    'document::document.edit-pt33',
                    compact(
                        'document',
                        'pt33',
                        'patients',
                        'branches',
                        'medics'
                    )
                );


            case 'PT28':

                $document->load([
                    'pt28.details.patient'
                ]);

                $pt28 = $document->pt28;

                $patients = Patient::orderBy('firstname')->get();


                return view(
                    'document::document.edit-pt28',
                    compact(
                        'document',
                        'pt28',
                        'patients'
                    )
                );


            case 'MedicalCertificate':

                $document->load([
                    'medicalCertificate.patient',
                    'medicalCertificate.medic'
                ]);

                $medicalCertificate = $document->medicalCertificate;


                $patients = Patient::orderBy('firstname')->get();

                $branches = branches::first();

                $medics = Medics::with('professions.profession')
                    ->where('status', 1)
                    ->orderBy('firstname')
                    ->get();


                return view(
                    'medicalcertificate::MedicalCertificate.edit',
                    compact(
                        'document',
                        'medicalCertificate',
                        'patients',
                        'branches',
                        'medics'
                    )
                );


            default:

                abort(404, 'ไม่พบประเภทเอกสาร');
        }
    }

    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $validated = $request->validate([
            'medic_id' => 'required|exists:medics,id',

            'profession' => 'nullable|array',
            'profession.*' => 'string',

            'diagnosis' => 'nullable|string',

            'cannabis_dosage' => 'required|numeric|min:0',

            'cannabis_use_days' => 'required|integer|min:1',

        ], [
            'medic_id.required' => 'กรุณาเลือกแพทย์',
            'medic_id.exists' => 'ไม่พบข้อมูลแพทย์',

            'profession.array' => 'ข้อมูลผู้ประกอบวิชาชีพไม่ถูกต้อง',

            'diagnosis.string' => 'ข้อมูลโรคหรืออาการต้องเป็นข้อความ',

            'cannabis_dosage.required' => 'กรุณาระบุจำนวนกัญชา',
            'cannabis_dosage.numeric' => 'จำนวนกัญชาต้องเป็นตัวเลข',
            'cannabis_dosage.min' => 'จำนวนกัญชาต้องไม่น้อยกว่า 0',

            'cannabis_use_days.required' => 'กรุณาระบุจำนวนวันที่ใช้',
            'cannabis_use_days.integer' => 'จำนวนวันที่ใช้ต้องเป็นจำนวนเต็ม',
            'cannabis_use_days.min' => 'จำนวนวันที่ใช้ต้องไม่น้อยกว่า 1 วัน',

        ]);

        DB::beginTransaction();

        try {

            // update document
            $document->update([
                'status' => $request->status ?? $document->status,
                'type' => $request->type ?? $document->type,

            ]);

            // หา PT33
            $pt33 = Pt33::where(
                'document_no',
                $document->document_no
            )->firstOrFail();

            // update visit
            if ($pt33->visit) {
                $pt33->visit->update([
                    'medic_id' => $validated['medic_id'],
                    'diagnosis' => $validated['diagnosis'],
                ]);
            }

            // update pt33
            $pt33->update([
                'profession' => isset($validated['profession'])
                    ? json_encode(
                        $validated['profession'],
                        JSON_UNESCAPED_UNICODE
                    )
                    : null,

                'diagnosis' => $validated['diagnosis'],

                'cannabis_dosage' =>
                $validated['cannabis_dosage'],

                'cannabis_use_days' =>
                $validated['cannabis_use_days'],
            ]);
            // ลบ PDF เก่า
            if ($document->pdf_path) {

                $oldPdf = storage_path(
                    'app/public/' . $document->pdf_path
                );

                if (file_exists($oldPdf)) {
                    unlink($oldPdf);
                }
            }

            // สร้าง PDF ใหม่
            $pdfPath = app(PDFGenerator::class)
                ->generatePT33(
                    $pt33->fresh(),
                    $validated['medic_id']
                );

            // update path PDF ใหม่
            $document->update([

                'pdf_path' => $pdfPath,
                'document_date' => now(),

            ]);

            DB::commit();

            return redirect()
                ->route('documents.index')
                ->with(
                    'success',
                    'แก้ไขเอกสารเรียบร้อย'
                );
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function index(Request $request)
    {
        $query = Document::with('patient');

        // ค้นหา
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('document_no', 'like', "%$search%")
                    ->orWhereHas('patient', function ($p) use ($search) {
                        $p->where('firstname', 'like', "%$search%")
                            ->orWhere('lastname', 'like', "%$search%");
                    });
            });
        }
        // ประเภท
        if ($request->type) {

            $query->where('type', $request->type);
        }

        // สถานะ
        if ($request->status) {

            $query->where('status', $request->status);
        }

        $document = $query
            ->latest()
            ->paginate(20);

        return view(
            'document::document.index',
            compact('document')
        );
    }



    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $document = Document::findOrFail($id);


            if (
                $document->pdf_path &&
                Storage::disk('public')->exists($document->pdf_path)
            ) {

                Storage::disk('public')
                    ->delete($document->pdf_path);
            }

            $pt28 = Pt28::where(
                'document_no',
                $document->document_no
            )->first();


            if ($pt28) {

                $pt28->details()->delete();

                $pt28->delete();
            }


            $pt33 = Pt33::where(
                'document_no',
                $document->document_no
            )->first();


            if ($pt33) {

                $pt33->delete();
            }

            $medicalCertificate = MedicalCertificate::where(
                'document_no',
                $document->document_no
            )->first();


            if ($medicalCertificate) {


                // กรณี PDF ของ MedicalCertificate ไม่ตรงกับ Document
                if (
                    $medicalCertificate->pdf_path &&
                    $medicalCertificate->pdf_path != $document->pdf_path &&
                    Storage::disk('public')
                    ->exists($medicalCertificate->pdf_path)
                ) {

                    Storage::disk('public')
                        ->delete($medicalCertificate->pdf_path);
                }


                $medicalCertificate->delete();
            }




            /*
        |--------------------------------------------------------------------------
        | Document
        |--------------------------------------------------------------------------
        */

            $document->delete();



            DB::commit();


            return back()
                ->with(
                    'success',
                    'ลบเอกสารเรียบร้อย'
                );
        } catch (\Exception $e) {


            DB::rollBack();

            throw $e;
        }
    }

    public function view($id)
    {
        $document = Document::findOrFail($id);

        $folder = match ($document->type) {
            'PT33' => 'PT33',
            'PT28' => 'PT28',
            'MedicalCertificate' => 'MedicalCertificate',
            default => null,
        };

        if (!$folder) {
            abort(404, 'ไม่พบประเภทเอกสาร');
        }

        $file = public_path(
            'storage/documents/'
                . $folder . '/'
                . basename($document->pdf_path)
        );

        if (!file_exists($file)) {

            abort(404, 'ไม่พบไฟล์ PDF: ' . $file);
        }
        return response()->file($file);
    }

    public function pt28()
    {
        $patients = patient::get();
        return view('document::document.pt28', compact('patients'));
    }

    public function pt28_store(Request $request)
    {
        $validated = $request->validate([

            'date' => 'required|array',
            'date.*' => 'required|date',

            'patient_id' => 'nullable|array',
            'patient_id.*' => 'nullable|exists:patient,id',

            'qty' => 'required|array',
            'qty.*' => 'nullable|numeric|min:0',

            'license_no' => 'nullable|array',
            'license_no.*' => 'nullable|string|max:255',

            'objective' => 'required|array',

        ], [

            'date.required' => 'กรุณาระบุวันที่',
            'date.array' => 'รูปแบบวันที่ไม่ถูกต้อง',
            'date.*.required' => 'กรุณาระบุวันที่ทุกรายการ',
            'date.*.date' => 'วันที่ไม่ถูกต้อง',

            'patient_id.array' => 'ข้อมูลผู้ป่วยไม่ถูกต้อง',
            'patient_id.*.exists' => 'ไม่พบข้อมูลผู้ป่วย',

            'qty.required' => 'กรุณาระบุปริมาณ',
            'qty.array' => 'รูปแบบปริมาณไม่ถูกต้อง',
            'qty.*.numeric' => 'ปริมาณต้องเป็นตัวเลข',
            'qty.*.min' => 'ปริมาณต้องไม่ต่ำกว่า 0',

            'license_no.array' => 'รูปแบบเลขที่ใบอนุญาตไม่ถูกต้อง',
            'license_no.*.string' => 'เลขที่ใบอนุญาตต้องเป็นข้อความ',
            'license_no.*.max' => 'เลขที่ใบอนุญาตยาวเกินไป',

            'objective.required' => 'กรุณาเลือกวัตถุประสงค์การนำไปใช้',
            'objective.array' => 'รูปแบบวัตถุประสงค์ไม่ถูกต้อง',

        ]);


        DB::beginTransaction();

        try {
            // สร้างเอกสาร PT28 หลัก 1 รายการ
            $documentNo = 'PT28-' . now()->format('YmHis');
            // dd($documentNo);

            $pt28 = Pt28::create([
                'document_no' => $documentNo,
                'issue_date' => now(),
            ]);


            // เก็บรายการผู้ซื้อหลายคน
            foreach ($request->patient_id as $i => $patientId) {

                if (empty($patientId)) {
                    continue;
                }

                $pt28->details()->create([
                    'patient_id' => $patientId,
                    'issue_date' => $request->date[$i],
                    'license_no' => $request->license_no[$i] ?? null,
                    'dosage' => $request->qty[$i] ?? 0,
                    'objective' => $request->objective[$i] ?? [],
                ]);
            }

            DB::commit();

            // Generate PDF ครั้งเดียว
            $pdfPath = app(PDFGenerator::class)
                ->generatePT28($pt28);
            $pt28->update([
                'pdf_path' => $pdfPath,
            ]);
            // Document 1 รายการ
            Document::create([
                'patient_id' => null,
                'document_no' => $documentNo,
                'type' => 'PT28',
                'status' => 'completed',
                'document_date' => now(),
                'pdf_path' => $pdfPath,
                'created_by' => Auth::id() ?? 1,
            ]);

            // return redirect()
            //     ->route('pt28.preview', $pt28->id);

            return response()->file(
                storage_path('app/public/' . $pdfPath)
            );
        } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function pt28_update(Request $request, $id)
    {
        $validated = $request->validate([

            'date' => 'required|array',
            'date.*' => 'required|date',

            'patient_id' => 'nullable|array',
            'patient_id.*' => 'nullable|exists:patient,id',

            'qty' => 'required|array',
            'qty.*' => 'nullable|numeric|min:0',

            'license_no' => 'nullable|array',
            'license_no.*' => 'nullable|string|max:255',

            'objective' => 'required|array',

        ]);


        DB::beginTransaction();

        try {

            // หา PT28 เดิม
            $pt28 = Pt28::findOrFail($id);

            $pt28->refresh();

            // ลบรายละเอียดเก่า
            $pt28->details()->delete();


            // สร้างรายละเอียดใหม่
            foreach ($request->patient_id ?? [] as $i => $patientId) {

                if (empty($patientId)) {
                    continue;
                }

                $pt28->details()->create([
                    'patient_id' => $patientId,
                    'issue_date' => $request->date[$i],
                    'license_no' => $request->license_no[$i] ?? null,
                    'dosage' => $request->qty[$i] ?? 0,

                    'objective' => $request->objective[$i] ?? [],
                ]);
            }


            // ลบ PDF เก่า
            $document = Document::where('document_no', $pt28->document_no)
                ->where('type', 'PT28')
                ->first();
            if (
                $document &&
                $document->pdf_path &&
                Storage::disk('public')->exists($document->pdf_path)
            ) {
                Storage::disk('public')->delete($document->pdf_path);
            }

            DB::commit();


            // โหลดข้อมูลใหม่ก่อนสร้าง PDF
            $pt28->load([
                'details.patient'
            ]);

            // Generate PDF ครั้งเดียว
            $pdfPath = app(PDFGenerator::class)
                ->generatePT28($pt28);
            if (!$pdfPath) {
                throw new Exception('สร้าง PDF ไม่สำเร็จ');
            }
            $pt28->update([
                'pdf_path' => $pdfPath,
            ]);


            // update path ใหม่
            if ($document) {

                $document->update([
                    'pdf_path' => $pdfPath,
                    'document_date' => now(),
                    'status' => 'completed',
                ]);
            } else {

                Document::create([
                    'patient_id' => null,
                    'document_no' => $pt28->document_no,
                    'type' => 'PT28',
                    'status' => 'completed',
                    'document_date' => now(),
                    'pdf_path' => $pdfPath,
                    'created_by' => Auth::id() ?? 1,
                ]);
            }

            return response()->file(
                storage_path('app/public/' . $pdfPath)
            );
        } catch (\Exception $e) {

            DB::rollBack();

            throw $e;
        }
    }

    public function pt28_preview($id)
    {
        $pt28 = Pt28::with([
            'details.patient'
        ])->findOrFail($id);


        $branches = branches::first();

        $pages = $pt28->details->chunk(14);

        return view('pdf::pt28', [
            'pt28' => $pt28,
            'pages' => $pages,
            'branches' => $branches,
        ]);
    }
}
