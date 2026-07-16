<style>
    body {
        background: #f4f7fb;
        font-family: "Prompt", sans-serif;
    }

    .register-wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 30px;
    }

    .register-card {
        width: 100%;
        max-width: 430px;
        background: #fff;
        border-radius: 18px;
        padding: 35px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
    }

    .register-header {
        text-align: center;
        margin-bottom: 25px;
    }

    .register-header h2 {
        margin: 0;
        font-size: 28px;
        color: #222;
    }

    .register-header p {
        color: #777;
        margin-top: 6px;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-size: 14px;
        font-weight: 600;
        color: #444;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #ddd;
        border-radius: 10px;
        font-size: 15px;
        transition: .3s;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #2b7cff;
        box-shadow: 0 0 0 4px rgba(43, 124, 255, .12);
    }

    .btn-submit {
        width: 100%;
        padding: 13px;
        border: none;
        border-radius: 10px;
        background: #2b7cff;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: .3s;
    }

    .btn-submit:hover {
        background: #1767f0;
        transform: translateY(-2px);
    }

    .alert-error {
        background: #ffe8e8;
        color: #d40000;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .login-link {
        text-align: center;
        margin-top: 20px;
        color: #666;
    }

    .login-link a {
        color: #2b7cff;
        text-decoration: none;
        font-weight: 600;
    }

    .login-link a:hover {
        text-decoration: underline;
    }
</style>

<div class="register-wrapper">

    <div class="register-card">

        <div class="register-header">
            <h2>สมัครสมาชิก</h2>
            <p>กรอกข้อมูลเพื่อสร้างบัญชีผู้ใช้งาน</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label>ชื่อ - นามสกุล</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                    placeholder="กรอกชื่อ - นามสกุล" required>
            </div>

            <div class="form-group">
                <label>ชื่อผู้ใช้</label>
                <input type="text" name="username" value="{{ old('username') }}" class="form-control"
                    placeholder="กรอกชื่อผู้ใช้" required>
            </div>

            <div class="form-group">
                <label>รหัสผ่าน</label>
                <input type="password" name="password" class="form-control" placeholder="********" required>
            </div>

            <div class="form-group">
                <label>ยืนยันรหัสผ่าน</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="********"
                    required>
            </div>
            @if (auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager')))
                <div class="form-group">

                    <label>บทบาทผู้ใช้</label>

                    <select name="role" class="form-control">

                        <option value="1">
                            👑 Admin
                        </option>

                        <option value="2">
                            🧑‍💼 Manager
                        </option>

                        <option value="3">
                            👨‍⚕️ Doctor
                        </option>

                        <option value="4">
                            👤 Staff
                        </option>

                    </select>

                </div>
            @endif
            @if (auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager')))

                <div class="form-group">

                    <label>สาขา</label>

                    <select name="branch_id" class="form-control">

                        <option value="">
                            -- ไม่ระบุสาขา --
                        </option>

                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>

                                {{ $branch->name }}

                            </option>
                        @endforeach

                    </select>

                </div>

            @endif
            <button class="btn-submit">
                สมัครสมาชิก
            </button>

            @guest
                <div class="login-link">
                    มีบัญชีแล้ว?
                    <a href="{{ route('login') }}">
                        เข้าสู่ระบบ
                    </a>
                </div>
            @endguest
        </form>
    </div>

</div>
