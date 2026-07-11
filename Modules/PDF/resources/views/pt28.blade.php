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

            <div class="text month">
                {{ \Carbon\Carbon::now()->locale('th')->translatedFormat('F') }}
            </div>

            <div class="text year">
                {{ thaiNumber(\Carbon\Carbon::now()->year + 543) }}
            </div>
        </div>

        @if (!$loop->last)
            <div style="page-break-after: always;"></div>
        @endif
    @endforeach
