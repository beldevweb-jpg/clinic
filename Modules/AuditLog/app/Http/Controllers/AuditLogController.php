<?php

namespace Modules\AuditLog\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\AuditLog\Models\AuditLog;
use Modules\Branchs\Models\Branchs;


class AuditLogController extends Controller
{


    public function index(Request $request)
    {

        $logs = AuditLog::with([
            'user',
            'branch'
        ])

            ->when($request->search, function ($q) use ($request) {

                $search = $request->search;


                $q->where(function ($query) use ($search) {

                    $query->where(
                        'description',
                        'like',
                        "%{$search}%"
                    )

                        ->orWhere(
                            'ip_address',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'auditable_id',
                            $search
                        );
                });
            })


            ->when($request->action, function ($q) use ($request) {

                $q->where(
                    'action',
                    $request->action
                );
            })


            ->when($request->branch_id, function ($q) use ($request) {

                $q->where(
                    'branch_id',
                    $request->branch_id
                );
            })


            ->when($request->start_date, function ($q) use ($request) {

                $q->whereDate(
                    'created_at',
                    '>=',
                    $request->start_date
                );
            })


            ->when($request->end_date, function ($q) use ($request) {

                $q->whereDate(
                    'created_at',
                    '<=',
                    $request->end_date
                );
            })


            ->latest()
            ->paginate(20)
            ->withQueryString();



        $branches = Branchs::where(
            'active',
            1
        )->get();



        return view(
            'auditlog::index',
            compact(
                'logs',
                'branches'
            )
        );
    }




    public function show($id)
    {

        $log = AuditLog::with([
            'user',
            'branch'
        ])
            ->findOrFail($id);



        return view(
            'auditlog::show',
            compact('log')
        );
    }
}
