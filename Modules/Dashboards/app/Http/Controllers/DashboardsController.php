<?php

namespace Modules\Dashboards\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Patient\Models\Patient;
use Modules\Medics\Models\medics;
use Modules\Document\Models\Document;
use Modules\Document\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->date) {

            try {

                if (str_contains($request->date, '/')) {
                    // รูปแบบ 12/07/2026
                    $date = Carbon::createFromFormat('d/m/Y', $request->date)
                        ->format('Y-m-d');
                } else {
                    // รูปแบบ 2026-07-12
                    $date = Carbon::parse($request->date)
                        ->format('Y-m-d');
                }
            } catch (\Exception $e) {

                $date = Carbon::now()->format('Y-m-d');
            }
        } else {

            $date = Carbon::now()->format('Y-m-d');
        }


        $data = [
            'patients' => patient::count(),
            'medics' => medics::count(),
            'documents' => Document::count(),
            'visits' => Visit::whereDate('created_at', $date)->count(),
            'searchDate' => $date,
        ];


        return view('dashboards::dashboards.index', $data);
    }
}
