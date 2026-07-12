@extends('core::components.layouts.master')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <div class="dashboard">
        <div class="panel">
            <form method="GET" action="{{ route('dashboards.index') }}" class="date-search">
                <div class="search-group">
                    <label>
                        <i class="fas fa-calendar"></i>
                        เลือกวันที่เข้าใช้บริการ
                    </label>
                    <input type="date" name="date" value="{{ $searchDate }}" class="date-input">
                </div>
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i>
                    ค้นหา
                </button>
            </form>
        </div>

        <div class="cards">


            <div class="dashboard-card patient">
                <div>
                    <h5>จำนวนผู้ป่วย</h5>
                    <h2>{{ $patients }}</h2>
                </div>
            </div>


            <div class="dashboard-card medic">
                <div>
                    <h5>จำนวนแพทย์</h5>
                    <h2>{{ $medics }}</h2>
                </div>
            </div>


            <div class="dashboard-card document">
                <div>
                    <h5>จำนวนเอกสาร</h5>
                    <h2>{{ $documents }}</h2>
                </div>
            </div>


            <div class="dashboard-card visit">
                <div>
                    <h5>
                        เข้าใช้บริการวันที่
                        {{ \Carbon\Carbon::parse($searchDate)->format('d/m/Y') }}
                    </h5>

                    <h2>{{ $visits }}</h2>
                </div>
            </div>
        </div>
    </div>
@endsection
