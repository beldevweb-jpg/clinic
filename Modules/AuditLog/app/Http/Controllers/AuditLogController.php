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
        $user = auth()->user();


        $logs = AuditLog::with([
            'user',
            'branch'
        ])


            // Admin เห็นทั้งหมด
            // User อื่นเห็นเฉพาะสาขาตัวเอง
            ->when(
                !$user->hasRole('Admin'),
                function ($q) use ($user) {

                    $q->where(
                        'branch_id',
                        $user->branch_id
                    );
                }
            )


            // Admin filter สาขา
            ->when(
                $request->branch_id
                    && $user->hasRole('Admin'),
                function ($q) use ($request) {

                    $q->where(
                        'branch_id',
                        $request->branch_id
                    );
                }
            )


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



        $branches = Branchs::where('active', 1)

            ->when(
                !$user->hasRole('Admin'),
                function ($q) use ($user) {

                    $q->where(
                        'id',
                        $user->branch_id
                    );
                }
            )

            ->get();



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
        $user = auth()->user();

        $log = AuditLog::with([
            'user',
            'branch'
        ])

            ->when(
                !$user->hasRole('Admin') && $user->branch_id,
                function ($q) use ($user) {

                    $q->where(
                        'branch_id',
                        $user->branch_id
                    );
                }
            )

            ->findOrFail($id);


        return view(
            'auditlog::show',
            compact('log')
        );
    }
}
