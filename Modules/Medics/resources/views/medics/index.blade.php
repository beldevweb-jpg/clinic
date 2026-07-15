@extends('core::components.layouts.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/error.css') }}">
@endpush
@section('content')
    <div class="container" style="max-width:1500px;margin:auto">
        <div class="card-custom">

            <div class="card-header">
                <h2>👥 รายชื่อผู้ใช้งาน</h2>
                <span>จำนวน {{ $medics->count() }} คน</span>
            </div>

            {{-- แจ้งเตือน --}}
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

            <div class="table-container">
                <div style="display:flex; justify-content:flex-end; margin-bottom:10px;">
                    <a href="{{ route('medics.create') }}" style="font-weight:bold;text-decoration:none;">
                        เพิ่มแพทย์
                    </a>
                </div>
                <table class="table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อแพทย์</th>
                            <th>เลขใบอนุญาต</th>
                            <th>วิชาชีพ</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($medics as $medic)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    {{ $medic->firstname }} {{ $medic->lastname }}
                                </td>

                                <td>
                                    {{ $medic->license }}
                                </td>

                                <td>
                                    @forelse ($medic->professions as $profession)
                                        <span class="badge badge-info">
                                            {{ $profession->profession->name }}
                                        </span>

                                    @empty

                                        -
                                    @endforelse
                                </td>

                                <td>
                                    @if ($medic->status == 'active')
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
                                    <a href="{{ route('medics.profile', $medic->id) }}" class="btn-action btn-view">
                                        ดู
                                    </a>

                                    <a href="{{ route('medics.edit', $medic->id) }}" class="btn-action btn-edit">
                                        แก้ไข
                                    </a>

                                    <form action="{{ route('medics.destroy', $medic->id) }}" method="POST"
                                        style="display:inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-action btn-delete"
                                            onclick="return confirm('ยืนยันการลบข้อมูลแพทย์?')">
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
