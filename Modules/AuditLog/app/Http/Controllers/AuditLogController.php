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
            ->where('branch_id', $user->branch_id)

            ->when($request->search, function ($q) use ($request) {

                $search = $request->search;

                $q->where(function ($query) use ($search) {

                    $query->where('description', 'like', "%{$search}%")
                        ->orWhere('ip_address', 'like', "%{$search}%")
                        ->orWhere('auditable_id', $search);
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



        $branches = Branchs::where(
            'id',
            $user->branch_id
        )
            ->where('active', 1)
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
