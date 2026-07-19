<?php

namespace Modules\Visits\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Patient\Models\Patient;
use Modules\Medics\Models\Medics;
use Modules\Visits\Models\Visits;

class VisitsController extends Controller
{

    public function index()
    {
        $user = auth()->user();


        $visits = Visits::with([
            'patient',
            'medic',
            'branch'
        ])

            ->when($user->branch_id, function ($q) use ($user) {

                $q->where(
                    'branch_id',
                    $user->branch_id
                );
            })

            ->orderBy('visit_date', 'desc')
            ->paginate(20);



        return view(
            'visits::visits.index',
            compact('visits')
        );
    }


    public function create()
    {
        $user = auth()->user();


        $patients = Patient::when(
            !$user->hasRole('Admin'),
            function ($q) use ($user) {

                $q->where(
                    'branch_id',
                    $user->branch_id
                );
            }
        )
            ->orderBy('firstname')
            ->get();



        $medics = Medics::when(
            !$user->hasRole('Admin'),
            function ($q) use ($user) {

                $q->where(
                    'branch_id',
                    $user->branch_id
                );
            }
        )
            ->where('status', 1)
            ->get();



        return view(
            'visits::visits.create',
            compact(
                'patients',
                'medics'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'patient_id' => 'required|exists:patient,id',

            'medic_id' => 'required|exists:medics,id',

            'visit_date' => 'required|date',

            'note' => 'nullable|string',
            'type' => 'required|in:register,pt28,pt33,manual',

        ]);

        Visits::create([

            'branch_id' => auth()->user()->branch_id,

            'patient_id' => $request->patient_id,

            'medic_id' => $request->medic_id,

            'visit_date' => $request->visit_date,

            'type' => 'manual',

            'note' => $request->note,

        ]);


        return redirect()
            ->route('visits.index')
            ->with(
                'success',
                'บันทึกข้อมูลเรียบร้อย'
            );
    }

    public function edit($id)
    {
        $user = auth()->user();

        $visit = Visits::when(
            !$user->hasRole('Admin'),
            function ($q) use ($user) {
                $q->where('branch_id', $user->branch_id);
            }
        )->findOrFail($id);

        $patients = Patient::orderBy('firstname')->get();

        $medics = Medics::where('active', 1)->get();

        return view(
            'visits::edit',
            compact(
                'visit',
                'patients',
                'medics'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        $request->validate([
            'patient_id' => 'required|exists:patient,id',
            'medic_id'   => 'required|exists:medics,id',
            'visit_date' => 'required|date',
            'note'       => 'nullable|string',
            'type' => 'required|in:register,pt28,pt33,manual',
        ]);

        $visit = Visits::when(
            !$user->hasRole('Admin'),
            function ($q) use ($user) {
                $q->where('branch_id', $user->branch_id);
            }
        )->findOrFail($id);

        $visit->update([

            'patient_id' => $request->patient_id,

            'medic_id'   => $request->medic_id,

            'visit_date' => $request->visit_date,

            'type'       => $request->type,

            'note'       => $request->note,

        ]);

        return redirect()
            ->route('visits.index')
            ->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    public function destroy($id)
    {
        $user = auth()->user();


        $visit = Visits::when(
            !$user->hasRole('Admin'),
            function ($q) use ($user) {

                $q->where(
                    'branch_id',
                    $user->branch_id
                );
            }
        )
            ->findOrFail($id);



        $visit->delete();



        return redirect()
            ->route('visits.index')
            ->with(
                'success',
                'ลบข้อมูลเรียบร้อย'
            );
    }
}
