@extends('core::components.layouts.master')

<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/pt33.css') }}">
<link rel="stylesheet" href="{{ asset('css/error.css') }}">


@section('content')
    <div class="form-container">
        @if (session('success'))
            <div class="notify notify-success">
                <div class="notify-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

                <div class="notify-content">
                    <h6>ดำเนินการสำเร็จ</h6>
                    <p>{{ session('success') }}</p>
                </div>

                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <form action="{{ route('pt33.store') }}" method="POST" id="pt33Form">

            @csrf
            {{-- ================= ข้อมูลแพทย์ ================= --}}

            <div class="form-card">

                <h3>👨‍⚕️ ข้อมูลผู้สั่งจ่าย</h3>

                <div class="form-grid">

                    <div class="form-group">

                        <label>
                            แพทย์ผู้สั่งจ่าย
                        </label>


                        <select id="medicSelect" class="form-control">

                            <option value="">
                                -- เลือกแพทย์ --
                            </option>


                            @foreach ($medics as $medic)
                                <option value="{{ $medic->id }}" data-license="{{ $medic->license }}"
                                    data-professions='@json($medic->professions->pluck('profession.name'))'>

                                    {{ $medic->prefix }}
                                    {{ $medic->firstname }}
                                    {{ $medic->lastname }}

                                </option>
                            @endforeach


                        </select>

                    </div>



                    <div class="form-group">

                        <label>
                            ใบอนุญาตเลขที่
                        </label>


                        <input id="doctorLicense" class="form-control" readonly>

                    </div>

                </div>


                <input type="hidden" name="medic_id" id="medic_id">


                <div class="checkbox-group">

                    @foreach (['เวชกรรม', 'แพทย์แผนไทย', 'แพทย์แผนไทยประยุกต์', 'ทันตกรรม', 'เภสัชกรรม', 'แพทย์แผนจีน', 'หมอพื้นบ้าน'] as $item)
                        <label>

                            <input type="checkbox" name="profession[]" value="{{ $item }}" disabled>

                            {{ $item }}

                        </label>
                    @endforeach

                </div>


            </div>




            {{-- ================= ข้อมูลผู้ป่วย ================= --}}

            <div class="form-card">

                <h3>👤 ข้อมูลผู้ป่วย</h3>


                <div class="form-group">

                    <label>
                        ค้นหาผู้ป่วย
                    </label>


                    <select id="patientSelect" class="form-control">

                        <option value="">
                            -- เลือกผู้ป่วย --
                        </option>


                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}"
                                data-name="{{ $patient->prefix }}{{ $patient->firstname }} {{ $patient->lastname }}"
                                data-age="{{ \Carbon\Carbon::parse($patient->birthday)->age }}"
                                data-nationality="{{ $patient->nationality }}" data-cid="{{ $patient->cid }}">


                                {{ $patient->hn }} -
                                {{ $patient->prefix }}
                                {{ $patient->firstname }}
                                {{ $patient->lastname }}


                            </option>
                        @endforeach


                    </select>


                </div>


                <input type="hidden" name="patient_id" id="patient_id">


                <div class="form-grid">


                    <div class="form-group">

                        <label>
                            ชื่อผู้ป่วย
                        </label>

                        <input id="patient_name" class="form-control" readonly>

                    </div>



                    <div class="form-group">

                        <label>
                            อายุ
                        </label>

                        <input id="age" class="form-control" readonly>

                    </div>


                </div>



                <div class="form-grid">


                    <div class="form-group">

                        <label>
                            สัญชาติ
                        </label>

                        <input id="nationality" class="form-control" readonly>

                    </div>



                    <div class="form-group">

                        <label>
                            เลขบัตรประชาชน / Passport
                        </label>

                        <input id="idcard" class="form-control" readonly>

                    </div>


                </div>


            </div>





            {{-- ================= ข้อมูลการรักษา ================= --}}

            <div class="form-card">

                <h3>🩺 ข้อมูลการรักษา</h3>


                <div class="form-group">

                    <label>
                        พบว่ามีโรคหรืออาการ
                    </label>


                    <textarea id="diagnosis" name="diagnosis" class="form-control" rows="5">{{ old('diagnosis') }}</textarea>


                </div>


            </div>





            {{-- ================= ปริมาณยา ================= --}}

            <div class="form-card">

                <h3>🌿 ขนาดการใช้ช่อดอกกัญชา</h3>


                <div class="form-grid">


                    <div class="form-group">

                        <label>จำนวนต่อวัน (กรัม)</label>

                        <input id="gram" name="gram" type="number" class="form-control">

                    </div>



                    <div class="form-group">

                        <label>จำนวนวันที่ใช้</label>

                        <input id="days" name="days" type="number" class="form-control">

                    </div>



                    <div class="form-group">

                        <label>รวมปริมาณทั้งหมด</label>

                        <input id="total" name="total" class="form-control" readonly>

                    </div>


                </div>


            </div>





            <div class="form-footer">

                <button class="btn-save">

                    💾 บันทึกข้อมูล

                </button>


                <a href="{{ route('pt33.create') }}" class="btn-cancel">

                    ยกเลิก

                </a>


            </div>



        </form>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script src="{{ asset('js/pt33.js') }}"></script>
@endsection
