@extends('core::components.layouts.master')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <div class="dashboard">

        {{-- Header --}}
        <div class="dashboard-header">
            <div>
                <h2>
                    <i class="fas fa-hospital"></i>
                    ระบบจัดการคลินิก
                </h2>
                <p>
                    สรุปข้อมูลประจำวันที่
                    {{ \Carbon\Carbon::parse($searchDate)->locale('th')->translatedFormat('d F Y') }}
                </p>
            </div>
            <form method="GET" action="{{ route('dashboards.index') }}">
                <div class="date-box">
                    <input type="date" name="date" value="{{ $searchDate }}">
                    <button>
                        <i class="fas fa-search"></i>
                        ค้นหา
                    </button>
                </div>
            </form>
        </div>

        {{-- Cards --}}
        <div class="cards">
            <div class="stat-card blue">
                <div class="icon">
                    <i class="fas fa-user-injured"></i>
                </div>
                <div>
                    <span>ผู้ป่วยทั้งหมด</span>
                    <h2>{{ $patients }}</h2>
                </div>
            </div>
            <div class="stat-card green">
                <div class="icon">
                    <i class="fas fa-user-md"></i>
                </div>
                <div>
                    <span>แพทย์</span>
                    <h2>{{ $medics }}</h2>
                </div>
            </div>

            <div class="stat-card purple">
                <div class="icon">
                    <i class="fas fa-file-medical"></i>
                </div>
                <div>
                    <span>เอกสาร</span>
                    <h2>{{ $documents }}</h2>
                </div>
            </div>

            <div class="stat-card red">
                <div class="icon">
                    <i class="fas fa-notes-medical"></i>
                </div>
                <div>
                    <span>เข้าใช้บริการวันนี้</span>
                    <h2>{{ $visits }}</h2>
                </div>
            </div>
        </div>
        @if (auth()->user()->hasRole('admin'))
            {{-- Branch --}}
            <div class="branch-card">
                <div class="title">
                    <i class="fas fa-building"></i>
                    <h3>
                        ยอดเข้าใช้บริการแต่ละสาขา
                    </h3>
                </div>
                <div class="branch-grid">
                    @foreach ($branchVisits as $branch)
                        <div class="branch-item">
                            <div>
                                <h4>
                                    {{ $branch->name }}
                                </h4>
                                <p>
                                    {{ $branch->address }}
                                </p>
                            </div>
                            <strong>
                                {{ $branch->total_visits }}
                                <small>คน</small>
                            </strong>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="visit-panel">


            <div class="visit-header">

                <div>
                    <h3>
                        <i class="fas fa-notes-medical"></i>
                        รายการเข้าใช้บริการ
                    </h3>

                    <p>
                        วันที่
                        {{ \Carbon\Carbon::parse($searchDate)->locale('th')->translatedFormat('d F Y') }}
                    </p>

                </div>


                <a href="{{ route('visitsList') }}" class="view-btn">
                    ดูทั้งหมด
                </a>

            </div>

            <div class="visit-table">
                <table>
                    <thead>
                        <tr>
                            <th>HN</th>
                            <th>ผู้ป่วย</th>
                            <th>แพทย์</th>
                            <th>สาขา</th>
                            <th>เวลา</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestVisits as $visit)
                            <tr>
                                <td>
                                    {{ $visit->patient?->hn ?? '-' }} </td>

                                <td>
                                    <div class="patient-info">
                                        <div class="avatar">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <span>
                                            {{ $visit->patient->firstname }}
                                            {{ $visit->patient->lastname }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    {{ $visit->medic?->firstname }}
                                    {{ $visit->medic?->lastname }}
                                </td>
                                <td>
                                    {{ $visit->branch?->name ?? '-' }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($visit->visit_date)->format('H:i') }}
                                </td>

                                <td>
                                    <span class="status success">
                                        เข้ารับบริการ
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty">
                                    ไม่มีข้อมูลเข้าใช้บริการ
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
