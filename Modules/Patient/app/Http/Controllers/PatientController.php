<?php

namespace Modules\Patient\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Patient\Models\patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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
        $request->validate(
            [
                'cid' => [
                    'required',
                    'string',
                    'max:13',
                    Rule::unique('patient', 'cid')
                ],
                'firstname' => 'required|string|max:100',
                'lastname' => 'required|string|max:100',
                'birthday' => 'required|date',
                'phone' => 'nullable|string|max:20',
                'prefix' => 'required',
                'age' => 'required|numeric',
                'address' => 'required|string|max:100',
                'province' => 'required|string|max:100',
                'district' => 'required|string|max:100',
                'subdistrict' => 'required|string|max:100',
                'zipcode' => 'required|string|max:100',
                'nationality' => 'required',
                'gender' => 'required|in:ชาย,หญิง',
            ],
            [
                'cid.required' => 'กรุณากรอกเลขบัตรประชาชน',
                'cid.unique' => 'เลขบัตรประชาชนนี้มีในระบบแล้ว',
                'firstname.required' => 'กรุณากรอกชื่อ',
                'lastname.required' => 'กรุณากรอกนามสกุล',
                'nationality.required' => 'กรุณากรอกสัญชาติ',
                'birthday.required' => 'กรุณากรอกวันเดือนปีเกิด',
                'prefix.required' => 'กรุณาเลือกคำนำหน้าชื่อ',
                'address.required' => 'กรุณากรอกที่อยู่',
                'province.required' => 'กรุณากรอกจังหวัด',
                'district.required' => 'กรุณากรอกอำเภอ',
                'subdistrict.required' => 'กรุณากรอกตำบล',
                'zipcode.required' => 'กรุณากรอกรหัสไปรษณีย์',
                'gender.required' => 'กรุณาเลือกเพศ',
                'gender.in' => 'ข้อมูลเพศไม่ถูกต้อง',
            ]
        );

        try {

            $patient = DB::transaction(function () use ($request) {

                // Lock แถว HN ป้องกันเลขซ้ำ
                $hn = DB::table('hn_running')
                    ->lockForUpdate()
                    ->first();


                // ถ้ายังไม่มีข้อมูล ให้สร้างค่าเริ่มต้น
                if (!$hn) {

                    $id = DB::table('hn_running')->insertGetId([
                        'current_number' => 0
                    ]);

                    $hn = DB::table('hn_running')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->first();
                }

                // เพิ่มเลข HN
                $nextHN = $hn->current_number + 1;

                // Update เลขล่าสุด
                DB::table('hn_running')
                    ->where('id', $hn->id)
                    ->update([
                        'current_number' => $nextHN
                    ]);

                // สร้างผู้ป่วย
                $patient = patient::create([
                    'hn' => 'HN' . str_pad($nextHN, 6, '0', STR_PAD_LEFT),
                    'cid' => $request->cid,
                    'firstname_en' => $request->firstname_en,
                    'lastname_en' => $request->lastname_en,

                    'card_issue_date' => $request->card_issue_date,
                    'card_expire_date' => $request->card_expire_date,

                    'card_photo' => $request->card_photo,
                    'nationality' => $request->nationality,
                    'prefix' => $request->prefix,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'birthday' => $request->birthday,
                    'age' => $request->age,
                    'address' => $request->address,
                    'province' => $request->province,
                    'district' => $request->district,
                    'subdistrict' => $request->subdistrict,
                    'zipcode' => $request->zipcode,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                ]);
                return $patient;
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
        // dd($id);
        $request->validate(
            [
                'cid' => [
                    'required',
                    'string',
                    'max:13',
                    Rule::unique('patient', 'cid')
                        ->ignore($id)
                ],
                'firstname' => 'required|string|max:100',
                'lastname' => 'required|string|max:100',
                'birthday' => 'required|date',
                'phone' => 'nullable|string|max:20',
                'prefix' => 'required',
                'age' => 'required|numeric',
                'address' => 'required|string|max:100',
                'province' => 'required|string|max:100',
                'district' => 'required|string|max:100',
                'subdistrict' => 'required|string|max:100',
                'zipcode' => 'required|string|max:100',
                'nationality' => 'required',
                'gender' => 'required|in:ชาย,หญิง',
            ],
            [
                'cid.required' => 'กรุณากรอกเลขบัตรประชาชน',
                'cid.unique' => 'เลขบัตรประชาชนนี้มีในระบบแล้ว',
                'firstname.required' => 'กรุณากรอกชื่อ',
                'lastname.required' => 'กรุณากรอกนามสกุล',
                'nationality.required' => 'กรุณากรอกสัญชาติ',
                'birthday.required' => 'กรุณากรอกวันเดือนปีเกิด',
                'prefix.required' => 'กรุณาเลือกคำนำหน้าชื่อ',
                'address.required' => 'กรุณากรอกที่อยู่',
                'province.required' => 'กรุณากรอกจังหวัด',
                'district.required' => 'กรุณากรอกอำเภอ',
                'subdistrict.required' => 'กรุณากรอกตำบล',
                'zipcode.required' => 'กรุณากรอกรหัสไปรษณีย์',
                'gender.required' => 'กรุณาเลือกเพศ',
                'gender.in' => 'ข้อมูลเพศไม่ถูกต้อง',
            ]
        );

        try {

            $patient = Patient::findOrFail($id);

            $patient->update([
                'cid' => $request->cid,
                'nationality' => $request->nationality,
                'firstname_en' => $request->firstname_en,
                'lastname_en' => $request->lastname_en,

                'card_issue_date' => $request->card_issue_date,
                'card_expire_date' => $request->card_expire_date,

                'card_photo' => $request->card_photo,
                'prefix' => $request->prefix,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'birthday' => $request->birthday,
                'age' => $request->age,
                'address' => $request->address,
                'province' => $request->province,
                'district' => $request->district,
                'subdistrict' => $request->subdistrict,
                'zipcode' => $request->zipcode,
                'phone' => $request->phone,
                'gender' => $request->gender,
            ]);

            return redirect()
                ->route('patient.index')
                ->with('success', 'แก้ไขข้อมูลผู้ป่วยเรียบร้อย');
        } catch (\Exception $e) {

            Log::error($e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'เกิดข้อผิดพลาด');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
