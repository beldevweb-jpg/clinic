<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        // dd($user);
        return view('User::user.index', compact('users'));
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
        $User = User::findOrFail($id);

        return view('User::User.edit', compact('User'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $User = User::findOrFail($id);


        $request->validate([
            'name' => 'required',
            'Username' => 'required',
        ]);


        $User->name = $request->name;
        $User->Username = $request->Username;


        // ถ้ามีการกรอกรหัสผ่านใหม่ ให้ Hash ก่อนบันทึก
        if ($request->filled('password')) {

            $User->password = Hash::make($request->password);
        }


        $User->save();


        return redirect()
            ->route('User.index')
            ->with('success', 'แก้ไขผู้ใช้งานเรียบร้อยแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        if ($user->roles === 'admin') {
            return back()->withErrors([
                'ไม่สามารถลบผู้ดูแลระบบได้'
            ]);
        }

        $user->delete();

        return back()->with('success', 'ลบผู้ใช้งานเรียบร้อยแล้ว');
    }
}
