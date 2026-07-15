@extends('core::components.layouts.master')
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/error.css') }}">

<link rel="stylesheet" href="{{ asset('css/pt33_edit.css') }}">
@section('content')
    <div class="a4 pt33-form">

        <div class="paper">
            {{-- แจ้งเตือน --}}
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
            <div class="header">

                <div class="form-no">
                    แบบ ภ.ท.๓๓
                </div>

                <h2>
                    แก้ไขใบสั่งจ่ายสมุนไพรควบคุม (กัญชา)
                </h2>

                <div class="divider"></div>

            </div>

            <form action="{{ route('documents.update', $document->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- แพทย์ --}}
                <div class="row">

                    <label>ข้าพเจ้า</label>

                    <select id="medicSelect" name="medic_id" style="width:350px">
                        <option value="">-- เลือกแพทย์ --</option>

                        @foreach ($medics as $medic)
                            <option value="{{ $medic->id }}" data-license="{{ $medic->license }}"
                                data-professions='@json($medic->professions->pluck('profession.name'))'
                                {{ old('medic_id', $pt33->visit->medic_id ?? '') == $medic->id ? 'selected' : '' }}>
                                {{ $medic->prefix }}{{ $medic->firstname }} {{ $medic->lastname }}
                            </option>
                        @endforeach

                    </select>
                </div>

                @php
                    $professions = $pt33->visit->medic->professions->pluck('profession.name')->toArray();
                @endphp

                <div class="row">

                    <label>
                        ผู้ประกอบวิชาชีพ
                    </label>

                    <div id="profession-list">

                        <label>
                            <input type="checkbox" name="profession[]" value="เวชกรรม" disabled>
                            เวชกรรม
                        </label>

                        <label>
                            <input type="checkbox" name="profession[]" value="แพทย์แผนไทย" disabled>
                            แพทย์แผนไทย
                        </label>

                        <label>
                            <input type="checkbox" name="profession[]" value="แพทย์แผนไทยประยุกต์" disabled>
                            แพทย์แผนไทยประยุกต์
                        </label>

                        <label>
                            <input type="checkbox" name="profession[]" value="ทันตกรรม" disabled>
                            ทันตกรรม
                        </label>

                        <label>
                            <input type="checkbox" name="profession[]" value="เภสัชกรรม" disabled>
                            เภสัชกรรม
                        </label>

                        <label>
                            <input type="checkbox" name="profession[]" value="แพทย์แผนจีน" disabled>
                            แพทย์แผนจีน
                        </label>

                        <label>
                            <input type="checkbox" name="profession[]" value="หมอพื้นบ้าน" disabled>
                            หมอพื้นบ้าน
                        </label>

                    </div>

                </div>

                {{-- ที่อยู่ --}}
                <div class="row address-row">
                    <label>
                        ที่อยู่
                    </label>
                    <div class="fill-line-address">
                        {{ $setting->address }}
                    </div>
                </div>

                {{-- ผู้ป่วย --}}
                <div class="row">
                    <label>
                        ผู้ป่วย
                    </label>
                    <input type="text" class="line-input flex-4" readonly
                        value="{{ $pt33->patient->hn }}-{{ $pt33->patient->prefix }}\
                    {{ $pt33->patient->firstname }}
                     {{ $pt33->patient->lastname }}">
                </div>

                <div class="row">
                    <label>
                        ได้ตรวจรักษา
                    </label>

                    <input type="text" class="line-input flex-4" readonly
                        value="{{ $pt33->patient->prefix }}{{ $pt33->patient->firstname }}{{ $pt33->patient->lastname }}">
                    <label>
                        อายุ
                    </label>

                    <input type="text" class="line-input flex-1" readonly
                        value="{{ \Carbon\Carbon::parse($pt33->patient->birthday)->age }}">
                    <span>
                        ปี
                    </span>
                </div>

                <div class="row">
                    <label>
                        สัญชาติ
                    </label>
                    <input type="text" class="line-input flex-2" readonly value="{{ $pt33->patient->nationality }}">
                    <label>
                        เลขบัตรประชาชน
                    </label>
                    <input type="text" class="line-input flex-4" readonly value="{{ $pt33->patient->cid }}">
                </div>
                {{-- diagnosis --}}
                <div class="card-section">
                    <label>
                        พบว่ามีโรคหรืออาการ
                    </label>
                    <textarea name="diagnosis" class="line-textarea" rows="6">{{ old('diagnosis', $pt33->diagnosis) }}</textarea>
                </div>
                <br>
                <div class="row">
                    <label>
                        จำนวน
                    </label>

                    <input type="number" name="cannabis_dosage" class="line-input flex-1" step="0.01"
                        value="{{ old('cannabis_dosage', $pt33->cannabis_dosage) }}">
                    <span>
                        กรัม
                    </span>
                    <label>
                        จำนวนวันที่ใช้
                    </label>
                    <input type="number" name="cannabis_use_days" class="line-input flex-1"
                        value="{{ old('cannabis_use_days', $pt33->cannabis_use_days) }}">
                    <span>วัน</span>
                </div>
                <div class="action">
                    <button type="submit" class="btn-save">
                        💾 บันทึกแก้ไข
                    </button>
                    </a>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {


            /* ==========================
               Select2 แพทย์
            ========================== */

            if ($('#medicSelect').length) {

                $('#medicSelect').select2({

                    placeholder: '-- เลือกแพทย์ --',

                    allowClear: true,

                    width: '350px',

                    language: {

                        noResults: function() {
                            return "ไม่พบข้อมูล";
                        }

                    }

                });


                $('#medicSelect').on('change', function() {

                    let option = this.options[this.selectedIndex];


                    if (!option.value) {
                        return;
                    }


                    let license = option.dataset.license;

                    let professions = option.dataset.professions;


                    console.log({
                        license,
                        professions
                    });


                });

            }



            /* ==========================
               Auto resize textarea
            ========================== */

            document.querySelectorAll('.line-textarea')
                .forEach(textarea => {


                    function resize() {

                        textarea.style.height = 'auto';

                        textarea.style.height =
                            textarea.scrollHeight + 'px';

                    }


                    textarea.addEventListener(
                        'input',
                        resize
                    );


                    resize();


                });



            /* ==========================
               Format จำนวนกรัม
            ========================== */

            const dosage =
                document.querySelector(
                    '[name="cannabis_dosage"]'
                );


            if (dosage) {


                dosage.addEventListener(
                    'input',
                    function() {


                        if (this.value < 0) {

                            this.value = 0;

                        }


                        if (this.value.includes('.')) {


                            let value =
                                parseFloat(this.value);


                            if (!isNaN(value)) {

                                this.value =
                                    value.toFixed(2);

                            }

                        }


                    }
                );

            }




            /* ==========================
               จำนวนวัน
            ========================== */

            const days =
                document.querySelector(
                    '[name="cannabis_use_days"]'
                );


            if (days) {


                days.addEventListener(
                    'input',
                    function() {


                        if (this.value < 0) {

                            this.value = 0;

                        }


                    }
                );

            }





            /* ==========================
               Checkbox profession
            ========================== */

            const checkboxes =
                document.querySelectorAll(
                    'input[name="profession[]"]'
                );


            checkboxes.forEach(check => {


                check.addEventListener(
                    'change',
                    function() {


                        let checked =
                            document.querySelectorAll(
                                'input[name="profession[]"]:checked'
                            );


                        if (checked.length === 0) {


                            console.log(
                                'ยังไม่ได้เลือกวิชาชีพ'
                            );


                        }


                    }
                );


            });





            /* ==========================
               ป้องกันกดบันทึกซ้ำ
            ========================== */

            const form =
                document.querySelector(
                    'form'
                );


            if (form) {


                form.addEventListener(
                    'submit',
                    function() {


                        const btn =
                            document.querySelector(
                                '.btn-save'
                            );


                        if (btn) {


                            btn.disabled = true;


                            btn.innerHTML =
                                '⏳ กำลังบันทึก...';


                        }


                    }
                );


            }



        });

        $('#medicSelect').on('change', function() {

            let option = this.options[this.selectedIndex];


            // ล้าง checkbox เดิม
            $('input[name="profession[]"]')
                .prop('checked', false);



            if (!option.value) {
                return;
            }


            let professions = option.dataset.professions;


            if (professions) {


                professions = JSON.parse(professions);



                professions.forEach(function(profession) {


                    $('input[name="profession[]"][value="' + profession + '"]')
                        .prop('checked', true);


                });


            }


        });
    </script>
@endsection
