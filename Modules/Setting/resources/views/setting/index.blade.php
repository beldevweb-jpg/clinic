@extends('core::components.layouts.master')

<link rel="stylesheet" href="{{ asset('css/setting.css') }}">
@section('content')
    <div class="container py-5">

        <div class="settings-wrapper">

            <div class="settings-card">

                <div class="settings-header">
                    <h4>⚙ ตั้งค่าระบบ</h4>
                    <p>จัดการข้อมูลการตั้งค่าทั่วไป</p>
                </div>

                <div class="settings-body">
                    <form action="{{ route('setting.update', $setting->id ?? 1) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Site Name --}}
                        <div class="mb-3">
                            <label class="form-label">ชื่อคลีนิค</label>
                            <input type="text" name="clinic" class="form-control"
                                value="{{ old('clinic', $setting->clinic ?? '') }}" placeholder="กรอกชื่อเว็บไซต์">
                        </div>

                        {{-- license --}}
                        <div class="mb-3">
                            <label class="form-label">หนังสือรับรอง เลขที่</label>
                            <input type="text" name="license" class="form-control"
                                value="{{ old('license', $setting->license ?? '') }}" placeholder="เลข 11 หลัก">
                        </div>

                        {{-- Phone --}}
                        <div class="mb-3">
                            <label class="form-label">เบอร์โทร</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $setting->phone ?? '') }}" placeholder="08xxxxxxxx">
                        </div>

                        {{-- Address --}}
                        <div class="mb-3">
                            <label class="form-label">ที่อยู่</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="กรอกที่อยู่">{{ old('address', $setting->address ?? '') }}</textarea>
                        </div>

                        {{-- image --}}
                        <div class="mb-3">
                            <label class="form-label">Logo</label>

                            <input type="file" name="logo" class="form-control" accept="image/*">

                            @if (!empty($setting->logo))
                                <img src="{{ asset('uploads/logo/' . $setting->logo) }}"
                                    style="width:100px; margin-top:10px; border-radius:10px;">
                            @endif
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                💾 บันทึกข้อมูล
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection
