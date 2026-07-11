@extends('core::components.layouts.master')
<link rel="stylesheet" href="{{ asset('css/pt28_edit.css') }}">
@section('content')
    <div class="pt28">

        <form action="{{ route('pt28.update', $pt28->id) }}" method="POST">

            @csrf
            @method('PUT')


            <div class="header-right">
                แบบ ภ.ท. ๒๘
            </div>


            <div class="title">
                แบบรายงานข้อมูลการนำไปใช้ สมุนไพรควบคุม (กัญชา)
            </div>


            <div class="sub-title">
                ประจำเดือน
                <span class="underline">
                    {{-- {{ thaiMonth($pt28->issue_date) }} --}}
                </span>

                พ.ศ.
                <span class="underline">
                    {{-- {{ thaiNumber(\Carbon\Carbon::parse($pt28->issue_date)->year + 543) }} --}}
                </span>
            </div>


            <button type="button" class="btn-add-row">
                + เพิ่มรายการ
            </button>



            @php
                $objectives = json_decode($pt28->objective ?? '{}', true);

                // รวมค่าจากทุก index ให้เป็น array เดียว
                $objectives = collect($objectives)->flatten()->toArray();
            @endphp



            <table class="report-table">
                <thead>

                    <tr>

                        <th rowspan="3">ลำดับ</th>

                        <th rowspan="3">
                            วันเดือนปี
                        </th>


                        <th rowspan="3">
                            เลขประจำตัวประชาชน/
                            <br>
                            เลขหนังสือเดินทาง
                            <br>
                            (ผู้ซื้อ)
                        </th>


                        <th rowspan="3">
                            ชื่อผู้ซื้อ/
                            <br>
                            ผู้รับอนุญาต
                        </th>


                        <th rowspan="3">
                            วันเดือนปีเกิด
                        </th>


                        <th colspan="6">
                            การนำไปใช้ ณ สถานประกอบการ
                        </th>


                        <th rowspan="3">
                            เลขที่ใบอนุญาต
                        </th>


                        <th rowspan="3">
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
                        </th>

                    </tr>



                    <tr>


                        @foreach (['ใช้เอง', 'ขายต่อ', 'ศึกษาวิจัย', 'หน่วยงานรัฐ', 'แปรรูป', 'ส่งออก'] as $obj)
                            <th>
                                {{ $obj }}
                            </th>
                        @endforeach


                    </tr>


                </thead>

                <tbody id="pt28-body">
                    @foreach ($pt28->details as $index => $detail)
                        <tr>
                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td>
                                <input type="date" name="date[]" value="{{ $detail->issue_date }}">
                            </td>

                            <td>
                                <select name="patient_id[]" class="patient-select">
                                    <option value="">
                                        -- ค้นหาผู้ป่วย --
                                    </option>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}"
                                            data-name="{{ $patient->firstname }}
                                                        {{ $patient->lastname }}"
                                            data-birthdate="{{ $patient->birthdate }}"
                                            {{ $detail->patient_id == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->cid }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <span class="name-text">
                                    {{ $detail->patient->firstname ?? '' }}
                                    {{ $detail->patient->lastname ?? '' }}
                                </span>
                            </td>

                            <td>
                                <span class="birthdate-text">
                                    @if ($detail->patient?->birthdate)
                                        {{ \Carbon\Carbon::parse($detail->patient->birthdate)->addYears(543)->format('d/m/Y') }}
                                    @endif
                                </span>
                            </td>
                            @php
                                $detailObjectives = is_array($detail->objective)
                                    ? $detail->objective
                                    : json_decode($detail->objective ?? '[]', true);
                            @endphp
                            @foreach (['ใช้เอง', 'ขายต่อ', 'ศึกษาวิจัย', 'หน่วยงานรัฐ', 'แปรรูป', 'ส่งออก'] as $obj)
                                <td>
                                    <input type="checkbox" name="objective[{{ $index }}][]"
                                        value="{{ $obj }}"
                                        {{ in_array($obj, $detailObjectives ?? []) ? 'checked' : '' }}>
                                </td>
                            @endforeach
                            <td>
                                <input type="text" name="license_no[]" value="{{ $detail->license_no }}">
                            </td>

                            <td>
                                <input type="number" step="0.01" name="qty[]" value="{{ $detail->dosage }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="action-submit">
                <button type="submit" class="btn-save">
                    💾 บันทึกแก้ไข
                </button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {

            $('.patient-select').select2({
                placeholder: '-- ค้นหาผู้ป่วย --',
                width: '100%'
            });


            // เปลี่ยนผู้ป่วยแล้วแสดงชื่อ + วันเกิด
            $('#pt28-body').on('change', '.patient-select', function() {

                let selected = $(this).find(':selected');

                let row = $(this).closest('tr');


                row.find('.name-text').text(
                    selected.data('name') || ''
                );


                let birth = selected.data('birthdate');


                if (birth) {

                    let date = new Date(birth);

                    let thaiDate =
                        String(date.getDate()).padStart(2, '0') +
                        '/' +
                        String(date.getMonth() + 1).padStart(2, '0') +
                        '/' +
                        (date.getFullYear() + 543);


                    row.find('.birthdate-text')
                        .text(thaiDate);

                } else {

                    row.find('.birthdate-text').text('');

                }

            });



            // เพิ่มแถว
            $('.btn-add-row').click(function() {

                let index = $('#pt28-body tr').length;


                let html = `
<tr>

<td>${index + 1}</td>

<td>
<input type="date"
name="date[]"
value="{{ now()->format('Y-m-d') }}">
</td>


<td>

<select name="patient_id[]"
class="patient-select">

<option value="">
-- ค้นหาผู้ป่วย --
</option>

@foreach ($patients as $patient)

<option value="{{ $patient->id }}"
data-name="{{ $patient->firstname }} {{ $patient->lastname }}"
data-birthdate="{{ $patient->birthdate }}">

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


@foreach (['ใช้เอง', 'ขายต่อ', 'ศึกษาวิจัย', 'หน่วยงานรัฐ', 'แปรรูป', 'ส่งออก'] as $obj)

<td>
<input type="checkbox"
name="objective[${index}][]"
value="{{ $obj }}">
</td>

@endforeach


<td>
<input type="text"
name="license_no[]">
</td>


<td>
<input type="number"
step="0.01"
name="qty[]">
</td>


</tr>
`;


                $('#pt28-body').append(html);


                // select2 เฉพาะตัวใหม่
                $('#pt28-body tr:last .patient-select').select2({
                    width: '100%'
                });


            });



            // โหลดหน้าแรก ให้ชื่อแสดงถูกต้อง
            $('.patient-select').each(function() {

                $(this).trigger('change');

            });


        });
    </script>
@endsection
