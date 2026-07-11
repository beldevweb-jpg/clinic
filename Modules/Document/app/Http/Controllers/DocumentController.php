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
use Modules\Setting\Models\setting;
use Modules\Patient\Models\Patient;
use Modules\Medics\Models\Medics;
use Modules\Document\Models\Document;
use Modules\Document\Models\Pt28Detail;
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

        $setting = Setting::first();

        $medics = Medics::with('professions.profession')
            ->where('status', 1)
            ->orderBy('firstname')
            ->get();

        return view('document::document.pt33', compact(
            'pt33',
            'patients',
            'setting',
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

    public function edit($id)
    {
        $document = Document::with([
            'pt33.visit.medic',
            'patient'
        ])->findOrFail($id);


        switch ($document->type) {

            case 'PT33':

                $pt33 = $document->pt33;

                $patients = Patient::orderBy('firstname')->get();

                $setting = Setting::first();

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
                        'setting',
                        'medics'
                    )
                );


            case 'PT28':
                return view(
                    'document::document.edit-pt28',
                    compact('document')
                );


            default:
                abort(404);
        }
    }

    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        $document->update([
            'status' => $request->status,
            'type' => $request->type
        ]);

        return redirect()
            ->route('documents.index')
            ->with(
                'success',
                'แก้ไขเอกสารเรียบร้อย'
            );
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $document->delete();
        return back()
            ->with(
                'success',
                'ลบเอกสารเรียบร้อย'
            );
    }

    public function view($id)
    {
        $document = Document::findOrFail($id);

        $file = storage_path(
            'app/public/' . $document->pdf_path
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
        ]);


        DB::beginTransaction();

        try {
            // สร้างเอกสาร PT28 หลัก 1 รายการ
            $documentNo = 'PT28-' . now()->format('YmHis');

            $pt28 = Pt28::create([
                'document_no' => $documentNo,
                'issue_date' => now(),
                'objective' => json_encode(
                    $request->objective,
                    JSON_UNESCAPED_UNICODE
                ),
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
                    'dosage' =>     $request->qty[$i] ?? 0,
                    'flower_unit' => 'กรัม',
                ]);
            }

            DB::commit();

            // // Generate PDF ครั้งเดียว
            // $pdfPath = app(PDFGenerator::class)
            //     ->generatePT28($pt28);

            // Document 1 รายการ
            Document::create([
                'patient_id' => null,
                'document_no' => $documentNo,
                'document_name' => 'แบบ ภ.ท. 28',
                'type' => 'PT28',
                'status' => 'completed',
                'document_date' => now(),
                'pdf_path' => '',
                'created_by' => Auth::id() ?? 1,
            ]);

            return redirect()
                ->route('pt28.preview', $pt28->id);

            // return response()->file(
            //     storage_path('app/public/' . $pdfPath)
            // );
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


        $setting = Setting::first();

        $pages = $pt28->details->chunk(14);

        return view('pdf::pt28', [
            'pt28' => $pt28,
            'pages' => $pages,
            'setting' => $setting,
        ]);
    }
}
