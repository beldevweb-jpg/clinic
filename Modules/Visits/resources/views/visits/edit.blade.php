@extends('core::components.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/visits.css') }}">
@endpush

@section('content')
    <div class="visit-wrapper">

        <div class="visit-card">

            <div class="visit-header">
                <h3>แก้ไขข้อมูลการเข้ารับบริการ</h3>
            </div>

            <form action="{{ route('visits.update', $visit->id) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>ผู้ป่วย</label>

                    <select name="patient_id" class="form-control">

                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}" @selected($visit->patient_id == $patient->id)>

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
                            <option value="{{ $medic->id }}" @selected($visit->medic_id == $medic->id)>

                                {{ $medic->name }}

                            </option>
                        @endforeach

                    </select>
                </div>


                <div class="form-group">
                    <label>วันที่เข้ารับบริการ</label>

                    <input type="date" name="visit_date" class="form-control"
                        value="{{ \Carbon\Carbon::parse($visit->visit_date)->format('Y-m-d') }}">
                </div>


                <div class="form-group">
                    <label>หมายเหตุ</label>

                    <textarea name="note" rows="4" class="form-control">{{ old('note', $visit->note) }}</textarea>
                </div>


                <div class="form-footer">

                    <a href="{{ route('visits.index') }}" class="btn btn-secondary">
                        ย้อนกลับ
                    </a>

                    <button type="submit" class="btn-save">
                        <i class="fa fa-save"></i>
                        บันทึกการแก้ไข
                    </button>

                </div>

            </form>

        </div>

    </div>
@endsection
