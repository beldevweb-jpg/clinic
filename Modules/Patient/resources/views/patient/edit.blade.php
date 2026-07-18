@extends('core::components.layouts.master')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/patient.js') }}"></script>
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/patient.css') }}">
    <link rel="stylesheet" href="{{ asset('css/error.css') }}">
@endpush
@section('content')
    <div class="patient-container">

        <div class="header">
            <h2>🏥 แก้ไขข้อมูลผู้ป่วย</h2>
            <p>แก้ไขข้อมูลผู้ป่วยและบันทึกการเปลี่ยนแปลง</p>
        </div>

        {{-- แจ้งเตือน --}}
        @if (session('success'))
            <div class="notify notify-success">
                <div class="notify-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

                <div class="notify-content">
                    <h6>ดำเนินการสำเร็จ</h6>
                    <p>{{ session('success') }}</p>
                </div>

                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="patient-info">
            <strong>HN :</strong> {{ $patient->hn }}
        </div>

        <form id="patientForm" method="POST" action="{{ route('patient.update', $patient->id) }}">

            @csrf
            @method('PUT') {{-- ข้อมูลบัตรประชาชน --}}
            <div class="card">
                <div class="card-title">
                    📇 ข้อมูลบัตรประชาชน
                </div>
                <div class="grid">

                    <div class="form-group">
                        <label>ชื่อภาษาอังกฤษ</label>
                        <input type="text" id="firstname_en" name="firstname_en"
                            value="{{ old('firstname_en', $patient->firstname_en) }}">
                    </div>


                    <div class="form-group">
                        <label>นามสกุลภาษาอังกฤษ</label>
                        <input type="text" id="lastname_en" name="lastname_en"
                            value="{{ old('lastname_en', $patient->lastname_en) }}">
                    </div>


                    <div class="form-group">
                        <label>เลขบัตรประชาชน</label>
                        <input type="text" id="cid" name="cid" value="{{ old('cid', $patient->cid) }}">
                    </div>


                    <div class="form-group">
                        <label>สัญชาติ</label>
                        <input type="text" id="nationality" name="nationality" value="{{ old('nationality', $patient->nationality) }}">
                    </div>

                </div>
            </div>

            {{-- ข้อมูลส่วนตัว --}}
            <div class="card">

                <div class="card-title">
                    👤 ข้อมูลส่วนตัว
                </div>

                <div class="grid">

                    <div class="form-group">
                        <label>คำนำหน้า</label>

                        <select name="prefix">

                            <option value="">เลือก</option>

                            <option value="นาย" {{ old('prefix', $patient->prefix) == 'นาย' ? 'selected' : '' }}>
                                นาย
                            </option>

                            <option value="นาง" {{ old('prefix', $patient->prefix) == 'นาง' ? 'selected' : '' }}>
                                นาง
                            </option>

                            <option value="นางสาว" {{ old('prefix', $patient->prefix) == 'นางสาว' ? 'selected' : '' }}>
                                นางสาว
                            </option>

                        </select>

                    </div>


                    <div class="form-group">
                        <label>เพศ</label>

                        <select name="gender">

                            <option value="">เลือก</option>

                            <option value="ชาย" {{ old('gender', $patient->gender) == 'ชาย' ? 'selected' : '' }}>
                                ชาย
                            </option>

                            <option value="หญิง" {{ old('gender', $patient->gender) == 'หญิง' ? 'selected' : '' }}>
                                หญิง
                            </option>

                        </select>

                    </div>


                    <div class="form-group">
                        <label>ชื่อ</label>

                        <input type="text" name="firstname" value="{{ old('firstname', $patient->firstname) }}">

                    </div>


                    <div class="form-group">
                        <label>นามสกุล</label>

                        <input type="text" name="lastname" value="{{ old('lastname', $patient->lastname) }}">

                    </div>


                    <div class="form-group">
                        <label>วันเกิด</label>

                        <input type="date" name="birthday" value="{{ old('birthday', $patient->birthday) }}">

                    </div>


                    <div class="form-group">
                        <label>อายุ</label>

                        <input type="number" name="age" value="{{ old('age', $patient->age) }}">

                    </div>


                </div>

            </div>

            {{-- ที่อยู่ --}}
            <div class="card">

                <div class="card-title">
                    🏠 ที่อยู่
                </div>

                <div class="grid">

                    <div class="form-group full">
                        <label>ที่อยู่</label>
                        <textarea name="card_address">{{ old('card_address', $patient->card_address) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>จังหวัด</label>
                        <input type="text" name="province" value="{{ old('province', $patient->province) }}">
                    </div>

                    <div class="form-group">
                        <label>อำเภอ</label>
                        <input type="text" name="district" value="{{ old('district', $patient->district) }}">
                    </div>

                    <div class="form-group">
                        <label>ตำบล</label>
                        <input type="text" name="subdistrict" value="{{ old('subdistrict', $patient->subdistrict) }}">
                    </div>

                    <div class="form-group">
                        <label>รหัสไปรษณีย์</label>
                        <input type="text" name="zipcode" value="{{ old('zipcode', $patient->zipcode) }}">
                    </div>

                </div>

            </div>

            {{-- ติดต่อ --}}
            <div class="card">

                <div class="card-title">
                    ☎️ ข้อมูลติดต่อ
                </div>

                <div class="grid">

                    <div class="form-group">
                        <label>เบอร์โทรศัพท์</label>
                        <input value="{{ old('phone', $patient->phone) }}">
                    </div>

                </div>

            </div>
            <div class="card">

                <div class="card-title">
                    🩺 ข้อมูลการตรวจ

                    <div class="grid">

                        <div class="form-group">
                            <label>BP (mmHg)</label>
                            <input type="text" name="blood_pressure"
                                value="{{ old('blood_pressure', $patient->blood_pressure) }}">
                        </div>

                        <div class="form-group">
                            <label>PR (bpm)</label>
                            <input type="number" name="pulse_rate"
                                value="{{ old('pulse_rate', $patient->pulse_rate) }}">
                        </div>

                        <div class="form-group">
                            <label>RR (bpm)</label>
                            <input type="number" name="respiratory_rate"
                                value="{{ old('respiratory_rate', $patient->respiratory_rate) }}">
                        </div>

                        <div class="form-group">
                            <label>Temperature (°C)</label>
                            <input type="number" step="0.1" name="temperature"
                                value="{{ old('temperature', $patient->temperature) }}">
                        </div>

                        <div class="form-group">
                            <label>ส่วนสูง (cm)</label>
                            <input type="number" step="0.01" name="height"
                                value="{{ old('height', $patient->height) }}">
                        </div>

                        <div class="form-group">
                            <label>น้ำหนัก (kg)</label>
                            <input type="number" step="0.01" name="weight"
                                value="{{ old('weight', $patient->weight) }}">
                        </div>

                        <div class="form-group full">
                            <label>Chief Complaint (CC)</label>
                            <textarea name="chief_complaint">{{ old('chief_complaint', $patient->chief_complaint) }}</textarea>
                        </div>

                        <div class="form-group full">
                            <label>ตรวจอื่น ๆ (Physical Exam)</label>
                            <textarea name="physical_exam">{{ old('physical_exam', $patient->physical_exam) }}</textarea>
                        </div>

                        <div class="form-group full">
                            <label>DX (Diagnosis)</label>
                            <textarea name="diagnosis">{{ old('diagnosis', $patient->diagnosis) }}</textarea>
                        </div>

                        <div class="form-group full">
                            <label>TX (Treatment)</label>
                            <textarea name="treatment">{{ old('treatment', $patient->treatment) }}</textarea>
                        </div>

                    </div>

                </div>

                <div class="action">
                    <button type="button" class="btn-reader" onclick="readCard()">

                        🔍 อ่านข้อมูลจากบัตรประชาชน

                    </button>

                    <button type="submit" class="btn-save">
                        💾 บันทึกข้อมูล
                    </button>

                    <a href="{{ route('patient.index') }}" class="btn-cancel">
                        ❌ ยกเลิก
                    </a>

                </div>

        </form>

    </div>

    <script src="{{ asset('js/patient.js') }}"></script>
@endsection
