@extends('core::components.layouts.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile-medics.css') }}">
@endpush
@section('content')
    <div class="medic-profile">

        <div class="profile-header">

            <div class="signature">

                @if ($medic->signature)
                    <img src="{{ asset('storage/' . $medic->signature) }}" width="180">
                @else
                    <div>
                        ไม่มีลายเซ็น
                    </div>
                @endif

            </div>


            <div class="profile-name">

                <h2>
                    {{ $medic->prefix }}
                    {{ $medic->firstname }}
                    {{ $medic->lastname }}
                </h2>

                <span>
                    เลขใบประกอบวิชาชีพ:
                    {{ $medic->license }}
                </span>

            </div>

        </div>



        <div class="profile-card">

            <h3>
                ข้อมูลแพทย์
            </h3>


            <div class="profile-row">

                <label>
                    ชื่อ
                </label>

                <span>
                    {{ $medic->firstname }}
                </span>

            </div>



            <div class="profile-row">

                <label>
                    นามสกุล
                </label>

                <span>
                    {{ $medic->lastname }}
                </span>

            </div>



            <div class="profile-row">

                <label>
                    เบอร์โทรศัพท์
                </label>

                <span>
                    {{ $medic->phone ?? '-' }}
                </span>

            </div>



            <div class="profile-row">

                <label>
                    สถานะ
                </label>


                @if ($medic->status)
                    <span class="badge badge-success">
                        ใช้งาน
                    </span>
                @else
                    <span class="badge badge-secondary">
                        ปิดใช้งาน
                    </span>
                @endif

            </div>


        </div>



        <div class="profile-card">

            <h3>
                ประเภทบุคลากร / วิชาชีพ
            </h3>


            @forelse($medic->professions as $item)
                <span class="badge badge-info">

                    {{ $item->profession->name }}

                </span>

            @empty

                -
            @endforelse


        </div>


        <div class="profile-actions">

            <a href="{{ route('medics.edit', $medic->id) }}" class="btn-action btn-edit">

                แก้ไขข้อมูล

            </a>


            <a href="{{ route('medics.index') }}" class="btn-action">

                กลับ

            </a>

        </div>


    </div>
@endsection
