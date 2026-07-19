@extends('core::components.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/branch.css') }}">
@endpush

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
        <div class="card branch-card shadow-sm border-0 mx-auto">

            <div class="card-header bg-light py-3 px-4 d-flex align-items-center gap-2 border-bottom">
                <div
                    class="branch-icon-wrapper bg-white text-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center">
                    <i class="bi bi-building-plus fs-5"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold text-dark">เพิ่มสาขาใหม่</h5>
                    <small class="text-muted">กรอกข้อมูลรายละเอียดเพื่อสร้างสาขาใหม่ในระบบ</small>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <form action="{{ route('branchs.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="form-section mb-4">
                        <h6 class="text-primary fw-bold mb-3 d-flex align-items-center gap-2">
                            <span class="badge bg-primary-subtle text-primary rounded-circle p-1">1</span>
                            ข้อมูลพื้นฐาน
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="code" class="form-label fw-semibold">รหัสสาขา <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="code" id="code"
                                    class="form-control custom-input @error('code') is-invalid @enderror"
                                    value="{{ old('code') }}" placeholder="เช่น BR001" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <label for="name" class="form-label fw-semibold">ชื่อสาขา <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control custom-input @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="ระบุชื่อสาขาเต็ม" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="text-muted opacity-25 my-4">

                    <div class="form-section mb-4">
                        <h6 class="text-primary fw-bold mb-3 d-flex align-items-center gap-2">
                            <span class="badge bg-primary-subtle text-primary rounded-circle p-1">2</span>
                            ข้อมูลติดต่อและที่อยู่
                        </h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">เบอร์โทรศัพท์</label>
                                <input type="tel" name="phone" id="phone"
                                    class="form-control custom-input @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}" placeholder="เช่น 02-XXX-XXXX">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="license" class="form-label fw-semibold">เลขใบอนุญาต</label>
                                <input type="text" name="license" id="license"
                                    class="form-control custom-input @error('license') is-invalid @enderror"
                                    value="{{ old('license') }}" placeholder="ระบุเลขใบอนุญาตประกอบการ">
                                @error('license')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="address" class="form-label fw-semibold">ที่อยู่สาขา</label>
                                <textarea name="address" id="address" class="form-control custom-input @error('address') is-invalid @enderror"
                                    rows="3" placeholder="ระบุที่อยู่, ถนน, แขวง/ตำบล, เขต/อำเภอ, จังหวัด..."></textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="text-muted opacity-25 my-4">

                    <div class="form-section mb-5">
                        <div class="card bg-light border-0 rounded-3 p-3">
                            <div class="form-check form-switch d-flex align-items-center gap-3 ps-5">
                                <input type="checkbox" name="active" id="active" value="1"
                                    class="form-check-input custom-switch fs-5 m-0"
                                    {{ old('active', '1') == '1' ? 'checked' : '' }}>
                                <div>
                                    <label class="form-check-label fw-bold text-dark d-block"
                                        for="active">เปิดใช้งานสาขานี้ทันที</label>
                                    <small class="text-muted">หากปิดใช้งาน สาขานี้จะไม่แสดงผลในหน้ารายการอื่น ๆ</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center gap-2 pt-2">
                        <a href="{{ route('branchs.index') }}"
                            class="btn btn-light px-4 py-2 border fw-semibold text-secondary">
                            ยกเลิก
                        </a>
                        <button type="submit"
                            class="btn btn-primary px-4 py-2 fw-semibold shadow-sm d-flex align-items-center gap-2">
                            <i class="bi bi-cloud-arrow-up-fill"></i> บันทึกข้อมูล
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection
