@extends('core::components.layouts.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
@endpush
@section('content')
    <div class="container" style="max-width:1500px;margin:auto">
        <div class="card-custom">
            <div class="card-header">
                <h2>👥 รายชื่อผู้ป่วย</h2>
                <span>จำนวน {{ count($patient) }} คน</span>
            </div>
            {{-- แจ้งเตือน --}}
            @if (session('success'))
                <div class="alert success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert error">
                    @foreach ($errors->all() as $error)
                        <div>• {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="table-container">
                <div style="display:flex; justify-content:flex-end; margin-bottom:10px;">
                    <a href="{{ route('patient.create') }}" style="font-weight:bold;text-decoration:none;">
                        เพิ่มผู้ป่วย
                    </a>
                </div>
                <table class="table">

                    <thead>
                        <tr>
                            <th>ลำดับ</th>
                            <th>HN</th>
                            <th>ชื่อ-นามสกุล</th>
                            <th>อายุ</th>
                            <th>เพศ</th>
                            <th>เบอร์โทร</th>
                            <th>วันที่เข้ารับบริการล่าสุด</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($patient as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->hn }}</td>
                                <td>{{ $item->prefix }} {{ $item->firstname }} {{ $item->lastname }}</td>
                                <td>{{ $item->age }}</td>
                                <td>{{ $item->gender }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>
                                    @if ($item->visits->count())
                                        {{ \Carbon\Carbon::parse($item->visits->first()->created_at)->format('d/m/Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('patient.edit', $item->id) }}" class="btn-action btn-edit">แก้ไข</a>
                                    <a href="#" class="btn-action btn-delete">ลบ</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>
@endsection
