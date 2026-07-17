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

            'name' => 'required|string|max:255',

            'username' => [
                'required',
                Rule::unique('user', 'username')
                    ->where('branch_id', $request->branch_id),
            ],

            'password' => 'required|min:6',

            'branch_id' => [
                'required',
                'exists:branches,id'
            ],

        ], [

            'username.unique' => 'Username นี้มีอยู่แล้วในสาขานี้',
            'username.required' => 'กรุณากรอก Username',

            'branch_id.required' => 'กรุณาเลือกสาขา',
            'branch_id.exists' => 'ไม่พบข้อมูลสาขา',

        ]);


        $user = User::create([

            'name' => $request->name,

            'username' => $request->username,

            'password' => Hash::make($request->password),

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
