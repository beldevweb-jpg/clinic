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
                <form action="{{ route('medics.update', $medic->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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

                                        <input type="checkbox" name="profession_ids[]" value="{{ $profession->id }}"
                                            @if ($medic->professions->contains('professions_id', $profession->id)) checked @endif>

                                        <span>
                                            {{ $profession->name }}
                                        </span>

                                    </label>
                                @endforeach

                            </div>
                        </div>


                        <div class="medic-group">
                            <label>คำนำหน้า</label>

                            <select name="prefix">

                                <option value="">
                                    เลือก
                                </option>

                                <option value="นาย" {{ $medic->prefix == 'นาย' ? 'selected' : '' }}>
                                    นาย
                                </option>

                                <option value="นาง" {{ $medic->prefix == 'นาง' ? 'selected' : '' }}>
                                    นาง
                                </option>

                                <option value="นางสาว" {{ $medic->prefix == 'นางสาว' ? 'selected' : '' }}>
                                    นางสาว
                                </option>

                            </select>

                        </div>


                        <div class="medic-group">
                            <label>ชื่อ</label>

                            <input type="text" name="firstname" value="{{ $medic->firstname }}">
                        </div>


                        <div class="medic-group">
                            <label>นามสกุล</label>

                            <input type="text" name="lastname" value="{{ $medic->lastname }}">
                        </div>


                        <div class="medic-group">
                            <label>เลขใบประกอบวิชาชีพ</label>

                            <input type="text" name="license" value="{{ $medic->license }}">
                        </div>


                        <div class="medic-group">
                            <label>เบอร์โทรศัพท์</label>

                            <input type="text" name="phone" value="{{ $medic->phone }}">
                        </div>


                        <div class="medic-group">
                            <label>ลายเซ็นแพทย์</label>

                            <input type="file" name="signature">


                            @if ($medic->signature)
                                <div style="margin-top:10px">

                                    <img src="{{ asset('storage/' . $medic->signature) }}" width="120">

                                </div>
                            @endif

                        </div>


                        <div class="medic-group">

                            <label>สถานะ</label>

                            <select name="status">

                                <option value="1" {{ $medic->status == 1 ? 'selected' : '' }}>
                                    ใช้งาน
                                </option>

                                <option value="0" {{ $medic->status == 0 ? 'selected' : '' }}>
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
                            💾 บันทึกการแก้ไข
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
