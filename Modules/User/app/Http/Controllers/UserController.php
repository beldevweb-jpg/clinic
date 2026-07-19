<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Branchs\Models\Branchs;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = User::with(['roles', 'branch']);

        if (!auth()->user()->hasRole('admin')) {
            $query->where('branch_id', auth()->user()->branch_id);
        }

        $users = $query->get();
        return view('user::user.index', compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('User::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('User::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);

        $branches = Branchs::where('active', 1)->get();

        $roles = Roles::all();


        return view('user::user.edit', compact(
            'user',
            'branches',
            'roles'
        ));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $User = User::findOrFail($id);

        $request->validate([
            'name' => 'required',

            'username' => [
                'required',
                Rule::unique('user', 'username')
                    ->where(function ($query) use ($request) {
                        return $query->where('branch_id', $request->branch_id);
                    })
                    ->ignore($User->id),
            ],

            'password' => [
                'nullable',
                'min:6',
                'confirmed',
            ],

            'branch_id' => [
                'nullable',
                'exists:branches,id',
            ],

            'active' => [
                'required',
                'boolean',
            ],

            'role' => [
                'required',
                'exists:roles,id',
            ],

        ], [
            'name.required' => 'กรุณากรอกชื่อ',

            'username.required' => 'กรุณากรอก Username',
            'username.unique' => 'Username นี้มีอยู่ในสาขานี้แล้ว',

            'password.min' => 'รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร',
            'password.confirmed' => 'ยืนยันรหัสผ่านไม่ตรงกัน',

            'branch_id.exists' => 'ไม่พบข้อมูลสาขาที่เลือก',

            'active.required' => 'กรุณาเลือกสถานะ',
            'active.boolean' => 'สถานะไม่ถูกต้อง',

            'role.required' => 'กรุณาเลือกสิทธิ์ผู้ใช้งาน',
            'role.exists' => 'ไม่พบสิทธิ์ที่เลือก',
        ]);


        $User->name = $request->name;

        $User->username = $request->username;

        $User->branch_id = $request->branch_id;

        $User->active = $request->active;


        // ถ้ามีการเปลี่ยนรหัสผ่าน
        if ($request->filled('password')) {

            $User->password = Hash::make($request->password);
        }


        $User->save();


        // Update Role
        $User->roles()->sync([
            $request->role
        ]);


        return redirect()
            ->route('user.index')
            ->with('success', 'แก้ไขผู้ใช้งานเรียบร้อยแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // ห้ามปิด Admin
        if ($user->hasRole('admin')) {

            return back()
                ->with('error', 'ไม่สามารถปิดการใช้งาน Admin ได้');
        }


        // ปิดใช้งานแทนการลบ
        $user->update([
            'active' => 0
        ]);


        return back()
            ->with('success', 'ปิดการใช้งานผู้ใช้งานเรียบร้อยแล้ว');
    }
}
