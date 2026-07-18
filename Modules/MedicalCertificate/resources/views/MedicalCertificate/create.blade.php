    @extends('core::components.layouts.master')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/medical-certificate.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    @endpush
    @section('content')
        <div class="container-fluid">
            <form action="{{ route('medical-certificate.store') }}" method="POST">
                @csrf

                <div class="card shadow-sm border-0">

                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-file-medical me-2"></i>
                            ออกใบรับรองแพทย์
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
                                            ผู้ป่วย <span class="text-danger">*</span>
                                        </label>


                                        <select class="form-select @error('patient_id') is-invalid @enderror"
                                            id="patient_id" name="patient_id" required>

                                            <option value="">
                                                -- เลือกผู้ป่วย --
                                            </option>


                                            @foreach ($patients as $patient)
                                                <option value="{{ $patient->id }}" data-hn="{{ $patient->hn }}"
                                                    data-cid="{{ $patient->cid }}"
                                                    data-firstname="{{ $patient->firstname }}"
                                                    data-lastname="{{ $patient->lastname }}"
                                                    data-gender="{{ $patient->gender }}"
                                                    data-birthday="{{ $patient->birthday }}"
                                                    data-card_address="{{ $patient->card_address }}" @selected(old('patient_id') == $patient->id)>

                                                    {{ $patient->hn }}
                                                    -
                                                    {{ $patient->firstname }}
                                                    {{ $patient->lastname }}

                                                </option>
                                            @endforeach

                                        </select>


                                        @error('patient_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror


                                    </div>



                                    <div class="col-md-2">

                                        <label class="form-label">
                                            HN
                                        </label>

                                        <input id="hn" name="hn" class="form-control" readonly>

                                    </div>



                                    <div class="col-md-4">

                                        <label class="form-label">
                                            เลขบัตรประชาชน
                                        </label>

                                        <input id="cid" name="cid" class="form-control" readonly>

                                    </div>



                                    <div class="col-md-6">

                                        <label class="form-label">
                                            ชื่อ-นามสกุล
                                        </label>

                                        <input id="fullname" class="form-control" readonly>

                                    </div>



                                    <div class="col-md-3">

                                        <label class="form-label">
                                            เพศ
                                        </label>

                                        <input id="gender" class="form-control" readonly>

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

                                        <textarea id="card_address" class="form-control" rows="2" readonly></textarea>

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


                                        <select class="form-select" name="medic_id" required>

                                            <option value="">
                                                -- เลือกแพทย์ --
                                            </option>


                                            @foreach ($medics as $medic)
                                                <option value="{{ $medic->id }}">

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
                                            value="{{ old('exam_date', date('Y-m-d')) }}">

                                    </div>




                                    <div class="col-md-3">

                                        <label class="form-label">
                                            พักรักษาตัว (วัน)
                                        </label>


                                        <input type="number" name="rest_days" min="0" class="form-control"
                                            value="{{ old('rest_days', 0) }}">

                                    </div>




                                    <div class="col-12">

                                        <label class="form-label">
                                            การวินิจฉัยโรค
                                        </label>


                                        <textarea name="diagnosis" class="form-control" rows="3" placeholder="ระบุผลการวินิจฉัย...">{{ old('diagnosis') }}</textarea>


                                    </div>


                                </div>


                            </div>

                        </div>


                    </div>



                    <div class="card-footer text-end">

                        <a href="{{ route('medical-certificate.create') }}" class="btn btn-secondary">

                            <i class="fas fa-times me-1"></i>
                            ยกเลิก

                        </a>


                        <button type="submit" class="btn btn-primary">

                            <i class="fas fa-save me-1"></i>
                            บันทึกข้อมูล

                        </button>


                    </div>


                </div>


            </form>
        </div>
        <script>
            document.getElementById('patient_id').addEventListener('change', function() {

                const option = this.options[this.selectedIndex];

                document.getElementById('hn').value = option.dataset.hn || '';
                document.getElementById('cid').value = option.dataset.cid || '';

                document.getElementById('fullname').value =
                    (option.dataset.firstname || '') + ' ' +
                    (option.dataset.lastname || '');

                document.getElementById('gender').value =
                    option.dataset.gender == 'ชาย' ?
                    'ชาย' :
                    option.dataset.gender == 'หญิง' ?
                    'หญิง' :
                    '';

                document.getElementById('card_address').value =
                    option.dataset.card_address || '';

                if (option.dataset.birthday) {

                    const birth = new Date(option.dataset.birthday);
                    const today = new Date();

                    let age = today.getFullYear() - birth.getFullYear();

                    if (
                        today.getMonth() < birth.getMonth() ||
                        (
                            today.getMonth() == birth.getMonth() &&
                            today.getDate() < birth.getDate()
                        )
                    ) {
                        age--;
                    }

                    document.getElementById('age').value = age + ' ปี';
                } else {
                    document.getElementById('age').value = '';
                }

            });
        </script>
    @endsection
