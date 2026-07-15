@extends('core::components.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/patient.css') }}">
    <link rel="stylesheet" href="{{ asset('css/error.css') }}">
@endpush
@section('content')
    <div class="patient-container">

        <div class="header">
            <h2>🏥 ลงทะเบียนผู้ป่วยใหม่</h2>
            <p>กรอกข้อมูลผู้ป่วยเพื่อบันทึกเข้าสู่ระบบ</p>
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

        <form id="patientForm" method="POST" action="{{ route('patient.store') }}">

            @csrf



            {{-- ข้อมูลบัตรประชาชน --}}
            <div class="card">

                <div class="card-title">
                    📇 ข้อมูลบัตรประชาชน
                </div>


                <div class="grid">

                    <div class="form-group">
                        <label>ชื่อภาษาอังกฤษ</label>
                        <input type="text" id="firstname_en" name="firstname_en" value="{{ old('firstname_en') }}">
                    </div>


                    <div class="form-group">
                        <label>นามสกุลภาษาอังกฤษ</label>
                        <input type="text" id="lastname_en" name="lastname_en" value="{{ old('lastname_en') }}">
                    </div>


                    <div class="form-group">
                        <label>เลขบัตรประชาชน</label>
                        <input type="text" id="cid" name="cid" value="{{ old('cid') }}">
                    </div>


                    <div class="form-group">
                        <label>สัญชาติ</label>
                        <input type="text" id="nationality" name="nationality" value="{{ old('nationality') }}">
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
                            <option value="นาย" {{ old('prefix') == 'นาย' ? 'selected' : '' }}>นาย</option>
                            <option value="นาง" {{ old('prefix') == 'นาง' ? 'selected' : '' }}>นาง</option>
                            <option value="นางสาว" {{ old('prefix') == 'นางสาว' ? 'selected' : '' }}>นางสาว</option>
                        </select>

                    </div>

                    <div class="form-group">
                        <label>เพศ</label>

                        <select name="gender">

                            <option value="">เลือก</option>

                            <option value="ชาย" {{ old('gender') == 'ชาย' ? 'selected' : '' }}>
                                ชาย
                            </option>

                            <option value="หญิง" {{ old('gender') == 'หญิง' ? 'selected' : '' }}>
                                หญิง
                            </option>

                        </select>

                    </div>

                    <div class="form-group">
                        <label>ชื่อ</label>
                        <input type="text" name="firstname" value="{{ old('firstname') }}">
                    </div>

                    <div class="form-group">
                        <label>นามสกุล</label>
                        <input type="text" name="lastname" value="{{ old('lastname') }}">
                    </div>

                    <div class="form-group">
                        <label>วันเกิด</label>
                        <input type="date" name="birthday" value="{{ old('birthday') }}">
                    </div>

                    <div class="form-group">
                        <label>อายุ</label>
                        <input type="number" name="age" value="{{ old('age') }}">
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
                        <textarea name="address">{{ old('address') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>จังหวัด</label>
                        <input type="text" name="province" value="{{ old('province') }}">
                    </div>

                    <div class="form-group">
                        <label>อำเภอ</label>
                        <input type="text" name="district" value="{{ old('district') }}">
                    </div>

                    <div class="form-group">
                        <label>ตำบล</label>
                        <input type="text" name="subdistrict" value="{{ old('subdistrict') }}">
                    </div>

                    <div class="form-group">
                        <label>รหัสไปรษณีย์</label>
                        <input type="text" name="zipcode" value="{{ old('zipcode') }}">
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
                        <input type="text" name="phone" value="{{ old('phone') }}">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const ekycCheckCardUrl = "{{ url('/ekyc/check-card') }}";
    </script>

    <script src="{{ asset('js/patient.js') }}"></script>
@endsection
