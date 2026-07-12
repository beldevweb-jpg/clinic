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
                <div style="display:flex; justify-content:flex-end; margin-bottom:10px;">
                    <a href="{{ route('register') }}" style="font-weight:bold;text-decoration:none;">
                        เพิ่มผู้ใช้
                    </a>
                </div>
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
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn-action btn-edit">
                                        แก้ไข
                                    </a>


                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                        style="display:inline;">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-action btn-delete"
                                            onclick="return confirm('ต้องการลบผู้ใช้งานนี้หรือไม่?')">
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
