@extends('core::components.layouts.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/error.css') }}">
@endpush
@section('content')
    <div class="container" style="max-width:1500px;margin:auto">
        <div class="card-custom">

            <div class="card-header">
                <h2>👥 รายชื่อสาขา</h2>
                <span>จำนวน {{ $branchs->count() }} สาขา</span>
            </div>
            @if (session('success'))
                <div class="notify notify-success">
                    <div class="notify-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>

                    <div class="notify-content">
                        <h6>ดำเนินการสำเร็จ</h6>
                        <p>{{ session('success') }}</p>
                    </div>

                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="notify notify-danger">
                    <div class="notify-icon">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>

                    <div class="notify-content">
                        <h6>เกิดข้อผิดพลาด</h6>
                        <p>{{ session('error') }}</p>
                    </div>

                    <button class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="notify notify-warning">

                    <div class="notify-icon">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>

                    <div class="notify-content">

                        <h6>กรุณาตรวจสอบข้อมูล</h6>

                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>

                    <button class="btn-close" data-bs-dismiss="alert"></button>

                </div>
            @endif
            {{-- แจ้งเตือนเมื่อข้อมูลผิดพลาด (Validation Errors) --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm d-flex align-items-start gap-3 mb-4"
                    role="alert">

                    <div class="alert-icon bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px; flex-shrink: 0; margin-top: 2px;">
                        <i class="bi bi-exclamation-triangle-fill fs-6"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading fw-bold text-danger-emphasis mb-1">เกิดข้อผิดพลาดในการกรอกข้อมูล:</h6>
                        <ul class="mb-0 ps-3 text-danger-emphasis list-unstyled" style="font-size: 0.9rem;">
                            @foreach ($errors->all() as $error)
                                <li class="d-flex align-items-center gap-1 mb-0.5">
                                    <span class="text-danger">•</span> {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-container">
                <div style="display:flex; justify-content:flex-end; margin-bottom:10px;">
                    <a href="{{ route('branchs.create') }}" style="font-weight:bold;text-decoration:none;">
                        เพิ่มสาขา
                    </a>
                </div>
                <table class="table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>รหัสสาขา</th>
                            <th>ชื่อสาขา</th>
                            <th>ที่อยู่</th>
                            <th>เลขใบอนุญาต</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($branchs as $branch)
                            <tr>
                                <td class="align-middle text-center">{{ $loop->iteration }}</td>

                                <td class="align-middle fw-semibold text-dark">
                                    {{ $branch->code }}
                                </td>

                                <td class="align-middle">
                                    {{ $branch->name }}
                                </td>

                                <td class="align-middle text-muted" style="max-width: 250px;">
                                    <div class="text-line-clamp-3">
                                        {{ $branch->address ?: '-' }}
                                    </div>
                                </td>

                                <td class="align-middle">
                                    {{ $branch->phone ?: '-' }}
                                </td>

                                <td>
                                    @if ($branch->active == '1')
                                        <span class="badge badge-success">
                                            ใช้งาน
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            ปิดใช้งาน
                                        </span>
                                    @endif
                                </td>

                                <td>

                                    <a href="{{ route('branchs.edit', $branch->id) }}" class="btn-action btn-edit">
                                        แก้ไข
                                    </a>

                                    <form action="{{ route('branchs.destroy', $branch->id) }}" method="POST"
                                        style="display:inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-action btn-delete"
                                            onclick="return confirm('ยืนยันการลบข้อมูลสาขา?')">
                                            ลบ
                                        </button>

                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>
@endsection
