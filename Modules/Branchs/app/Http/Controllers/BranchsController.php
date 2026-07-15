<?php

namespace Modules\Branchs\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Branchs\Models\Branchs;
use Modules\Document\Models\Document;

class BranchsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branchs = branchs::get();
        return view('branchs::branchs.index', compact('branchs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branchs::branchs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. ตรวจสอบความถูกต้องของข้อมูล (Validation)
        $validated = $request->validate([
            'code'    => 'required|string|max:50|unique:branches,code',
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string|max:1000',
            'phone'   => 'nullable|string|max:20',
            'license' => 'nullable|string|max:100',
        ], [
            // กำหนดข้อความแจ้งเตือนภาษาไทยแบบเจาะจง
            'code.required' => 'กรุณาระบุรหัสสาขา',
            'code.unique'   => 'รหัสสาขานี้มีอยู่ในระบบแล้ว',
            'name.required' => 'กรุณาระบุชื่อสาขา',
        ]);

        // 2. จัดการข้อมูลสำหรับ Checkbox (Active Status)
        // หากถูกติ๊กเลือกจะได้ค่าเป็น '1' หากไม่ถูกเลือกจะได้ค่าเป็น '0'
        $validated['active'] = $request->has('active') ? 1 : 0;

        // 3. บันทึกข้อมูลลงฐานข้อมูล
        Branchs::create($validated);

        // 4. ส่งกลับหน้าหลักพร้อมข้อความแจ้งเตือนความสำเร็จ (Flash Message)
        return redirect()
            ->route('branchs.index')
            ->with('success', 'เพิ่มสาขาใหม่เรียบร้อยแล้ว');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('branchs::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $branchs = branchs::find($id);
        return view('branchs::branchs.edit', compact('branchs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. ตรวจสอบความถูกต้องของข้อมูล (Validation)
        // เพิ่มการยกเว้น ID ปัจจุบัน (ignore current ID) เพื่อป้องกันไม่ให้ชนกับรหัสเดิมของตัวเอง
        $validated = $request->validate([
            'code'    => 'required|string|max:50|unique:branches,code,' . $id,
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string|max:1000',
            'phone'   => 'nullable|string|max:20',
            'license' => 'nullable|string|max:100',
        ], [
            'code.required' => 'กรุณาระบุรหัสสาขา',
            'code.unique'   => 'รหัสสาขานี้มีอยู่ในระบบแล้ว',
            'name.required' => 'กรุณาระบุชื่อสาขา',
        ]);

        // 2. ค้นหาข้อมูลสาขาที่ต้องการแก้ไขจากฐานข้อมูล
        // หากไม่พบข้อมูล จะโยน Error 404 (Not Found) ออกไปทันที ป้องกันระบบแครช
        $branch = Branchs::findOrFail($id);

        // 3. จัดการข้อมูลสำหรับ Checkbox (Active Status)
        $validated['active'] = $request->has('active') ? 1 : 0;

        // 4. บันทึกการเปลี่ยนแปลงข้อมูลลงในโมเดลที่ค้นหาเจอ
        $branch->update($validated);

        // 5. ส่งกลับหน้าหลักพร้อมข้อความแจ้งเตือนความสำเร็จ (Flash Message)
        return redirect()
            ->route('branchs.index')
            ->with('success', 'แก้ไขข้อมูลสาขาเรียบร้อยแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy($id)
    {
        $branch = Branchs::findOrFail($id);

        // ตรวจสอบว่ามีเอกสารใช้งานสาขานี้อยู่หรือไม่
        if (Document::where('branch_id', $branch->id)->exists()) {
            return redirect()
                ->route('branchs.index')
                ->with('error', 'ไม่สามารถลบสาขาได้ เนื่องจากมีข้อมูลเอกสารที่อ้างอิงสาขานี้อยู่');
        }

        $branch->delete();

        return redirect()
            ->route('branchs.index')
            ->with('success', 'ลบสาขาสำเร็จ');
    }
}
