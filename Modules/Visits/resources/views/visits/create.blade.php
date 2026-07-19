@extends('core::components.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/visits.css') }}">
@endpush

@section('content')
    <div class="visit-wrapper">

        <div class="visit-card">

            <div class="visit-header">
                <h3>เพิ่มข้อมูลการเข้ารับบริการ</h3>
            </div>

            <form action="{{ route('visits.store') }}" method="POST">

                @csrf

                <div class="form-group">
                    <label>ผู้ป่วย</label>

                    <select name="patient_id" class="form-control">
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}">
                                {{ $patient->hn }}
                                -
                                {{ $patient->firstname }}
                                {{ $patient->lastname }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label>แพทย์</label>

                    <select name="medic_id" class="form-control">
                        @foreach ($medics as $medic)
                            <option value="{{ $medic->id }}">
                                {{ $medic->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label>วันที่เข้ารับบริการ</label>

                    <input type="date" name="visit_date" class="form-control" value="{{ date('Y-m-d') }}">
                </div>


                <div class="form-group">
                    <label>หมายเหตุ</label>

                    <textarea name="note" rows="4" class="form-control"></textarea>
                </div>

                <div class="form-group">

                    <label>ประเภทการเข้ารับบริการ</label>

                    <select name="type" class="form-control">

                        <option value="manual">
                            ทั่วไป
                        </option>

                        <option value="pt33">
                            PT33
                        </option>

                        <option value="register">
                            ลงทะเบียนผู้ป่วยใหม่
                        </option>

                    </select>

                </div>


                <div class="form-footer">
                    <button class="btn-save">
                        <i class="fa fa-save"></i>
                        บันทึกข้อมูล
                    </button>
                </div>

            </form>

        </div>

    </div>
@endsection
