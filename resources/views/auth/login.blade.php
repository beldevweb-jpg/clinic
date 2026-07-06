<style>
    body {
        background: #f4f7fb;
        font-family: "Prompt", sans-serif;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 30px;
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        background: #fff;
        border-radius: 18px;
        padding: 35px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
    }

    .login-header {
        text-align: center;
        margin-bottom: 25px;
    }

    .login-header h2 {
        margin: 0;
        color: #222;
        font-size: 28px;
    }

    .login-header p {
        color: #777;
        margin-top: 6px;
        font-size: 14px;
    }

    .alert-success {
        background: #e8fff1;
        color: #008a39;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .alert-error {
        background: #ffe8e8;
        color: #d60000;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #444;
        font-size: 14px;
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

    .remember {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
        font-size: 14px;
        color: #555;
    }

    .btn-login {
        width: 100%;
        padding: 13px;
        border: none;
        border-radius: 10px;
        background: #2b7cff;
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: .3s;
    }

    .btn-login:hover {
        background: #1767f0;
        transform: translateY(-2px);
    }

    .footer-link {
        text-align: center;
        margin-top: 20px;
        color: #666;
        font-size: 14px;
    }

    .footer-link a {
        color: #2b7cff;
        text-decoration: none;
        font-weight: 600;
    }

    .footer-link a:hover {
        text-decoration: underline;
    }
</style>

<div class="login-wrapper">

    <div class="login-card">

        <div class="login-header">
            <h2>เข้าสู่ระบบ</h2>
            <p>กรุณาเข้าสู่ระบบเพื่อใช้งาน</p>
        </div>

        @if (session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>ชื่อผู้ใช้</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}"
                    placeholder="กรอกชื่อผู้ใช้" required autofocus>
            </div>

            <div class="form-group">
                <label>รหัสผ่าน</label>
                <input type="password" name="password" class="form-control" placeholder="กรอกรหัสผ่าน" required>
            </div>

            <label class="remember">
                <input type="checkbox" name="remember">
                จดจำการเข้าสู่ระบบ
            </label>

            <button type="submit" class="btn-login">
                🔐 เข้าสู่ระบบ
            </button>

        </form>

        <div class="footer-link">
            ยังไม่มีบัญชี?
            <a href="{{ route('register') }}">
                สมัครสมาชิก
            </a>
        </div>

    </div>

</div>
