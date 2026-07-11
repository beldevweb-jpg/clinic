@extends('pdf::components.layouts.master')

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
        $objectives = json_decode($pt28->objective ?? '[]', true);
        $objectives = array_unique($objectives);
    @endphp
    <style>
        .page {
            position: relative;
            width: 210mm;
            height: 297mm;
            overflow: hidden;
        }

        .bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 210mm;
            height: 297mm;
            background-image: url("{{ public_path('templates/PT28.jpg') }}");
            background-size: 210mm 297mm;
            background-repeat: no-repeat;
        }

        .text {

            position: absolute;
            z-index: 10;
            font-family: "TH Sarabun New";
            font-size: 18px;
        }

        .month {
            top: 26mm;
            left: 92mm;
        }

        .year {
            top: 26mm;
            left: 130mm;
        }

        .bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 210mm;
            height: 297mm;
            background-image: url("{{ public_path('templates/PT28.jpg') }}");
            background-size: 210mm 297mm;
            background-repeat: no-repeat;
            z-index: 0;
        }
    </style>

    @foreach ($pages as $pageIndex => $page)
        <div class="page">
            <div class="bg"></div>

            {{-- หัวเอกสาร --}}
            <div class="text month">
                {{ \Carbon\Carbon::now()->locale('th')->translatedFormat('F') }}
            </div>

            <div class="text year">
                {{ thaiNumber(\Carbon\Carbon::now()->year + 543) }}
            </div>

            {{-- รายการในหน้านี้ --}}
            @foreach ($page as $index => $detail)
                @php
                    $offset = $pageIndex * -87;

                    $top = 116 + $offset + $index * 6.21;
                @endphp

                {{-- ลำดับ --}}
                <div style="position:absolute; left:14mm; top:{{ $top }}mm;">
                    {{ $pageIndex * 14 + $index + 1 }}
                </div>

                {{-- วันที่ --}}
                <div style="position:absolute; left:22mm; top:{{ $top }}mm;">
                    {{ \Carbon\Carbon::parse($detail->issue_date)->format('d/m/Y') }}
                </div>
                {{-- @dd($detail->getRelations()) --}}
                {{-- เลขบัตร --}}
                <div style="position:absolute; left:41mm; top:{{ $top }}mm;">
                    {{ $detail->patient->cid }}
                </div>

                {{-- ชื่อ --}}
                <div style="position:absolute; left:65mm; top:{{ $top }}mm;">
                    {{ $detail->patient->firstname }} {{ $detail->patient->lastname }}
                </div>

                {{-- ว/ด/ป เกิด --}}
                <div style="position:absolute; left:90mm; top:{{ $top }}mm;">
                    {{ $detail->patient->birthday
                        ? \Carbon\Carbon::parse($detail->patient->birthday)->format('d/m/') .
                            (\Carbon\Carbon::parse($detail->patient->birthday)->year + 543)
                        : '' }}
                </div>
                {{-- ใช้เอง --}}
                @if (in_array('ใช้เอง', $objectives))
                    <div style="position:absolute; left:125mm; top:{{ $top }}mm;">
                        ✓
                    </div>
                @endif


                {{-- ขายต่อ --}}
                @if (in_array('ขายต่อ', $objectives))
                    <div style="position:absolute; left:133mm; top:{{ $top }}mm;">
                        ✓
                    </div>
                @endif


                {{-- ศึกษาวิจัย --}}
                @if (in_array('ศึกษาวิจัย', $objectives))
                    <div style="position:absolute; left:141mm; top:{{ $top }}mm;">
                        ✓
                    </div>
                @endif


                {{-- หน่วยงานรัฐ --}}
                @if (in_array('หน่วยงานรัฐ', $objectives))
                    <div style="position:absolute; left:149mm; top:{{ $top }}mm;">
                        ✓
                    </div>
                @endif


                {{-- แปรรูป --}}
                @if (in_array('แปรรูป', $objectives))
                    <div style="position:absolute; left:157mm; top:{{ $top }}mm;">
                        ✓
                    </div>
                @endif


                {{-- ส่งออก --}}
                @if (in_array('ส่งออก', $objectives))
                    <div style="position:absolute; left:165mm; top:{{ $top }}mm;">
                        ✓
                    </div>
                @endif

                <div style="position:absolute; left:150mm; top:{{ $top }}mm;">
                    {{ $detail->license_no }}
                </div>

                <div style="position:absolute; left:192mm; top:{{ $top }}mm;">
                    {{ $detail->dosage }}
                </div>
            @endforeach
        </div>
    @endforeach
@endsection
