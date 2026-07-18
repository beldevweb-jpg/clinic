<?php

namespace Modules\Visits\Http\Controllers;

use Illuminate\Routing\Controller;
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

        ->when(
            !$user->hasRole('Admin'),
            function($q) use($user){

                $q->where(
                    'branch_id',
                    $user->branch_id
                );

            }
        )

        ->latest()
        ->paginate(20);



        return view(
            'visits::index',
            compact('visits')
        );
    }
}