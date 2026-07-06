@extends('core::components.layouts.master')
@section('content')
    <div class="dashboard">

        <div class="cards">

            <div class="card">
                <h3>Users</h3>
                <p>1,240</p>
            </div>

            <div class="card">
                <h3>Sales</h3>
                <p>฿ 32,500</p>
            </div>

            <div class="card">
                <h3>Orders</h3>
                <p>320</p>
            </div>

            <div class="card">
                <h3>Visits</h3>
                <p>8,920</p>
            </div>

        </div>

        <div class="panel">
            <h3>Overview</h3>
            <canvas id="chart"></canvas>
        </div>

    </div>
@endsection
