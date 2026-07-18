<?php

namespace Modules\Patient\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Patient\Models\patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Modules\Document\Models\Visits;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patient = patient::with([
            'visits' => function ($query) {
                $query->latest('created_at');
            }
        ])->get();

        return view('patient::patient.index', compact('patient'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patient::patient.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);

        $request->validate([
            'cid' => [
                'required',
                'digits:13',
                Rule::unique('patient', 'cid'),
            ],

            'firstname_en' => 'required|string|max:100',
            'nationality' => 'required|string|max:100',

            'prefix' => 'required|string',
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',

            'birthday' => 'required|date',
            'age' => 'required|integer|min:0',

            'address' => 'required|string|max:255',
            'province' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'subdistrict' => 'required|string|max:100',


            'phone' => 'nullable|string|max:20',

            'gender' => 'required|in:ชาย,หญิง',

            'blood_pressure' => 'nullable|string|max:20',
            'pulse_rate' => 'nullable|integer|min:0',
            'respiratory_rate' => 'nullable|integer|min:0',

            'height' => 'nullable|numeric|min:0|max:300',
            'weight' => 'nullable|numeric|min:0|max:500',

            'physical_exam' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
        ], [
            'cid.required' => 'กรุณากรอกเลขบัตรประชาชน',
            'cid.digits' => 'เลขบัตรประชาชนต้องมี 13 หลัก',
            'cid.unique' => 'เลขบัตรประชาชนนี้มีในระบบแล้ว',

            'firstname.required' => 'กรุณากรอกชื่อ',
            'lastname.required' => 'กรุณากรอกนามสกุล',

            'firstname_en.max' => 'ชื่อภาษาอังกฤษยาวเกินไป',
            'lastname_en.max' => 'นามสกุลภาษาอังกฤษยาวเกินไป',

            'nationality.required' => 'กรุณากรอกสัญชาติ',

            'prefix.required' => 'กรุณาเลือกคำนำหน้า',

            'birthday.required' => 'กรุณาเลือกวันเกิด',
            'birthday.date' => 'รูปแบบวันเกิดไม่ถูกต้อง',

            'age.required' => 'กรุณากรอกอายุ',
            'age.integer' => 'อายุต้องเป็นตัวเลข',

            'address.required' => 'กรุณากรอกที่อยู่',
            'province.required' => 'กรุณากรอกจังหวัด',
            'district.required' => 'กรุณากรอกอำเภอ',
            'subdistrict.required' => 'กรุณากรอกตำบล',


            'phone.max' => 'เบอร์โทรศัพท์ยาวเกินไป',

            'gender.required' => 'กรุณาเลือกเพศ',
            'gender.in' => 'ข้อมูลเพศไม่ถูกต้อง',
        ]);
        try {

            $patient = DB::transaction(function () use ($request) {

                // สาขาของ User
                $branchId = auth()->user()->branch_id;


                // หา running number ของสาขานี้
                $hn = DB::table('hn_running')
                    ->where('branch_id', $branchId)
                    ->lockForUpdate()
                    ->first();


                // ถ้ายังไม่มี running ของสาขา ให้สร้าง
                if (!$hn) {

                    $id = DB::table('hn_running')->insertGetId([
                        'branch_id' => $branchId,
                        'current_number' => 0
                    ]);

                    $hn = DB::table('hn_running')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();
                }


                // เพิ่มเลข HN
                $nextHN = $hn->current_number + 1;


                // update เลขล่าสุด
                DB::table('hn_running')
                    ->where('id', $hn->id)
                    ->update([
                        'current_number' => $nextHN
                    ]);

                // สร้างผู้ป่วย
                return Patient::create([

                    'hn' => 'HN' . str_pad($nextHN, 6, '0', STR_PAD_LEFT),

                    'cid' => $request->cid,

                    'title' => $request->title,

                    'prefix' => $request->prefix,

                    'firstname' => $request->firstname,

                    'lastname' => $request->lastname,


                    'firstname_en' => $request->firstname_en,

                    'lastname_en' => $request->lastname_en,


                    'nationality' => $request->nationality,


                    'age' => $request->age,

                    'birthday' => $request->birthday,

                    'gender' => $request->gender,


                    'card_address' => $request->address,

                    'subdistrict' => $request->subdistrict,

                    'district' => $request->district,

                    'province' => $request->province,

                    'zipcode' => $request->zipcode,


                    'phone' => $request->phone,


                    // vital signs
                    'blood_pressure' => $request->bp,

                    'pulse_rate' => $request->pr,

                    'respiratory_rate' => $request->rr,

                    'temperature' => $request->temperature,


                    'height' => $request->height,

                    'weight' => $request->weight,


                    // medical
                    'chief_complaint' => $request->chief_complaint,

                    'physical_exam' => $request->physical_exam,

                    'diagnosis' => $request->dx,

                    'treatment' => $request->tx,

                ]);
            });
            return redirect()
                ->route('patient.index')
                ->with('success', 'เพิ่มข้อมูลผู้ป่วยเรียบร้อย HN : ' . $patient->hn);
        } catch (\Exception $e) {
            dd($e);
            Log::error('Create Patient Error : ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'เกิดข้อผิดพลาด ไม่สามารถเพิ่มข้อมูลผู้ป่วยได้');
        }
    }

    public function checkCid($cid)
    {
        $patient = Patient::where('cid', $cid)->first();

        if ($patient) {

            return response()->json([
                'exists' => true,
                'message' => 'มีข้อมูลบัตรนี้แล้ว',
                'patient' => $patient
            ]);
        }


        return response()->json([
            'exists' => false
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patient::patient.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $patient = patient::findOrFail($id);

        $request->validate([
            'cid' => [
                'required',
                'digits:13',
                Rule::unique('patient', 'cid')->ignore($patient->id),
            ],

            'lastname_en' => 'required|string|max:100',
            'nationality' => 'required|string|max:100',

            'prefix' => 'required|string',
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',

            'birthday' => 'required|date',
            'age' => 'required|integer|min:0',

            'address' => 'required|string|max:255',
            'province' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'subdistrict' => 'required|string|max:100',

            'phone' => 'nullable|string|max:20',

            'gender' => 'required|in:ชาย,หญิง',

            'blood_pressure' => 'nullable|string|max:20',
            'pulse_rate' => 'nullable|integer|min:0',
            'respiratory_rate' => 'nullable|integer|min:0',

            'height' => 'nullable|numeric|min:0|max:300',
            'weight' => 'nullable|numeric|min:0|max:500',

            'physical_exam' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment' => 'nullable|string',
        ], [
            'cid.required' => 'กรุณากรอกเลขบัตรประชาชน',
            'cid.digits' => 'เลขบัตรประชาชนต้องมี 13 หลัก',
            'cid.unique' => 'เลขบัตรประชาชนนี้มีในระบบแล้ว',

            'firstname.required' => 'กรุณากรอกชื่อ',
            'lastname.required' => 'กรุณากรอกนามสกุล',

            'nationality.required' => 'กรุณากรอกสัญชาติ',

            'prefix.required' => 'กรุณาเลือกคำนำหน้า',

            'birthday.required' => 'กรุณาเลือกวันเกิด',
            'birthday.date' => 'รูปแบบวันเกิดไม่ถูกต้อง',

            'age.required' => 'กรุณากรอกอายุ',
            'age.integer' => 'อายุต้องเป็นตัวเลข',

            'address.required' => 'กรุณากรอกที่อยู่',
            'province.required' => 'กรุณากรอกจังหวัด',
            'district.required' => 'กรุณากรอกอำเภอ',
            'subdistrict.required' => 'กรุณากรอกตำบล',

            'phone.max' => 'เบอร์โทรศัพท์ยาวเกินไป',

            'gender.required' => 'กรุณาเลือกเพศ',
            'gender.in' => 'ข้อมูลเพศไม่ถูกต้อง',
        ]);


        try {

            DB::transaction(function () use ($request, $patient) {

                return Patient::create([

                    'hn' => 'HN' . str_pad($nextHN, 6, '0', STR_PAD_LEFT),

                    'cid' => $request->cid,

                    'title' => $request->title,

                    'prefix' => $request->prefix,

                    'firstname' => $request->firstname,

                    'lastname' => $request->lastname,


                    'firstname_en' => $request->firstname_en,

                    'lastname_en' => $request->lastname_en,


                    'nationality' => $request->nationality,


                    'birthday' => $request->birthday,

                    'age' => $request->age,


                    'gender' => $request->gender,


                    'card_address' => $request->address,

                    'subdistrict' => $request->subdistrict,

                    'district' => $request->district,

                    'province' => $request->province,

                    'zipcode' => $request->zipcode,


                    'phone' => $request->phone,


                    'blood_pressure' => $request->blood_pressure,

                    'pulse_rate' => $request->pulse_rate,

                    'respiratory_rate' => $request->respiratory_rate,

                    'temperature' => $request->temperature,


                    'height' => $request->height,

                    'weight' => $request->weight,


                    'chief_complaint' => $request->chief_complaint,

                    'physical_exam' => $request->physical_exam,

                    'diagnosis' => $request->diagnosis,

                    'treatment' => $request->treatment,

                ]);
            });


            return redirect()
                ->route('patient.index')
                ->with('success', 'แก้ไขข้อมูลผู้ป่วยเรียบร้อย HN : ' . $patient->hn);
        } catch (\Exception $e) {

            Log::error('Update Patient Error : ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'เกิดข้อผิดพลาด ไม่สามารถแก้ไขข้อมูลผู้ป่วยได้');
        }
    }


    public function show($id)
    {
        $patient = Patient::with([
            'visits.medic'
        ])->findOrFail($id);
        return view('patient::patient.show', compact('patient'));
    }
}
