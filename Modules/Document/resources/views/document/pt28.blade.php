@extends('core::components.layouts.master')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/pt28.css') }}">
<link rel="stylesheet" href="{{ asset('css/error.css') }}">

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

        <form action="{{ route('pt28.store') }}" method="POST">
            @csrf
            <div class="header-right">
                แบบ ภ.ท. ๒๘
            </div>



            <div class="sub-title">
                ประจำเดือน
                <span class="underline">{{ thaiMonth(now()) }}</span>
                พ.ศ.
                <span class="underline">{{ thaiNumber(now()->year + 543) }}</span>
            </div>
            <button type="button" class="btn-add-row">
                + เพิ่มรายการ
            </button>
            <table class="report-table">
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
                            <br>
                            ชื่อผู้ซื้อ/
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
                        <th>
                            ใช้เอง
                        </th>

                        <th>
                            ขายต่อ
                        </th>

                        <th>
                            ศึกษาวิจัย
                        </th>

                        <th>
                            ศึกษาวิจัย (หน่วยงานรัฐ)
                        </th>

                        <th>
                            แปรรูป
                        </th>

                        <th>
                            ส่งออก
                        </th>
                    </tr>

                </thead>

                <tbody id="pt28-body">

                </tbody>
            </table>
            <div class="action-submit">
                <button type="submit" class="btn-save">
                    💾 บันทึกข้อมูล
                </button>
            </div>

        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        jQuery(function($) {

            let rowNumber = 0;

            function initSelect2() {

                $('.patient-select:not(.select2-hidden-accessible)').select2({
                    placeholder: '-- ค้นหาผู้ป่วย --',
                    allowClear: true,
                    width: '100%'
                });

            }


            function addRow() {

                let index = rowNumber;
                rowNumber++;

                let html = `

<tr>

<td>${rowNumber}</td>


<td>
    <input type="date"
        name="date[]"
        value="{{ now()->format('Y-m-d') }}">
</td>


<td>
    <select name="patient_id[]" class="patient-select">

        <option value="">
            -- ค้นหาผู้ป่วย --
        </option>

        @foreach ($patients as $patient)

        <option value="{{ $patient->id }}"
            data-name="{{ $patient->firstname }} {{ $patient->lastname }}"
            data-birthdate="{{ \Carbon\Carbon::parse($patient->birthdate)->format('Y-m-d') }}">

            {{ $patient->cid }}

        </option>

        @endforeach

    </select>
</td>


<td>
    <span class="name-text"></span>
</td>


<td>
    <span class="birthdate-text"></span>
</td>


<td>
    <input type="checkbox" name="objective[${index}][]" value="ใช้เอง">
</td>

<td>
    <input type="checkbox" name="objective[${index}][]" value="ขายต่อ">
</td>

<td>
    <input type="checkbox" name="objective[${index}][]" value="ศึกษาวิจัย">
</td>

<td>
    <input type="checkbox" name="objective[${index}][]" value="หน่วยงานรัฐ">
</td>

<td>
    <input type="checkbox" name="objective[${index}][]" value="แปรรูป">
</td>

<td>
    <input type="checkbox" name="objective[${index}][]" value="ส่งออก">
</td>


<td>
    <input type="text" name="license_no[]">
</td>


<td>
    <input type="number" step="0.01" name="qty[]">
</td>


</tr>

`;

                $('#pt28-body').append(html);

                initSelect2();

            }



            // โหลดหน้าแรก
            for (let i = 0; i < 2; i++) {
                addRow();
            }



            // ปุ่มเพิ่มรายการ
            $('.btn-add-row').on('click', function() {

                console.log('กดเพิ่มรายการ');

                addRow();

            });



            // เลือกผู้ป่วย
            $(document).on('change', '.patient-select', function() {


                let row = $(this).closest('tr');

                let option = this.options[this.selectedIndex];


                row.find('.name-text')
                    .text(option.dataset.name || '');



                let birthdate = option.dataset.birthdate;



                if (birthdate) {


                    let date = new Date(birthdate);


                    let day = String(date.getDate())
                        .padStart(2, '0');


                    let month = String(date.getMonth() + 1)
                        .padStart(2, '0');


                    let year = date.getFullYear() + 543;



                    row.find('.birthdate-text')
                        .text(`${day}/${month}/${year}`);


                } else {


                    row.find('.birthdate-text')
                        .text('');

                }


            });


        });
    </script>
@endsection
