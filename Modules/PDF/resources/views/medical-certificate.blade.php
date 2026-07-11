@extends('pdf::components.layouts.master')

@section('content')
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
            z-index: 0;
        }
    </style>
    <div class="bg"></div>
@endsection
