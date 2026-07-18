<?php

namespace Modules\Dashboards\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Patient\Models\Patient;
use Modules\Medics\Models\medics;
use Modules\Document\Models\Document;
use Modules\Document\Models\Visits;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Branchs\Models\Branchs;

class DashboardsController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date
            ? Carbon::parse($request->date)->format('Y-m-d')
            : Carbon::now()->format('Y-m-d');


        $user = auth()->user();

        $branchId = $user->branch_id;


        $branchVisits = Branchs::withCount([
            'visits as total_visits' => function ($query) use ($date) {

                $query->whereDate('visit_date', $date);
            }
        ])
            ->when($branchId, function ($query) use ($branchId) {

                $query->where('id', $branchId);
            })
            ->get();



        $latestVisits = Visits::with([
            'patient',
            'medic',
            'branch'
        ])
            ->whereDate('visit_date', $date)
            ->when($branchId, function ($query) use ($branchId) {

                $query->where('branch_id', $branchId);
            })
            ->latest()
            ->limit(10)
            ->get();



        $data = [

            // ผู้ป่วยทั้งหมด
            'patients' => Patient::count(),

            // แพทย์ทั้งหมด

            'medics' => medics::count(),

            // เอกสารทั้งหมด
            'documents' => Document::when($branchId, function ($query) use ($branchId) {

                $query->where('branch_id', $branchId);
            })->count(),



            // เข้าใช้บริการวันนี้
            'visits' => Visits::whereDate(
                'visit_date',
                $date
            )
                ->when($branchId, function ($query) use ($branchId) {

                    $query->where('branch_id', $branchId);
                })
                ->count(),



            // ผู้ป่วยใหม่วันนี้ (ตามสาขา)
            'newPatients' => Visits::whereDate(
                'visit_date',
                $date
            )
                ->when($branchId, function ($query) use ($branchId) {

                    $query->where('branch_id', $branchId);
                })
                ->whereHas('patient', function ($query) use ($date) {

                    $query->whereDate('created_at', $date);
                })
                ->distinct('patient_id')
                ->count('patient_id'),



            // เอกสารวันนี้
            'todayDocuments' => Document::whereDate(
                'created_at',
                $date
            )
                ->when($branchId, function ($query) use ($branchId) {

                    $query->where('branch_id', $branchId);
                })
                ->count(),



            'branchVisits' => $branchVisits,
            'latestVisits' => $latestVisits,
            'searchDate' => $date,

        ];


        return view(
            'dashboards::dashboards.index',
            $data
        );
    }

    public function visitsList()
    {
        $visits = Visits::with([
            'patient',
            'medic',
            'branch'
        ])
            ->latest()
            ->paginate(20);


        return view(
            'dashboards::dashboards.visitsList',
            compact('visits')
        );
    }
}
