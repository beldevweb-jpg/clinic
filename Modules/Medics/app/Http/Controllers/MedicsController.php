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
            'profession_ids'   => 'required|array|min:1',
            'profession_ids.*' => 'required',
            'prefix'           => 'required|string',
            'firstname'        => 'required|string|max:255',
            'lastname'         => 'required|string|max:255',
            'license'          => 'required|string|max:100|unique:medics,license',
            'phone'            => 'nullable|string|max:20',
            'signature'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'           => 'required|boolean',
        ]);

        try {

            DB::transaction(function () use ($request) {

                $signature = null;

                if ($request->hasFile('signature') && $request->file('signature')->isValid()) {

                    $signature = $request->file('signature')->store(
                        'medics/signatures',
                        'public'
                    );
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
                        'medic_id'       => $medic->id,
                        'professions_id' => $professionId,
                    ]);
                }
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
                    'professions_id' => $professionId,
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
