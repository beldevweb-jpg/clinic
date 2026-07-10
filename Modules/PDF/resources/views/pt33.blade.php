@extends('pdf::components.layouts.master')

@section('content')
    <style>
        @page {
            size: A4;
            margin: 12mm 15mm 12mm 15mm;
        }

        @font-face {
            font-family: "TH Sarabun New";
            src: url("{{ resource_path('fonts/THSarabunNew.ttf') }}") format("truetype");
            font-weight: normal;
        }

        @font-face {
            font-family: "TH Sarabun New";
            src: url("{{ resource_path('fonts/THSarabunNew-Bold.ttf') }}") format("truetype");
            font-weight: bold;
        }


        body {
            margin: 0;
            padding: 0;
            background: #fff;
            font-family: "TH Sarabun New", sans-serif;
            font-size: 16pt;
            line-height: 1.1;
        }


        .pt33-paper {
            width: 170mm;
            min-height: 257mm;
            margin: auto;
            background: #fff;
            font-family: "TH Sarabun New", sans-serif;
            font-size: 16pt;
            line-height: 1.1;
        }


        /* เลขแบบฟอร์ม */
        .form-number {
            text-align: right;
            margin-bottom: 3mm;
        }


        /* หัวข้อ */
        h2 {
            margin: 0 0 3mm 0;
            text-align: center;
            font-size: 20pt;
            font-weight: bold;
        }


        /* วันที่ */
        .date {
            text-align: right;
            margin-bottom: 2mm;
        }


        /* ข้อมูล */
        .line {
            margin: 1mm 0;
        }

        .line span {
            display: inline-block;
            border-bottom: 1px dotted #000;
            min-width: 200px;
        }


        /* ช่องว่าง */
        .space {
            height: 2mm;
        }


        /* Checkbox */
        .checkbox {
            border: none !important;
            min-width: auto !important;
        }


        /* ข้อความปริมาณ */
        .text-line {
            font-size: 16pt;
            line-height: 1.1;
            margin-bottom: 1mm;
        }

        .indent {
            text-indent: 15mm;
        }


        /* เส้นกรอกข้อมูล */
        .underline {
            display: inline-block;
            min-width: 80px;
            border-bottom: 1px solid #000;
            text-align: center;
        }


        /* หมายเหตุ */
        .remark {
            margin-top: 3mm;
        }

        .remark b {
            display: block;
            margin-bottom: 2mm;
        }

        .remark-item {
            display: block;

            .remark-item {
                margin-left: 10mm;
                margin-bottom: 0.5mm;
                line-height: 1.1;
            }

            padding-left: 8mm;
            position: relative;
        }

        .remark-no {
            position: absolute;
            left: 0;
            width: 8mm;
        }


        /* ลายเซ็น */
        .signature {
            margin-top: 8mm;
            display: table;
            width: 100%;
            text-align: center;
        }

        .signature-box {
            display: table-cell;
            width: 50%;
            vertical-align: bottom;
            white-space: nowrap;
            font-size: 16pt;
        }

        .signature-image {
            width: 90px;
            height: 35px;
            object-fit: contain;
            display: block;
            margin: 0 auto 1mm;
        }

        /* เส้นก่อน Footer */
        .footer-line {
            width: 100%;
            border-top: 1px solid #000;
            margin-top: 8mm;
            margin-bottom: 3mm;
        }


        /* Footer */
        .footer {
            text-align: center;
            font-size: 16pt;
            line-height: 1.35;
        }

        .profession-row {
            margin: 2mm 0;
        }

        .profession-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16pt;
        }

        .profession-table td {
            padding: 0;
            vertical-align: middle;
            white-space: nowrap;
        }


        .profession-title {
            width: 38mm;
        }


        /* ช่องสี่เหลี่ยม */
        .box {
            display: inline-block;
            width: 11px;
            height: 11px;
            border: 1px solid #000;
            margin-right: 2mm;
            vertical-align: middle;
            text-align: center;
            line-height: 9px;
            font-size: 13px;
            font-weight: bold;
        }
    </style>
    @php
        use Carbon\Carbon;

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

        function thaiDate($date)
        {
            if (!$date) {
                return '';
            }

            $d = Carbon::parse($date);

            $months = [
                1 => 'มกราคม',
                2 => 'กุมภาพันธ์',
                3 => 'มีนาคม',
                4 => 'เมษายน',
                5 => 'พฤษภาคม',
                6 => 'มิถุนายน',
                7 => 'กรกฎาคม',
                8 => 'สิงหาคม',
                9 => 'กันยายน',
                10 => 'ตุลาคม',
                11 => 'พฤศจิกายน',
                12 => 'ธันวาคม',
            ];

            $day = thaiNumber($d->day);
            $month = $months[$d->month];
            $year = thaiNumber($d->year + 543);

            return "{$day} {$month} พ.ศ. {$year}";
        }
        $professions = $medic->professions->pluck('profession.name')->toArray();
        $age = floor(\Carbon\Carbon::parse($patient->birthday)->diffInYears(now()));

    @endphp
    <div class="pt33-paper">

        <div class="form-number">
            แบบ ภ.ท.๓๓
        </div>


        <h2>
            ใบสั่งจ่ายสมุนไพรควบคุม (กัญชา)
        </h2>


        <div class="date">
            วันที่ {{ thaiDate($pt33->issue_date) }}
        </div>


        <div class="line">
            ข้าพเจ้า
            <span>
                {{ $medic->prefix }}
                {{ $medic->firstname }}
                {{ $medic->lastname }}
            </span>
        </div>

        <div class="profession-row">

            <table class="profession-table">
                <tr>
                    <td class="profession-title">
                        ซึ่งเป็นผู้ประกอบวิชาชีพ
                    </td>

                    <td>
                        <span class="box">
                            {{ in_array('เวชกรรม', $professions) ? '×' : '' }}
                        </span>
                        เวชกรรม
                    </td>

                    <td>
                        <span class="box">
                            {{ in_array('แพทย์แผนไทย', $professions) ? '×' : '' }}
                        </span>
                        แพทย์แผนไทย
                    </td>

                    <td>
                        <span class="box">
                            {{ in_array('แพทย์แผนไทยประยุกต์', $professions) ? '×' : '' }}
                        </span>
                        แพทย์แผนไทยประยุกต์
                    </td>

                    <td>
                        <span class="box">
                            {{ in_array('ทันตกรรม', $professions) ? '×' : '' }}
                        </span>
                        ทันตกรรม
                    </td>
                </tr>

                <tr>
                    <td></td>

                    <td>
                        <span class="box">
                            {{ in_array('เภสัชกรรม', $professions) ? '×' : '' }}
                        </span>
                        เภสัชกรรม
                    </td>

                    <td colspan="2">
                        <span class="box">
                            {{ in_array('ผู้ประกอบโรคศิลปะ สาขาการแพทย์แผนจีน', $professions) ? '×' : '' }}
                        </span>
                        ผู้ประกอบโรคศิลปะ สาขาการแพทย์แผนจีน
                    </td>

                    <td>
                        <span class="box">
                            {{ in_array('หมอพื้นบ้าน', $professions) ? '×' : '' }}
                        </span>
                        หมอพื้นบ้าน
                    </td>
                </tr>

            </table>

        </div>

        <div class="line">
            ใบอนุญาต/หนังสือรับรอง เลขที่
            <span>
                {{ thaiNumber($setting->license ?? '-') }}/{{ thaiNumber($medic->license ?? '-') }}
            </span>
        </div>

        <span class="long-line">
            ที่อยู่
            {{ $setting->address }}
        </span>

        <div class="line">
            ได้ตรวจรักษา
            <span>
                {{ $patient->prefix }}
                {{ $patient->firstname }}
                {{ $patient->lastname }}
            </span>
            อายุ
            <span class="age-line">
                {{ thaiNumber(str_pad($age, 2, '0', STR_PAD_LEFT)) }}
            </span>
            ปี
        </div>



        <div class="line">

            สัญชาติ
            <span>
                {{ $patient->nationality }}
            </span>

            เลขที่ประชาชน/หนังสือเดินทาง
            <span>
                {{ thaiNumber($patient->cid) }}
            </span>

        </div>



        <div class="line">

            พบว่ามีโรคหรืออาการ

            <span>
                {{ $pt33->diagnosis }}
            </span>

        </div>



        <div class="space"></div>


        <div class="text-line indent">
            สมควรได้รับ ช่อดอกกัญชา ขนาดที่ใช้ต่อวัน
            จำนวน {{ thaiNumber($pt33->cannabis_dosage) }} กรัม
            จำนวนวันที่ใช้ {{ thaiNumber($pt33->cannabis_use_days) }} วัน
        </div>

        <div class="text-line">
            รวมปริมาณทั้งหมดที่ต้องใช้
            {{ thaiNumber(number_format($pt33->cannabis_dosage * $pt33->cannabis_use_days, 2)) }}
            กรัม
        </div>

        <div class="remark">
            <b>หมายเหตุ</b>

            <div class="remark-item">
                <span class="remark-no">๑</span>
                ให้ได้ไม่เกิน ๓๐ วันต่อ ๑ ครั้งการสั่งจ่าย
            </div>

            <div class="remark-item">
                <span class="remark-no">๒</span>
                การวินิจฉัยที่สอดคล้องหรือเป็นไปตามแนวทางการปฏิบัติ
                และข้อบ่งชี้ในการใช้กัญชาทางการแพทย์ของวิชาชีพผู้สั่งจ่ายที่ได้รับอนุญาต
            </div>

            <div class="remark-item">
                <span class="remark-no">๓</span>
                การวินิจฉัยที่ตรงกับเอกสารรับรองทางการแพทย์
            </div>
        </div>

        <div class="signature">

            <div class="signature-box">
                ลงชื่อ..................................ผู้รับใบสั่ง
            </div>

            <div class="signature-box">

                @if ($medic->signature)
                    <img src="{{ storage_path('app/public/' . $medic->signature) }}" class="signature-image">
                @endif

                ลงชื่อ..................................ผู้สั่งจ่าย

            </div>

        </div>


        <div class="footer-line"></div>

        <div class="footer">
            แบบใบสั่งจ่ายนี้ให้ผู้ประกอบการเก็บไว้ ณ สถานที่จ่าย
            เพื่อตรวจสอบเป็นระยะเวลา {{ thaiNumber(3) }} ปี
        </div>

    </div> {{-- ปิด pt33-paper --}}
@endsection
