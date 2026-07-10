@extends('core::components.layouts.master')
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<link rel="stylesheet" href="{{ asset('css/pt33.css') }}">
<script src="{{ asset('js/pt33.js') }}"></script>

@section('content')
    <div class="a4">

        <div class="header">

            <div class="form-no">
                แบบ ภ.ท.๓๓
            </div>

            <div class="title">
                <h2>แก้ไขใบสั่งจ่ายสมุนไพรควบคุม (กัญชา)</h2>
            </div>
        </div>

        <form action="{{ route('documents.update', $document->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- แพทย์ --}}
            <div class="row">
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


                <label>
                    <input type="checkbox" name="profession[]" value="เวชกรรม"
                        {{ in_array('เวชกรรม', $professions) ? 'checked' : '' }}>
                    เวชกรรม
                </label>


                <label>
                    <input type="checkbox" name="profession[]" value="แพทย์แผนไทย"
                        {{ in_array('แพทย์แผนไทย', $professions) ? 'checked' : '' }}>
                    แพทย์แผนไทย
                </label>


                <label>
                    <input type="checkbox" name="profession[]" value="แพทย์แผนไทยประยุกต์"
                        {{ in_array('แพทย์แผนไทยประยุกต์', $professions) ? 'checked' : '' }}>
                    แพทย์แผนไทยประยุกต์
                </label>


                <label>
                    <input type="checkbox" name="profession[]" value="ทันตกรรม"
                        {{ in_array('ทันตกรรม', $professions) ? 'checked' : '' }}>
                    ทันตกรรม
                </label>


                <label>
                    <input type="checkbox" name="profession[]" value="เภสัชกรรม"
                        {{ in_array('เภสัชกรรม', $professions) ? 'checked' : '' }}>
                    เภสัชกรรม
                </label>


                <label>
                    <input type="checkbox" name="profession[]" value="แพทย์แผนจีน"
                        {{ in_array('แพทย์แผนจีน', $professions) ? 'checked' : '' }}>
                    แพทย์แผนจีน
                </label>

                <label>
                    <input type="checkbox" name="profession[]" value="หมอพื้นบ้าน"
                        {{ in_array('หมอพื้นบ้าน', $professions) ? 'checked' : '' }}>
                    หมอพื้นบ้าน
                </label>

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
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script>
        const gramInput = document.getElementById('gram');
        const daysInput = document.getElementById('days');
        const totalInput = document.getElementById('total');

        function calculateTotal() {

            const gram = parseFloat(gramInput.value) || 0;
            const days = parseInt(daysInput.value) || 0;

            totalInput.value = (gram * days).toFixed(2);
        }

        gramInput.addEventListener('input', calculateTotal);
        daysInput.addEventListener('input', calculateTotal);

        // คำนวณเมื่อโหลดหน้า (กรณี old())
        calculateTotal();
        document.addEventListener("DOMContentLoaded", function() {

            new TomSelect("#patientSelect", {
                create: false,
                placeholder: "ค้นหา HN / ชื่อ / เลขบัตรประชาชน",
                maxOptions: 20,
                searchField: ["text"],
            });

            const patientSelect = document.getElementById('patientSelect');

            patientSelect.addEventListener('change', function() {

                const option = this.options[this.selectedIndex];

                if (!option.value) {
                    document.getElementById('patient_id').value = '';
                    document.getElementById('patient_name').value = '';
                    document.getElementById('age').value = '';
                    document.getElementById('nationality').value = '';
                    document.getElementById('idcard').value = '';
                    return;
                }

                document.getElementById('patient_id').value = option.value;
                document.getElementById('patient_name').value = option.dataset.name;
                document.getElementById('age').value = option.dataset.age;
                document.getElementById('nationality').value = option.dataset.nationality;
                document.getElementById('idcard').value = option.dataset.cid;

            });

        });
    </script>
@endsection
