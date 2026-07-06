@extends('core::components.layouts.master')

<link rel="stylesheet" href="{{ asset('css/profile_edit.css') }}">

@section('content')
<div class="profile-wrapper">

    <div class="profile-card">

        <div class="profile-header">
            <h4>✏️ แก้ไขโปรไฟล์</h4>
        </div>

        <div class="profile-body">

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ชื่อ --}}
                <div class="form-group">
                    <label>ชื่อ</label>
                    <input type="text" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', auth()->user()->name) }}"
                        placeholder="กรอกชื่อ">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Username --}}
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username"
                        class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username', auth()->user()->username) }}"
                        placeholder="username">
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                {{-- Password --}}
                <div class="form-group">
                    <label>รหัสผ่านใหม่</label>
                    <input type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="ใส่เฉพาะถ้าต้องการเปลี่ยน">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirm --}}
                <div class="form-group">
                    <label>ยืนยันรหัสผ่าน</label>
                    <input type="password" name="password_confirmation"
                        class="form-control"
                        placeholder="ยืนยันรหัสผ่าน">
                </div>

                <button type="submit" class="btn-save">
                    💾 บันทึกข้อมูล
                </button>

            </form>

        </div>

    </div>

</div>
@endsection