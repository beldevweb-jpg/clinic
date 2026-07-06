@extends('core::components.layouts.master')
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
@section('content')
    <div class="container" style="max-width:1500px;margin:auto">
        <div class="card-custom">

            <div class="card-header">
                <h2>👥 รายชื่อผู้ใช้งาน</h2>
                <span>จำนวน {{ $users->count() }} คน</span>
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
                <table class="table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อ</th>
                            <th>Username</th>
                            <th>สถานะ</th>
                            <th>จัดการ</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>

                                <td>
                                    <span class="badge badge-success">
                                        ใช้งาน
                                    </span>
                                </td>

                                <td>
                                    <a href="#" class="btn-action btn-view">ดู</a>
                                    <a href="#" class="btn-action btn-edit">แก้ไข</a>
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
