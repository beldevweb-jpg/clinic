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

        // เงื่อนไขสาขา
        $branchId = $user->branch_id;

        // สาขา + จำนวนเข้าใช้บริการ
        $branchVisits = Branchs::withCount([
            'visits as total_visits' => function ($query) use ($date) {
                $query->whereDate('visit_date', $date);
            }
        ])
            ->when($branchId, function ($query) use ($branchId) {
                $query->where('id', $branchId);
            })
            ->get();


        // รายการเข้าใช้บริการล่าสุด
        $latestVisits = Visits::with([
            'patient',
            'medic',
            'branch'
        ])
            ->whereDate('visit_date', $date)
            ->when($branchId, function ($query) use ($branchId) {
                $query->where('branchs_id', $branchId);
            })

            ->latest()
            ->limit(10)
            ->get();

        $data = [

            // ผู้ป่วยทั้งหมด
            'patients' => Patient::when($branchId, function ($query) use ($branchId) {

                $query->where('branch_id', $branchId);
            })->count(),


            // แพทย์ทั้งหมด
            'medics' => Medics::when($branchId, function ($query) use ($branchId) {

                $query->where('branch_id', $branchId);
            })->count(),


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

                    $query->where('branchs_id', $branchId);
                })
                ->count(),

            'newPatients' => Patient::whereDate(
                'created_at',
                $date
            )
                ->when($branchId, function ($query) use ($branchId) {

                    $query->where('branch_id', $branchId);
                })
                ->count(),


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
