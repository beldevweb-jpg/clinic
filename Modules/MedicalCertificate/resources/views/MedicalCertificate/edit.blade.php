@extends('core::components.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/medical-certificate.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush


@section('content')
    <div class="container-fluid">
        <form action="{{ route('medical-certificate.update', $medicalCertificate->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-file-medical me-2"></i>
                        แก้ไขใบรับรองแพทย์
                    </h4>
                </div>

                <div class="card-body">
                    {{-- ข้อมูลผู้ป่วย --}}
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-user me-2"></i>
                                ข้อมูลผู้ป่วย
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        ผู้ป่วย
                                    </label>
                                    <select class="form-select" id="patient_id" name="patient_id" required>
                                        <option value="">
                                            -- เลือกผู้ป่วย --
                                        </option>

                                        @foreach ($patients as $patient)
                                            <option value="{{ $patient->id }}" data-hn="{{ $patient->hn }}"
                                                data-cid="{{ $patient->cid }}" data-firstname="{{ $patient->firstname }}"
                                                data-lastname="{{ $patient->lastname }}"
                                                data-gender="{{ $patient->gender }}"
                                                data-birthday="{{ $patient->birthday }}"
                                                data-address="{{ $patient->address }}" @selected($medicalCertificate->patient_id == $patient->id)>
                                                {{ $patient->hn }}
                                                -
                                                {{ $patient->firstname }}
                                                {{ $patient->lastname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">
                                        HN
                                    </label>
                                    <input id="hn" class="form-control"
                                        value="{{ $medicalCertificate->patient->hn ?? '' }}" readonly>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">
                                        เลขบัตรประชาชน
                                    </label>

                                    <input id="cid" class="form-control"
                                        value="{{ $medicalCertificate->patient->cid ?? '' }}" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        ชื่อ-นามสกุล
                                    </label>
                                    <input id="fullname" class="form-control"
                                        value="{{ ($medicalCertificate->patient->firstname ?? '') . ' ' . ($medicalCertificate->patient->lastname ?? '') }}"
                                        readonly>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">
                                        เพศ
                                    </label>
                                    <input id="gender" class="form-control"
                                        value="{{ $medicalCertificate->patient->gender ?? '' }}" readonly>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">
                                        อายุ
                                    </label>
                                    <input id="age" class="form-control" readonly>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">
                                        ที่อยู่
                                    </label>
                                    <textarea id="address" class="form-control" rows="2" readonly>{{ $medicalCertificate->patient->card_address ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ข้อมูลใบรับรองแพทย์ --}}
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="fas fa-notes-medical me-2"></i>
                                ข้อมูลใบรับรองแพทย์
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        แพทย์ผู้ตรวจ
                                    </label>

                                    <select name="medic_id" class="form-select" required>
                                        <option value="">
                                            -- เลือกแพทย์ --
                                        </option>

                                        @foreach ($medics as $medic)
                                            <option value="{{ $medic->id }}" @selected($medicalCertificate->medic_id == $medic->id)>
                                                {{ $medic->firstname }}
                                                {{ $medic->lastname }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">
                                        วันที่ตรวจ
                                    </label>
                                    <input type="date" name="exam_date" class="form-control"
                                        value="{{ old('exam_date', date('Y-m-d', strtotime($medicalCertificate->certificate_date))) }}">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">
                                        พักรักษาตัว (วัน)
                                    </label>

                                    <input type="number" name="rest_days" min="0" class="form-control"
                                        value="{{ old('rest_days', $medicalCertificate->rest_days) }}">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">
                                        การวินิจฉัยโรค
                                    </label>
                                    <textarea name="diagnosis" class="form-control" rows="3">{{ old('diagnosis', $medicalCertificate->symptom) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        บันทึกการแก้ไข
                    </button>
                </div>
            </div>
        </form>
    </div>
    <script>
        document.getElementById('patient_id')
            .addEventListener('change', function() {


                const option = this.options[this.selectedIndex];


                document.getElementById('hn').value =
                    option.dataset.hn || '';



                document.getElementById('cid').value =
                    option.dataset.cid || '';



                document.getElementById('fullname').value =
                    (option.dataset.firstname || '') +
                    ' ' +
                    (option.dataset.lastname || '');



                document.getElementById('gender').value =
                    option.dataset.gender || '';



                document.getElementById('address').value =
                    option.dataset.address || '';



                if (option.dataset.birthday) {


                    let birth = new Date(option.dataset.birthday);

                    let today = new Date();


                    let age =
                        today.getFullYear() -
                        birth.getFullYear();



                    if (
                        today.getMonth() < birth.getMonth() ||
                        (
                            today.getMonth() == birth.getMonth() &&
                            today.getDate() < birth.getDate()
                        )

                    ) {

                        age--;

                    }



                    document.getElementById('age').value =
                        age + ' ปี';



                }



            });





        // โหลดอายุทันทีตอนเปิดหน้า edit

        window.onload = function() {

            let birth = "{{ $medicalCertificate->patient->birthday ?? '' }}";


            if (birth) {


                let b = new Date(birth);

                let t = new Date();


                let age = t.getFullYear() - b.getFullYear();


                if (
                    t.getMonth() < b.getMonth() ||
                    (
                        t.getMonth() == b.getMonth() &&
                        t.getDate() < b.getDate()
                    )
                )

                {

                    age--;

                }


                document.getElementById('age').value =
                    age + ' ปี';


            }


        }
    </script>
@endsection
