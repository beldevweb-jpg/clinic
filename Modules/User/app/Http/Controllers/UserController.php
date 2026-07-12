<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\Models\Users;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Users::get();
        return view('user::user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user::create');
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
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Users::findOrFail($id);

        return view('user::user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Users::findOrFail($id);


        $request->validate([
            'name' => 'required',
            'username' => 'required',
        ]);


        $user->name = $request->name;
        $user->username = $request->username;


        // ถ้ามีการกรอกรหัสผ่านใหม่ ให้ Hash ก่อนบันทึก
        if ($request->filled('password')) {

            $user->password = Hash::make($request->password);
        }


        $user->save();


        return redirect()
            ->route('user.index')
            ->with('success', 'แก้ไขผู้ใช้งานเรียบร้อยแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Users $user)
    {
        if ($user->role === 'admin') {
            return back()->withErrors([
                'ไม่สามารถลบผู้ดูแลระบบได้'
            ]);
        }

        $user->delete();

        return back()->with('success', 'ลบผู้ใช้งานเรียบร้อยแล้ว');
    }
}
