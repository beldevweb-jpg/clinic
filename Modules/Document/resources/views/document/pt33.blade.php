@extends('core::components.layouts.master')
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<link rel="stylesheet" href="{{ asset('css/pt33.css') }}">
<script src="{{ asset('js/pt33.js') }}"></script>

@section('content')
    @php
        function thaiNumber($number)
        {
            return strtr($number, [
                '0' => '๐',
                '1' => '๑',
                '2' => '๒',
                '3' => '๓',
                '4' => '๔',
                '5' => '๕',
                '6' => '๖',
                '7' => '๗',
                '8' => '๘',
                '9' => '๙',
            ]);
        }

        $day = thaiNumber(now()->format('j'));
        $month = now()->locale('th')->translatedFormat('F');
        $year = thaiNumber(now()->year + 543);
    @endphp

    <div class="a4">
        <div class="header">

            <div class="form-no">
                แบบ ภ.ท.๓๓
            </div>

            <div class="title">
                <h2>ใบสั่งจ่ายสมุนไพรควบคุม (กัญชา)</h2>
            </div>

            <div class="date-row">
                วันที่
                <span>{{ $day }}</span>
                {{ $month }}
                พ.ศ.
                <span>{{ $year }}</span>
            </div>

        </div>

        <form action="{{ route('pt33.store') }}" method="POST" id="pt33Form">
            @csrf
            <div class="row">
                <label>ข้าพเจ้า</label>

                <select id="medicSelect" style="width:350px">
                    <option value="">-- เลือกแพทย์ --</option>

                    @foreach ($medics as $medic)
                        <option value="{{ $medic->id }}" data-license="{{ $medic->license }}"
                            data-professions='@json($medic->professions->pluck('profession.name'))'>
                            {{ $medic->prefix }}{{ $medic->firstname }} {{ $medic->lastname }}
                        </option>
                    @endforeach
                </select>
            </div>

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

            <input type="hidden" name="medic_id" id="medic_id">

            <div class="row">
                <label>ใบอนุญาตเลขที่</label>

                <span class="fill-line" id="doctorLicense"></span>
            </div>

            <div class="row address-row">
                <label>ที่อยู่</label>
                <div class="fill-line-address">{{ $setting->address }}</div>
            </div>

            <div class="row">
                <label>ผู้ป่วย</label>

                <select id="patientSelect" style="width:350px">
                    <option value="">-- เลือกผู้ป่วย --</option>

                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}"
                            data-name="{{ $patient->prefix }}{{ $patient->firstname }} {{ $patient->lastname }}"
                            data-age="{{ \Carbon\Carbon::parse($patient->birthday)->age }}"
                            data-nationality="{{ $patient->nationality }}" data-cid="{{ $patient->cid }}">

                            {{ $patient->hn }} - {{ $patient->prefix }}{{ $patient->firstname }}
                            {{ $patient->lastname }}
                        </option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="patient_id" id="patient_id">

            <div class="row">
                <label>ได้ตรวจรักษา</label>
                <input type="text" id="patient_name" class="line-input flex-4" readonly>

                <label>อายุ</label>
                <input type="text" id="age" class="line-input flex-1" readonly>

                <span>ปี</span>
            </div>

            <div class="row">

                <label>สัญชาติ</label>

                <input type="text" id="nationality" class="line-input flex-2" readonly>

                <label>เลขบัตรประชาชน/หนังสือเดินทาง</label>

                <input type="text" id="idcard" class="line-input flex-4" readonly>

            </div>

            <div class="card-section">
                <div class="form-group">
                    <label for="diagnosis">
                        พบว่ามีโรคหรืออาการ
                    </label>

                    <textarea id="diagnosis" name="diagnosis" class="line-textarea" rows="6">{{ old('diagnosis') }}</textarea>

                    <small class="form-hint">
                        โปรดระบุการวินิจฉัยหรืออาการตามที่ตรวจพบ
                    </small>
                </div>
            </div>
            <br>

            <div class="row">
                <label>สมควรได้รับ ช่อดอกกัญชา ขนาดที่ใช้ต่อวัน</label>
            </div>

            <div class="row">
                <label>จำนวน</label>
                <input type="number" id="gram" name="gram" class="line-input flex-1" step="0.01" min="0.01"
                    value="{{ old('gram') }}">
                <span>กรัม</span>

                <label>จำนวนวันที่ใช้</label>
                <input type="number" id="days" name="days" class="line-input flex-1" min="1" max="30"
                    value="{{ old('days') }}">
                <span>วัน</span>

                <label>รวมปริมาณทั้งหมดที่ต้องใช้</label>
                <input type="number" id="total" name="total" class="line-input flex-1" step="0.01"
                    value="{{ old('total') }}" readonly>
                <span>กรัม</span>
            </div>
            <div class="note">
                <strong>หมายเหตุ</strong>

                <ol>
                    <li>๑. ให้ได้ไม่เกิน ๓๐ วันต่อ ๑ ครั้งการสั่งจ่าย</li>

                    <li>
                        ๒. การวินิจฉัยที่สอดคล้องหรือเป็นไปตามแนวทางการปฏิบัติ
                        และข้อบ่งชี้ในการใช้กัญชาทางการแพทย์ของวิชาชีพผู้สั่งจ่ายที่ได้รับอนุญาต
                    </li>

                    <li>
                        ๓. การวินิจฉัยที่ตรงกับเอกสารรับรองทางการแพทย์อื่นใด
                        ที่เห็นควรให้ผู้ซื้อสามารถใช้กัญชาทางการแพทย์ได้
                    </li>
                </ol>
            </div>

            <!-- SIGN -->
            <div class="sign">
                <div>ลงชื่อ __________________________ผู้สั่งจ่าย</div>
                <div>ลงชื่อ __________________________ผู้รับยา</div>
            </div>

            ______________________________________________________________________________

            <p class="center">
                แบบใบสั่งจ่ายนี้ให้ผู้ประกอบการเก็บไว้ ณ สถานที่จ่ายเพื่อตรวจสอบเป็นระยะเวลา ๑ ปีนับแต่วันที่จ่าย
            </p>
            <div class="action">
                <button type="submit" class="btn-save">
                    💾 บันทึกข้อมูล
                </button>

                <button type="button" class="btn-print" onclick="window.print()">
                    🖨️ พิมพ์เอกสาร
                </button>

                <a href="{{ route('pt33.index') }}" class="btn-cancel">
                    ยกเลิก
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
