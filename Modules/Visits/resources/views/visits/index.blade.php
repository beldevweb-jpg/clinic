@extends('core::components.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/visits-view.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
@endpush

@section('content')
    <div class="visit-wrapper">

        <div class="visit-card">

            <div class="visit-header visit-header-flex">

                <h3>
                    รายการผู้เข้ารับบริการ
                </h3>

                <a href="{{ route('visits.create') }}" class="btn-save">
                    + เพิ่มรายการ
                </a>

            </div>


            <div class="table-responsive">

                <table class="visit-table">

                    <thead>
                        <tr>
                            <th>Visit No</th>
                            <th>วันที่</th>
                            <th>ประเภท</th>
                            <th>HN</th>
                            <th>ผู้ป่วย</th>
                            <th>แพทย์</th>
                            <th>สาขา</th>
                            <th width="150">จัดการ</th>
                        </tr>
                    </thead>


                    <tbody>

                        @forelse($visits as $visit)
                            <tr>

                                <td>
                                    {{ $visit->visit_no ?? '-' }}
                                </td>


                                <td>
                                    {{ \Carbon\Carbon::parse($visit->visit_date)->format('d/m/Y') }}
                                </td>


                                <td>

                                    @switch($visit->type)
                                        @case('register')
                                            ลงทะเบียน
                                        @break

                                        @case('pt33')
                                            PT33
                                        @break

                                        @case('pt28')
                                            PT28
                                        @break

                                        @default
                                            อื่นๆ
                                    @endswitch

                                </td>


                                <td>
                                    {{ $visit->patient->hn ?? '-' }}
                                </td>


                                <td>
                                    {{ $visit->patient->firstname ?? '-' }}
                                    {{ $visit->patient->lastname ?? '' }}
                                </td>


                                <td>
                                    {{ $visit->medic->name ?? '-' }}
                                </td>


                                <td>
                                    {{ $visit->branch->name ?? '-' }}
                                </td>


                                <td>

                                    <a href="{{ route('visits.edit', $visit->id) }}" class="btn-edit">
                                        แก้ไข
                                    </a>


                                    <form action="{{ route('visits.destroy', $visit->id) }}" method="POST"
                                        style="display:inline">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn-delete" onclick="return confirm('ยืนยันการลบ?')">
                                            ลบ
                                        </button>

                                    </form>

                                </td>


                            </tr>


                            @empty

                                <tr>
                                    <td colspan="8" class="empty">
                                        ไม่พบข้อมูลการเข้ารับบริการ
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>


                    <div class="pagination">

                        {{ $visits->links() }}

                    </div>


                </div>

            </div>
        @endsection
