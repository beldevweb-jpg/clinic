@extends('pdf::components.layouts.master')


<link rel="stylesheet" href="{{ asset('css/pt28.css') }}">
@section('content')
    <div class="pt28">

        <div class="header-right">
            แบบ ภ.ท. ๒๘
        </div>

        <div class="title">
            แบบรายงานข้อมูลการนำไปใช้ สมุนไพรควบคุม (กัญชา)
        </div>

        <div class="sub-title">
            ประจำเดือน <span class="line"></span> พ.ศ. <span class="line"></span>
        </div>

        <div class="note">
            (ผู้ได้รับอนุญาตต้องปฏิบัติตามข้อกำหนดแนบท้ายรายงานนี้)
        </div>
        
        <div class="receiver">
            เรียน
            <input type="checkbox"> นายทะเบียนกลาง
            นายกอง อธิบดีกรมการแพทย์แผนไทยและการแพทย์ทางเลือก

            <br>

            <input type="checkbox"> นายทะเบียนจังหวัด
            หมายถึง นายแพทย์สาธารณสุขจังหวัด.............................
        </div>

        <div class="license-info">
            ชื่อผู้รับใบอนุญาต............................................................
        </div>

        <div class="license-info">
            เลขที่ใบอนุญาต...............................................................
        </div>

        <table>
            <thead>
                <tr>
                    <th rowspan="3">ลำดับ</th>
                    <th rowspan="3">วันเดือนปี</th>
                    <th rowspan="3">
                        เลขประจำตัวประชาชน/
                        เลขหนังสือเดินทาง
                        (ผู้รับ)
                    </th>
                    <th rowspan="3">
                        ชื่อผู้รับ/
                        ผู้ซื้อวัตถุควบคุม
                        (ผู้รับ)
                    </th>
                    <th rowspan="3">
                        วันเดือนปีเกิด
                        (ผู้รับ)
                    </th>

                    <th colspan="6">
                        การนำไปใช้ ณ สถานประกอบการ
                    </th>

                    <th rowspan="3">
                        เลขที่ใบอนุญาต
                        (ผู้ซื้อ)
                    </th>

                    <th rowspan="3">
                        ปริมาณ
                        ช่อดอก
                        กัญชาแห้ง
                        (กรัม)
                    </th>
                </tr>

                <tr>
                    <th colspan="6">
                        วัตถุประสงค์ของการนำไปใช้
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
                @for ($i = 1; $i <= 15; $i++)
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endfor
            </tbody>
        </table>

    </div>
@endsection
