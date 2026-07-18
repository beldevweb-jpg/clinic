@extends('pdf::components.layouts.master')

@section('content')
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        .page {
            position: relative;
            width: 210mm;
            height: 297mm;
            font-family: "TH Sarabun New", "thsarabunnew", sans-serif;
            font-size: 16pt;
            font-weight: normal;
        }

        .text {
            position: absolute;
            z-index: 10;
            white-space: nowrap;
            font-family: "TH Sarabun New", "thsarabunnew", sans-serif;
            font-size: 16pt;
            font-weight: normal;
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
            white-space: nowrap;
        }

        .signature-image {
            position: absolute;
            top: 200mm;
            left: 133mm;
            width: 30mm;
            height: 15mm;
        }
    </style>


    <div class="page">

        <img class="bg" src="{{ public_path('templates/certificate.jpg') }}">


        {{-- วันที่ --}}
        <div class="text" style="
        top:86mm;
        left:147mm;
    ">
            {{ \Carbon\Carbon::parse($certificate->certificate_date)->format('d/m/Y') }}
        </div>


        {{-- ชื่อแพทย์ --}}
        <div class="text" style="
top:102mm;
left:41mm;
">
            {{ $certificate->medic->prefix ?? '' }}
            {{ $certificate->medic->firstname ?? '' }}
            {{ $certificate->medic->lastname ?? '' }}
        </div>


        {{-- ใบอนุญาตเลขที่ --}}
        <div class="text" style="
top:30mm;
left:35mm;
">
            {{ $branchs->license ?? '' }}
        </div>

        {{-- ที่อยู่ --}}
        <div class="text"
            style="
        position:absolute;
        top:40mm;
        left:25mm;
        width:80mm;
        height:23mm;
        white-space:normal;
        line-height:5mm;
        overflow:hidden;
    ">
            {{ $branchs->address ?? '' }}
        </div>

        {{-- เบอร์โทร --}}
        <div class="text" style="
top:62mm;
left:40mm;
">
            {{ $branchs->phone ?? '' }}
        </div>


        {{-- ชื่อผู้ป่วย --}}
        <div class="text" style="
        top:126mm;
        left:59mm;
    ">
            {{ $certificate->patient->prefix ?? '' }} {{ $certificate->patient->firstname ?? '' }}
            {{ $certificate->patient->lastname ?? '' }}
        </div>


        {{-- อาการ --}}
        <div class="text" style="
        top:157mm;
        left:45mm;
        width:120mm;
    ">
            {{ $certificate->symptom ?? '' }}
        </div>


        {{-- เลขบัตร --}}
        <div class="text" style="
        top:142mm;
        left:63mm;
    ">
            {{ $certificate->patient->cid ?? '' }}
        </div>

        {{-- วันพัก --}}
        <div class="text" style="
        top:174mm;
        left:128mm;
    ">
            {{ $certificate->rest_days ?? 0 }}
        </div>


        {{-- ลายเซ็นแพทย์ --}}
        @if ($certificate->medic->signature)
            @php
                $path = public_path('storage/' . $certificate->medic->signature);
            @endphp

            @if (file_exists($path))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($path)) }}" class="signature-image">
            @endif
        @endif

        {{-- ชื่อแพทย์ลายเซ็น --}}
        <div class="text" style="
    top:215mm;
    left:133mm;
">
            {{ $certificate->medic->firstname ?? '' }} {{ $certificate->medic->lastname ?? '' }}
        </div>

    </div>
@endsection
