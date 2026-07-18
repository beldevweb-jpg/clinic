@extends('core::components.layouts.master')


@push('styles')
    <link rel="stylesheet" href="{{ asset('css/patient-show.css') }}">
@endpush
@section('content')
    <div class="container-fluid patient-wrapper">
        <div class="patient-header">
            <h3>
                ข้อมูลผู้ป่วย
            </h3>
            <a href="{{ route('patient.index') }}" class="btn-back">
                กลับ
            </a>
        </div>

        {{-- ข้อมูลส่วนตัว --}}
        <div class="patient-card">
            <div class="patient-title">
                ข้อมูลส่วนตัว
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="info-group">
                        <div class="info-label">
                            HN
                        </div>
                        <div class="info-value">
                            {{ $patient->hn }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-group">
                        <div class="info-label">
                            เลขบัตรประชาชน
                        </div>

                        <div class="info-value">
                            {{ $patient->cid }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-group">
                        <div class="info-label">
                            สัญชาติ
                        </div>
                        <div class="info-value">
                            {{ $patient->nationality ?? '-' }}
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="info-group">
                        <div class="info-label">
                            ชื่อ-นามสกุล
                        </div>
                        <div class="info-value">
                            {{ $patient->prefix }}
                            {{ $patient->firstname }}
                            {{ $patient->lastname }}
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="info-group">
                        <div class="info-label">
                            วันเกิด
                        </div>
                        <div class="info-value">
                            {{ $patient->birthday ? \Carbon\Carbon::parse($patient->birthday)->format('d/m/Y') : '-' }}
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="info-group">
                        <div class="info-label">
                            อายุ
                        </div>
                        <div class="info-value">
                            {{ $patient->age ?? '-' }} ปี
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-group">
                        <div class="info-label">
                            เพศ
                        </div>
                        <div class="info-value">
                            {{ $patient->gender ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- ติดต่อ --}}
        <div class="patient-card">
            <div class="patient-title">
                ที่อยู่ / ติดต่อ
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="info-group">
                        <div class="info-label">
                            ที่อยู่ตามบัตรประชาชน
                        </div>
                        <div class="info-value">
                            {{ $patient->card_address ?? '-' }}
                            <br>
                            ตำบล {{ $patient->subdistrict ?? '-' }}
                            อำเภอ {{ $patient->district ?? '-' }}
                            จังหวัด {{ $patient->province ?? '-' }}
                            {{ $patient->zipcode ?? '' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-group">
                        <div class="info-label">
                            เบอร์โทรศัพท์
                        </div>
                        <div class="info-value">

                            {{ $patient->phone ?? '-' }}
                        </div>
                    </div>
                </div>

            </div>

        </div>

        {{-- ข้อมูลสุขภาพ --}}
        <div class="patient-card">
            <div class="patient-title">
                ข้อมูลสุขภาพ
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="info-group">
                        <div class="info-label">
                            ความดันโลหิต
                        </div>
                        <div class="info-vaue">
                            {{ $patient->blood_pressure ?? '-' }}
                        </div>

                    </div>
                </div>


                <div class="col-md-3">
                    <div class="info-group">
                        <div class="info-label">
                            ชีพจร
                        </div>
                        <div class="info-value">
                            {{ $patient->pulse_rate ?? '-' }} ครั้ง/นาที
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="info-group">
                        <div class="info-label">
                            อัตราการหายใจ
                        </div>
                        <div class="info-value">
                            {{ $patient->respiratory_rate ?? '-' }} ครั้ง/นาที
                        </div>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="info-group">
                        <div class="info-label">
                            อุณหภูมิ
                        </div>
                        <div class="info-value">
                            {{ $patient->temperature ?? '-' }} °C
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-group">
                        <div class="info-label">
                            ส่วนสูง
                        </div>
                        <div class="info-value">
                            {{ $patient->height ?? '-' }} cm
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-group">
                        <div class="info-label">
                            น้ำหนัก
                        </div>
                        <div class="info-value">
                            {{ $patient->weight ?? '-' }} kg
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ข้อมูลการรักษา --}}
        <div class="patient-card">
            <div class="patient-title">
                ข้อมูลการรักษา
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="info-group">
                        <div class="info-label">
                            อาการสำคัญ (Chief Complaint)
                        </div>

                        <div class="text-box">
                            {{ $patient->chief_complaint ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-12">

                    <div class="info-group">
                        <div class="info-label">
                            ตรวจร่างกาย
                        </div>
                        <div class="text-box">
                            {{ $patient->physical_exam ?? '-' }}
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="info-group">
                        <div class="info-label">
                            การวินิจฉัย
                        </div>
                        <div class="text-box">
                            {{ $patient->diagnosis ?? '-' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="info-group">
                        <div class="info-label">
                            การรักษา
                        </div>
                        <div class="text-box">
                            {{ $patient->treatment ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Visit --}}
        <div class="patient-card">

            <div class="patient-title">
                ประวัติการเข้ารับบริการ
            </div>


            <div class="patient-table">
                <table>
                    <thead>
                        <tr>
                            <th>
                                วันที่
                            </th>
                            <th>
                                แพทย์
                            </th>
                            <th>
                                อาการ
                            </th>
                            <th>
                                การรักษา
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patient->visits as $visit)
                            <tr>
                                <td>
                                    {{ \Carbon\Carbon::parse($visit->visit_date)->format('d/m/Y') }}
                                </td>
                                <td>
                                    {{ $visit->medic->name ?? '-' }}
                                </td>
                                <td>
                                    {{ $visit->note ?? '-' }}
                                </td>
                                <td>
                                    {{ $visit->treatment ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    ยังไม่มีประวัติการรักษา
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
