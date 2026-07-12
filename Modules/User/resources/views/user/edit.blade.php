@extends('core::components.layouts.master')

<link rel="stylesheet" href="{{ asset('css/user.css') }}">

@section('content')

    <div class="user-edit-container">

        <div class="user-edit-card">


            <div class="user-edit-header">
                <div>
                    <h2>✏️ แก้ไขผู้ใช้งาน</h2>
                    <small>จัดการข้อมูลบัญชีผู้ใช้งานระบบ</small>
                </div>
            </div>


            @if ($errors->any())
                <div class="user-alert-error">
                    @foreach ($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif



            <form action="{{ route('user.update', $user->id) }}" method="POST">

                @csrf
                @method('PUT')


                <div class="form-grid">


                    <div class="user-form-group">
                        <label>
                            👤 ชื่อ
                        </label>

                        <input type="text" name="name" value="{{ old('name', $user->name) }}">
                    </div>



                    <div class="user-form-group">
                        <label>
                            🔑 Username
                        </label>

                        <input type="text" name="username" value="{{ old('username', $user->username) }}">
                    </div>


                    <div class="user-form-group">
                        <label>
                            🔒 รหัสผ่านใหม่
                        </label>

                        <input type="password" name="password" placeholder="เว้นว่างถ้าไม่เปลี่ยน"
                            autocomplete="new-password">
                    </div>


                    <div class="user-form-group">
                        <label>
                            🔒 ยืนยันรหัสผ่านใหม่
                        </label>

                        <input type="password" name="password_confirmation" placeholder="กรอกรหัสผ่านอีกครั้ง"
                            autocomplete="new-password">
                    </div>


                </div>



                <div class="user-btn-area">

                    <button class="user-btn-save">
                        💾 บันทึกข้อมูล
                    </button>


                    <a href="{{ route('user.index') }}" class="user-btn-cancel">
                        ↩ กลับ
                    </a>

                </div>


            </form>


        </div>

    </div>

@endsection
