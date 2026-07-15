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



        // สาขา + จำนวนเข้าใช้บริการ
        $branchVisits = Branchs::withCount([
            'visits as total_visits' => function ($query) use ($date) {

                $query->whereDate('visit_date', $date);
            }

        ])->get();



        // รายการเข้าใช้บริการล่าสุด
        $latestVisits = Visits::with([
            'patient',
            'medic',
            'branch'

        ])
            ->whereDate('visit_date', $date)
            ->latest()
            ->limit(10)
            ->get();



        $data = [

            // ผู้ป่วยทั้งหมด
            'patients' => Patient::count(),


            // แพทย์ทั้งหมด
            'medics' => Medics::count(),


            // เอกสารทั้งหมด
            'documents' => Document::count(),


            // เข้าใช้บริการวันนี้
            'visits' => Visits::whereDate(
                'visit_date',
                $date
            )->count(),



            // ผู้ป่วยใหม่
            'newPatients' => Patient::whereDate(
                'created_at',
                $date
            )->count(),



            // เอกสารวันนี้
            'todayDocuments' => Document::whereDate(
                'created_at',
                $date
            )->count(),



            'branchVisits' => $branchVisits,


            // สำคัญ เพิ่มตัวนี้
            'latestVisits' => $latestVisits,


            'searchDate' => $date,

        ];

        return view(
            'dashboards::dashboards.index',
            $data
        );
    }
}
