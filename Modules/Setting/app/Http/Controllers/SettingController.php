<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Setting\Models\setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::first();
        return view('setting::setting.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('setting::create');
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
        return view('setting::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('setting::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'clinic'  => 'required|string',
            'license' => 'required|numeric',
            'phone'   => 'required|numeric',
            'address' => 'required|string',
            'logo'    => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        // dd($request);
        $setting = Setting::firstOrCreate(['id' => 1]);

        $data = [
            'clinic'  => $request->clinic,
            'license' => $request->license,
            'phone'   => $request->phone,
            'address' => $request->address,
        ];

        // 🔥 upload logo
        if ($request->hasFile('logo')) {

            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/logo'), $filename);

            $data['logo'] = $filename;
        }

        if (!empty($setting->logo)) {
            $oldPath = public_path('uploads/logo/' . $setting->logo);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $setting->update($data);

        return redirect()->route('dashboards.index')
            ->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
