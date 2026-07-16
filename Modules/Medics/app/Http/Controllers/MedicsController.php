<?php

namespace Modules\Medics\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Medics\Models\Professions;
use Modules\Medics\Models\MedicProfessions;
use Modules\Medics\Models\medics;
use DB;

class MedicsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medics = medics::get();
        // dd($medics);
        return view('medics::medics.index', compact('medics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $professions = Professions::get();
        return view('medics::medics.create', compact('professions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([

            'profession_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'profession_ids.*' => [
                'required',
                'exists:professions,id',
            ],


            'prefix' => [
                'required',
                'string',
            ],


            'firstname' => [
                'required',
                'string',
                'max:255',
            ],


            'lastname' => [
                'required',
                'string',
                'max:255',
            ],


            'license' => [
                'required',
                'string',
                'max:100',
                'unique:medics,license',
            ],


            'signature' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],


            'status' => [
                'required',
                'boolean',
            ],

        ], [

            'profession_ids.required' => 'กรุณาเลือกวิชาชีพอย่างน้อย 1 รายการ',
            'profession_ids.array'    => 'ข้อมูลวิชาชีพไม่ถูกต้อง',
            'profession_ids.min'      => 'กรุณาเลือกวิชาชีพอย่างน้อย 1 รายการ',

            'profession_ids.*.required' => 'กรุณาเลือกวิชาชีพ',
            'profession_ids.*.exists'   => 'ไม่พบข้อมูลวิชาชีพนี้',


            'prefix.required' => 'กรุณาเลือกคำนำหน้า',
            'prefix.string'   => 'คำนำหน้าต้องเป็นข้อความ',


            'firstname.required' => 'กรุณากรอกชื่อ',
            'firstname.string'   => 'ชื่อต้องเป็นข้อความ',
            'firstname.max'      => 'ชื่อยาวเกิน 255 ตัวอักษร',


            'lastname.required' => 'กรุณากรอกนามสกุล',
            'lastname.string'   => 'นามสกุลต้องเป็นข้อความ',
            'lastname.max'      => 'นามสกุลยาวเกิน 255 ตัวอักษร',


            'license.required' => 'กรุณากรอกเลขใบอนุญาต',
            'license.string'   => 'เลขใบอนุญาตต้องเป็นข้อความ',
            'license.max'      => 'เลขใบอนุญาตยาวเกิน 100 ตัวอักษร',
            'license.unique'   => 'เลขใบอนุญาตนี้มีอยู่ในระบบแล้ว',


            'signature.image' => 'ไฟล์ลายเซ็นต้องเป็นรูปภาพเท่านั้น',
            'signature.mimes' => 'รองรับเฉพาะไฟล์ JPG, JPEG และ PNG',
            'signature.max'   => 'ขนาดไฟล์ลายเซ็นต้องไม่เกิน 2 MB',


            'status.required' => 'กรุณาเลือกสถานะ',
            'status.boolean'  => 'สถานะไม่ถูกต้อง',

        ]);

        try {

            $medic = DB::transaction(function () use ($request) {

                $signature = null;

                if ($request->hasFile('signature') && $request->file('signature')->isValid()) {

                    $signature = $request->file('signature')
                        ->store('medics/signatures', 'public');
                }


                $medic = Medics::create([
                    'prefix'    => $request->prefix,
                    'firstname' => $request->firstname,
                    'lastname'  => $request->lastname,
                    'license'   => $request->license,
                    'phone'     => $request->phone,
                    'signature' => $signature,
                    'status'    => $request->status,
                ]);


                foreach ($request->profession_ids as $professionId) {

                    MedicProfessions::create([
                        'medic_id'      => $medic->id,
                        'profession_id' => $professionId,
                    ]);
                }


                return $medic;
            });

            return redirect()
                ->route('medics.index')
                ->with('success', 'บันทึกข้อมูลบุคลากรเรียบร้อย');
        } catch (\Exception $e) {
            dd($e);

            Log::error('บันทึกข้อมูลแพทย์ผิดพลาด', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'ไม่สามารถบันทึกข้อมูลได้ : ' . $e->getMessage());
        }
    }

    public function profile($id)
    {
        $medic = Medics::with('professions.profession')
            ->findOrFail($id);

        return view('medics::medics.profile', compact('medic'));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('medics::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $medic = Medics::with('professions')->findOrFail($id);

        $professions = Professions::all();

        return view('medics::medics.edit', compact(
            'medic',
            'professions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {

            $medic = Medics::findOrFail($id);

            $signature = $medic->signature;

            if ($request->hasFile('signature')) {

                $signature = $request->file('signature')
                    ->store('medics/signatures', 'public');
            }


            $medic->update([
                'prefix'    => $request->prefix,
                'firstname' => $request->firstname,
                'lastname'  => $request->lastname,
                'license'   => $request->license,
                'phone'     => $request->phone,
                'signature' => $signature,
                'status'    => $request->status,
            ]);

            // ลบวิชาชีพเก่า
            MedicProfessions::where('medic_id', $medic->id)
                ->delete();

            // เพิ่มวิชาชีพใหม่
            foreach ($request->profession_ids ?? [] as $professionId) {

                MedicProfessions::create([
                    'medic_id'       => $medic->id,
                    'profession_id' => $professionId,
                ]);
            }
        });


        return redirect()
            ->route('medics.index')
            ->with('success', 'แก้ไขข้อมูลแพทย์เรียบร้อยแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $medic = medics::findOrFail($id);

            // ลบข้อมูลวิชาชีพของแพทย์ก่อน
            $medic->professions()->delete();

            // ลบข้อมูลแพทย์
            $medic->delete();


            return redirect()
                ->route('medics.index')
                ->with('success', 'ลบข้อมูลแพทย์เรียบร้อยแล้ว');
        } catch (\Exception $e) {

            return redirect()
                ->route('medics.index')
                ->with('error', 'ไม่สามารถลบข้อมูลแพทย์ได้');
        }
    }
}
