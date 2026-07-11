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
        $objectives = json_decode($pt28->objective, true) ?? [];
    @endphp
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        .page {
            position: relative;
            width: 210mm;
            height: 297mm;
        }

        .bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 210mm;
            height: 297mm;
            z-index: 0;
        }

        .text {
            position: absolute;
            z-index: 10;
            font-family: "TH Sarabun New";
            font-size: 18px;
        }

        .month {
            top: 28mm;
            left: 92mm;
        }

        .year {
            top: 28mm;
            left: 130mm;
        }
    </style>

    @foreach ($pages as $page)
        <div class="page">

            <img src="{{ asset('templates/PT28.jpg') }}" class="bg">

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
                    $top = 118 + $index * 8;
                @endphp

                {{-- ลำดับ --}}
                <div style="position:absolute; left:14mm; top:{{ $top }}mm;">
                    {{ $loop->parent->index * 14 + $loop->iteration }}
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
            @endforeach

            @if (in_array('ใช้เอง', $objectives))
                <div style="position:absolute; left:125mm; top:{{ $top }}mm;">
                    ✓
                </div>
            @endif

            @if (in_array('ขายต่อ', $objectives))
                <div style="position:absolute; left:133mm; top:{{ $top }}mm;">
                    ✓
                </div>
            @endif

            @if (in_array('ศึกษาวิจัย', $objectives))
                <div style="position:absolute; left:141mm; top:{{ $top }}mm;">
                    ✓
                </div>
            @endif

            @if (in_array('หน่วยงานรัฐ', $objectives))
                <div style="position:absolute; left:141mm; top:{{ $top }}mm;">
                    ✓
                </div>
            @endif

            @if (in_array('แปรรูป', $objectives))
                <div style="position:absolute; left:141mm; top:{{ $top }}mm;">
                    ✓
                </div>
            @endif

            @if (in_array('ส่งออก', $objectives))
                <div style="position:absolute; left:141mm; top:{{ $top }}mm;">
                    ✓
                </div>
            @endif

            <div style="position:absolute; left:41mm; top:{{ $top }}mm;">
                {{ $detail->license_no }}
            </div>

            <div style="position:absolute; left:192mm; top:{{ $top }}mm;">
                {{ $detail->dosage }}
            </div>

        </div>
        @if (!$loop->last)
            <div style="page-break-after: always;"></div>
        @endif
    @endforeach
