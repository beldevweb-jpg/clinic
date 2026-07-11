@extends('core::components.layouts.master')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<div class="cards">

    <div class="card">
        <h3>Patients</h3>
        <p>{{ number_format($patients) }}</p>
    </div>

    <div class="card">
        <h3>Medics</h3>
        <p>{{ number_format($medics) }}</p>
    </div>

    <div class="card">
        <h3>Certificates</h3>
        <p>{{ number_format($certificates) }}</p>
    </div>

    <div class="card">
        <h3>Visits</h3>
        <p>{{ number_format($visits) }}</p>
    </div>

</div>
@endsection
