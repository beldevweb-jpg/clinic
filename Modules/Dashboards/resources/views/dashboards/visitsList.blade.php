@extends('core::components.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">

    <style>
        .page-card {

            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08);

        }


        .page-header {

            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;

        }


        .table td {

            vertical-align: middle;

        }


        .visit-date {

            white-space: nowrap;
            width: 120px;

        }


        .visit-hn {

            white-space: nowrap;
            width: 120px;

        }


        .visit-name {

            min-width: 180px;

        }


        .visit-medic {

            min-width: 150px;

        }


        .visit-branch {

            white-space: nowrap;

        }


        .visit-note {

            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

        }



        .btn-view {

            padding: 6px 14px;

        }
    </style>
@endpush



@section('content')
    <div class="container">


        <div class="page-card">



            <div class="page-header">


                <h3>
                    🩺 รายการเข้ารับบริการ
                </h3>


                <div>

                    ทั้งหมด :
                    <strong>
                        {{ $visits->total() }}
                    </strong>
                    รายการ

                </div>


            </div>




            <div class="table-container">


                <table class="table">


                    <thead>

                        <tr>

                            <th class="visit-date">
                                วันที่
                            </th>


                            <th class="visit-hn">
                                HN
                            </th>


                            <th class="visit-name">
                                ผู้ป่วย
                            </th>


                            <th class="visit-medic">
                                แพทย์
                            </th>


                            <th>
                                สาขา
                            </th>


                            <th>
                                หมายเหตุ
                            </th>


                            <th>
                            </th>


                        </tr>


                    </thead>



                    <tbody>


                        @forelse($visits as $visit)
                            <tr>


                                <td class="visit-date">

                                    {{ \Carbon\Carbon::parse($visit->visit_date)->format('d/m/Y') }}

                                </td>



                                <td class="visit-hn">

                                    {{ $visit->patient?->hn ?? '-' }}

                                </td>



                                <td class="visit-name">

                                    <strong>

                                        {{ $visit->patient?->firstname ?? '-' }}

                                        {{ $visit->patient?->lastname ?? '' }}

                                    </strong>

                                </td>



                                <td class="visit-medic">

                                    {{ $visit->medic?->firstname ?? '-' }}

                                    {{ $visit->medic?->lastname ?? '' }}

                                </td>



                                <td>

                                    {{ $visit->branch?->name ?? '-' }}

                                </td>



                                <td class="visit-note" title="{{ $visit->note }}">

                                    {{ $visit->note ?? '-' }}

                                </td>



                                <td>


                                    <a href="{{ route('visits.show', $visit->id) }}" class="btn-action btn-view">

                                        ดู

                                    </a>


                                </td>


                            </tr>


                        @empty


                            <tr>

                                <td colspan="7" align="center">

                                    ไม่พบข้อมูลการเข้ารับบริการ

                                </td>

                            </tr>
                        @endforelse


                    </tbody>


                </table>


            </div>



            <div style="margin-top:20px">

                {{ $visits->withQueryString()->links() }}

            </div>



        </div>


    </div>
@endsection
