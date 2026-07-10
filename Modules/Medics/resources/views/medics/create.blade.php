@extends('core::components.layouts.master')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/medic.css') }}">
@endpush
@section('content')
    <div class="medic-container">
        <div class="medic-card">
            <div class="medic-header">
                <h4>เพิ่มข้อมูลแพทย์</h4>
            </div>
            <div class="medic-body">
                <form action="{{ route('medics.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="medic-grid">
                        {{-- แจ้งเตือน --}}
                        @if (session('success'))
                            <div class="alert success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert error">
                                @foreach ($errors->all() as $error)
                                    <div>• {{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        <div class="medic-group medic-full">
                            <label>ประเภทบุคลากร</label>

                            <div class="profession-grid">
                                @foreach ($professions as $profession)
                                    <label class="profession-item">
                                        <input type="checkbox" name="profession_ids[]" value="{{ $profession->id }}">
                                        <span>{{ $profession->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="medic-group">
                            <label>
                                คำนำหน้า
                            </label>
                            <select name="prefix">
                                <option value="">
                                    เลือก
                                </option>
                                <option value="นพ.">
                                    นพ.
                                </option>
                                <option value="พญ.">
                                    พญ.
                                </option>
                            </select>
                        </div>

                        <div class="medic-group">
                            <label>
                                ชื่อ
                            </label>
                            <input type="text" name="firstname">
                        </div>

                        <div class="medic-group">
                            <label>
                                นามสกุล
                            </label>
                            <input type="text" name="lastname">
                        </div>

                        <div class="medic-group">
                            <label>
                                เลขใบประกอบวิชาชีพ
                            </label>
                            <input type="text" name="license">
                        </div>

                        <div class="medic-group">
                            <label>
                                เบอร์โทรศัพท์
                            </label>
                            <input type="text" name="phone">
                        </div>

                        <div class="medic-group">
                            <label>
                                ลายเซ็นแพทย์
                            </label>
                            <input type="file" name="signature">
                        </div>

                        <div class="medic-group">
                            <label>
                                สถานะ
                            </label>
                            <select name="status">
                                <option value="1">
                                    ใช้งาน
                                </option>
                                <option value="0">
                                    ปิดใช้งาน
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="medic-actions">
                        <a href="{{ route('medics.index') }}" class="btn-cancel-medic">
                            ยกเลิก
                        </a>
                        <button class="btn-save-medic">
                            💾 บันทึก
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
