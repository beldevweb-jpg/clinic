@extends('core::components.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">

    <style>
        .audit-detail-card {

            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
            margin-bottom: 20px;

        }


        .audit-header {

            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;

        }


        .audit-info {

            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;

        }


        .info-box {

            background: #f9fafb;
            padding: 12px;
            border-radius: 10px;

        }


        .info-title {

            font-size: 12px;
            color: #6b7280;

        }


        .info-value {

            margin-top: 5px;
            font-size: 15px;
            font-weight: 600;

            word-break: break-word;

        }



        .json-box {

            background: #111827;
            color: #e5e7eb;

            padding: 15px;

            border-radius: 10px;

            max-height: 350px;

            overflow: auto;

            font-size: 13px;

            line-height: 1.6;

        }



        .compare-box {

            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;

        }



        .section-title {

            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;

        }



        @media(max-width:992px) {

            .audit-info {

                grid-template-columns: repeat(2, 1fr);

            }


            .compare-box {

                grid-template-columns: 1fr;

            }

        }



        @media(max-width:576px) {

            .audit-info {

                grid-template-columns: 1fr;

            }

        }
    </style>
@endpush



@section('content')
    <div class="container">



        <div class="audit-detail-card">


            <div class="audit-header">

                <h3>
                    📋 รายละเอียด Audit
                </h3>


                <a href="{{ route('audit.index') }}" class="btn-action btn-view">

                    กลับ

                </a>


            </div>



            <div class="audit-info">



                <div class="info-box">

                    <div class="info-title">
                        ผู้ทำรายการ
                    </div>

                    <div class="info-value">

                        {{ $log->user?->name ?? '-' }}

                    </div>

                </div>




                <div class="info-box">

                    <div class="info-title">
                        Action
                    </div>

                    <div class="info-value">


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


                    </div>

                </div>




                <div class="info-box">

                    <div class="info-title">
                        ข้อมูล
                    </div>

                    <div class="info-value">

                        {{ class_basename($log->auditable_type) }}

                        #{{ $log->auditable_id }}

                    </div>

                </div>




                <div class="info-box">

                    <div class="info-title">
                        สาขา
                    </div>

                    <div class="info-value">

                        {{ $log->branch?->name ?? '-' }}

                    </div>

                </div>




                <div class="info-box">

                    <div class="info-title">
                        IP Address
                    </div>

                    <div class="info-value">

                        {{ $log->ip_address ?? '-' }}

                    </div>

                </div>




                <div class="info-box">

                    <div class="info-title">
                        เวลา
                    </div>

                    <div class="info-value">

                        {{ $log->created_at->format('d/m/Y H:i:s') }}

                    </div>

                </div>



                <div class="info-box">

                    <div class="info-title">
                        รายละเอียด
                    </div>

                    <div class="info-value">

                        {{ $log->description ?? '-' }}

                    </div>

                </div>



                <div class="info-box">

                    <div class="info-title">
                        Method
                    </div>

                    <div class="info-value">

                        {{ $log->method ?? '-' }}

                    </div>

                </div>



            </div>


        </div>






        <div class="compare-box">


            <div class="audit-detail-card">


                <div class="section-title">
                    ⬅️ ก่อนแก้ไข
                </div>


                <pre class="json-box">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>


            </div>




            <div class="audit-detail-card">


                <div class="section-title">
                    ➡️ หลังแก้ไข
                </div>


                <pre class="json-box">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>


            </div>


        </div>



    </div>
@endsection
