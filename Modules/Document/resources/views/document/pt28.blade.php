@extends('core::components.layouts.master')

<link rel="stylesheet" href="{{ asset('css/pt28.css') }}">
@section('content')
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

        function thaiMonth($date)
        {
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

            return $months[Carbon::parse($date)->month];
        }
    @endphp
    <div class="pt28">

        <div class="header-right">
            แบบ ภ.ท. ๒๘
        </div>

        <div class="title">
            แบบรายงานข้อมูลการนำไปใช้ สมุนไพรควบคุม (กัญชา)
        </div>

        <div class="sub-title">
            ประจำเดือน
            <span class="underline">{{ thaiMonth(now()) }}</span>
            พ.ศ.
            <span class="underline">{{ thaiNumber(now()->year + 543) }}</span>
        </div>

        <div class="note">
            (ผู้ได้รับอนุญาตต้องปฏิบัติตามข้อกำหนดแนบท้ายรายงานนี้)
        </div>

        <div class="receiver">
            เรียน

            <span class="box"></span>
            นายทะเบียนกลาง
            &nbsp;&nbsp;&nbsp;
            หมายถึง อธิบดีกรมการแพทย์แผนไทยและการแพทย์ทางเลือก

            <br>

            <span class="box"></span>
            นายทะเบียนจังหวัด
            &nbsp;&nbsp;&nbsp;
            หมายถึง นายแพทย์สาธารณสุขจังหวัด ......................................
        </div>

        <div class="license-info">
            ชื่อผู้รับอนุญาต .....................................................
            ชื่อร้าน .....................................................
            อำเภอ .....................................................
        </div>

        <div class="license-info">
            เลขที่ใบอนุญาต
            ...................................................................................................
        </div>

        <table class="report-table">
            <thead>

                <tr>
                    <th rowspan="3" width="4%">ลำดับ</th>

                    <th rowspan="3" width="8%">
                        วันเดือนปี
                    </th>

                    <th rowspan="3" width="12%">
                        เลขประจำตัวประชาชน/
                        <br>
                        เลขหนังสือเดินทาง
                        <br>
                        (ผู้ซื้อ)
                    </th>

                    <th rowspan="3" width="14%">
                        ชื่อผู้ซื้อ/
                        <br>
                        ผู้รับอนุญาต
                        <br>
                        (ผู้ซื้อ)
                    </th>

                    <th rowspan="3" width="8%">
                        วันเดือนปีเกิด
                        <br>
                        (ผู้ซื้อ)
                    </th>

                    <th colspan="6">
                        การนำไปใช้ ณ สถานประกอบการ
                    </th>

                    <th rowspan="3" width="12%">
                        เลขที่ใบอนุญาต
                        <br>
                        (ผู้ซื้อ)
                    </th>

                    <th rowspan="3" width="8%">
                        ปริมาณช่อดอก
                        <br>
                        กัญชาแห้ง
                        <br>
                        (กรัม)
                    </th>
                </tr>

                <tr>
                    <th colspan="6">
                        วัตถุประสงค์ของการนำไปใช้
                        <br>
                        (ทำเครื่องหมาย ✓ ในช่องที่ตรงตามวัตถุประสงค์)
                    </th>
                </tr>

                <tr>
                    <th class="vertical">ผู้ป่วย</th>
                    <th class="vertical">ขาย</th>
                    <th class="vertical">สำหรับผู้ป่วย</th>
                    <th class="vertical">สำหรับผู้ประกอบวิชาชีพ</th>
                    <th class="vertical">ให้ยืม</th>
                    <th class="vertical">ส่งออก</th>
                </tr>

            </thead>

            <tbody>
                @for ($i = 1; $i <= 13; $i++)
                    <tr>
                        <td>{{ $i }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>ประจำเดือน
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <div class="footer-note">

            <div class="footer-title">
                ข้อกำหนดแนบท้ายแบบ ภ.ท. ๒๘
            </div>

            <ol>
                <li>
                    แนบ ภ.ท. ๒๘ ประจำปี ใช้กับใบอนุญาตทุกประเภท รวมถึงหน่วยงานของรัฐ
                    ที่ทำการศึกษาวิจัยสมุนไพรควบคุม (กัญชา)
                </li>

                <li>
                    ให้กรอกข้อมูลและเลขประจำตัวประชาชนของผู้ซื้อ พร้อมแนบเอกสารกำกับทุกครั้ง
                </li>

                <li>
                    กรณีข้อมูลไม่เพียงพอ หรือมีข้อจำกัดของหน่วยงาน สามารถจัดทำเอกสารแนบเพิ่มเติมได้
                </li>

                <li>
                    ผู้รับอนุญาตต้องส่งรายงานนี้ภายในวันสุดท้ายของเดือนถัดไป
                </li>

                <li>
                    ผู้รับอนุญาตต้องเก็บรักษารายงานและเอกสารประกอบไว้ไม่น้อยกว่า ๓ ปี
                </li>
            </ol>

        </div>

    </div>
@endsection
