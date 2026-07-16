@extends('core::components.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">

    <style>
        .audit-card {

            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08);

        }


        .audit-title {

            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;

        }


        .filter-box {

            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;

        }


        .filter-box input,
        .filter-box select {

            height: 38px;
            min-width: 160px;
            padding: 0 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;

        }


        .filter-box input {

            min-width: 220px;

        }


        .btn-search {

            height: 38px;
            background: #2563eb;
            color: white;
            border: none;
            padding: 0 20px;
            border-radius: 8px;
            cursor: pointer;

        }


        .btn-search:hover {

            background: #1d4ed8;

        }


        /* Table Fix */

        .table td {

            vertical-align: middle;

        }


        .col-time {

            width: 130px;
            white-space: nowrap;

        }


        .col-user {

            width: 140px;

        }


        .col-branch {

            width: 120px;

        }


        .col-action {

            width: 100px;
            text-align: center;

        }


        .col-data {

            width: 150px;

        }


        .col-detail {

            max-width: 250px;

        }


        .col-ip {

            width: 130px;
            white-space: nowrap;

        }


        .col-btn {

            width: 80px;
            text-align: center;

        }


        .detail-text {

            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

        }
    </style>
@endpush



@section('content')
    <div class="container">


        <div class="audit-card">


            <div class="audit-title">

                <h3>
                    📋 Audit Logs
                </h3>


                <div>

                    ทั้งหมด :
                    <strong>
                        {{ $logs->total() }}
                    </strong>
                    รายการ

                </div>


            </div>




            <form method="GET">


                <div class="filter-box">


                    <input type="text" name="search" placeholder="🔍 ค้นหา..." value="{{ request('search') }}">



                    <select name="action">

                        <option value="">
                            ทุก Action
                        </option>


                        <option value="CREATE" {{ request('action') == 'CREATE' ? 'selected' : '' }}>
                            CREATE
                        </option>


                        <option value="UPDATE" {{ request('action') == 'UPDATE' ? 'selected' : '' }}>
                            UPDATE
                        </option>


                        <option value="DELETE" {{ request('action') == 'DELETE' ? 'selected' : '' }}>
                            DELETE
                        </option>


                    </select>




                    <select name="branch_id">


                        <option value="">
                            ทุกสาขา
                        </option>


                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>

                                {{ $branch->name }}

                            </option>
                        @endforeach


                    </select>



                    <button class="btn-search">

                        ค้นหา

                    </button>


                </div>


            </form>





            <div class="table-container">


                <table class="table">


                    <thead>

                        <tr>

                            <th class="col-time">
                                เวลา
                            </th>

                            <th class="col-user">
                                ผู้ใช้
                            </th>

                            <th class="col-branch">
                                สาขา
                            </th>

                            <th class="col-action">
                                Action
                            </th>

                            <th class="col-data">
                                ข้อมูล
                            </th>

                            <th>
                                รายละเอียด
                            </th>

                            <th class="col-ip">
                                IP
                            </th>

                            <th class="col-btn">
                            </th>

                        </tr>

                    </thead>



                    <tbody>


                        @forelse($logs as $log)
                            <tr>


                                <td>

                                    {{ $log->created_at->format('d/m/Y H:i') }}

                                </td>


                                <td>

                                    {{ $log->user?->name ?? '-' }}

                                </td>


                                <td>

                                    {{ $log->branch?->name ?? '-' }}

                                </td>



                                <td>


                                    @if ($log->action == 'CREATE')
                                        <span class="badge badge-success">
                                            CREATE
                                        </span>
                                    @elseif($log->action == 'UPDATE')
                                        <span class="badge badge-warning">
                                            UPDATE
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            DELETE
                                        </span>
                                    @endif


                                </td>




                                <td>

                                    {{ class_basename($log->auditable_type) }}

                                    #{{ $log->auditable_id }}

                                </td>




                                <td>

                                    <div class="detail-text" title="{{ $log->description }}">

                                        {{ $log->description }}

                                    </div>

                                </td>




                                <td>

                                    {{ $log->ip_address }}

                                </td>




                                <td>

                                    <a href="{{ route('audit.show', $log->id) }}" class="btn-action btn-view">

                                        ดู

                                    </a>

                                </td>



                            </tr>


                        @empty


                            <tr>

                                <td colspan="8" align="center">

                                    ไม่พบข้อมูล Audit Log

                                </td>

                            </tr>
                        @endforelse


                    </tbody>


                </table>


            </div>




            <div style="margin-top:20px">

                {{ $logs->withQueryString()->links() }}

            </div>



        </div>


    </div>
@endsection
