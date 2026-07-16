<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Modules\Branchs\Models\Branchs;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $branches = Branchs::where('active', 1)->get();

        return view('auth.register', compact('branches'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',

            'username' => [
                'required',
                Rule::unique('user', 'username'),
            ],

            'password' => 'required|min:6',

            'branch_id' => [
                'nullable',
                'exists:branches,id'
            ],

        ], [
            'username.unique' => 'Username นี้มีอยู่ในระบบแล้ว กรุณาใช้ Username อื่น',
            'username.required' => 'กรุณากรอก Username',
        ]);


        $user = User::create([
            'name' => $request->name,

            'username' => $request->username,

            'password' => bcrypt($request->password),

            'branch_id' => $request->branch_id,

            'active' => 1,
        ]);


        $user->roles()->attach(
            $request->role ?? 4
        );


        return redirect()
            ->route('dashboards.index')
            ->with('success', 'เพิ่มผู้ใช้งานสำเร็จ');
    }
}
