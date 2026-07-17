<header class="topbar">

    <div class="logo">
        🌿
        <div>
            <strong>e-KYE Smart Card Reader</strong>
            <small>
                {{ auth()->user()->branch?->name ?? '-' }}
            </small>
        </div>
    </div>

    <nav class="menu">
        <a href="{{ route('dashboards.index') }}" class="{{ request()->routeIs('dashboards.index') ? 'active' : '' }}">
            หน้าแรก
        </a>
        @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
            <a href="{{ route('user.index') }}" @class(['active' => request()->routeIs('user.index')])>
                ผู้ใช้งาน
            </a>
        @endif
        <a href="{{ route('patient.index') }}" class="{{ request()->routeIs('patient.index') ? 'active' : '' }}">
            ผู้ป่วย
        </a>
        @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
            <a href="{{ route('medics.index') }}" class="{{ request()->routeIs('medics.index') ? 'active' : '' }}">
                แพทย์
            </a>
        @endif

        <a href="{{ route('documents.index') }}" class="{{ request()->routeIs('documents.index') ? 'active' : '' }}">
            เอกสาร
        </a>
        @if (auth()->user()->hasRole('admin'))
            <a href="{{ route('branchs.index') }}" class="{{ request()->routeIs('branchs.index') ? 'active' : '' }}">
                จัดการสาขา
            </a>

            <a href="{{ route('audit.index') }}" class="{{ request()->routeIs('audit.index') ? 'active' : '' }}">
                ประวัติการใช้งาน
            </a>
        @endif
    </nav>

    <div class="profile">

        <button class="profile-btn" id="profileBtn">
            <div class="avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div class="profile-info">
                <strong>{{ auth()->user()->name }}</strong>

                <small>
                    {{ auth()->user()->role == 1 ? 'Administrator' : 'User' }}
                </small>
            </div>

            ▼
        </button>

        <div class="dropdown" id="profileDropdown">

            <a href="{{ route('profile.edit') }}">
                👤 โปรไฟล์
            </a>
            {{-- <a href="{{ route('setting.index') }}">⚙ ตั้งค่า</a> --}}
            <hr>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    🚪 ออกจากระบบ
                </button>
            </form>

        </div>

    </div>

</header>

<style>
    .menu a {
        padding: 8px 12px;
        text-decoration: none;
        color: #333;
        border-radius: 6px;
    }

    .menu a.active {
        background: #2563eb;
        color: white;
        font-weight: bold;
    }

    .topbar {
        height: 70px;
        background: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 30px;
        border-bottom: 1px solid #e5e7eb;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logo strong {
        display: block;
        font-size: 17px;
    }

    .logo small {
        color: #6b7280;
    }

    .menu {
        display: flex;
        gap: 28px;
    }

    .menu a {
        color: #374151;
        text-decoration: none;
        font-weight: 500;
        transition: .2s;
    }

    .menu a:hover {
        color: #2563eb;
    }

    .profile {
        position: relative;
        padding-bottom: 10px;
    }

    .profile-btn {

        background: none;
        border: none;

        display: flex;
        align-items: center;
        gap: 12px;

        cursor: pointer;
    }

    .avatar {

        width: 42px;
        height: 42px;

        border-radius: 50%;

        background: #4f46e5;
        color: #fff;

        display: flex;
        justify-content: center;
        align-items: center;

        font-weight: bold;

    }

    .profile-info {

        display: flex;
        flex-direction: column;
        align-items: flex-start;

    }

    .profile-info small {
        color: #9ca3af;
    }

    .dropdown {
        position: absolute;
        right: 0;
        top: calc(100% + 10px);

        width: 220px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .12);

        opacity: 0;
        visibility: hidden;
        transform: translateY(-8px);
        transition: .2s;

        overflow: hidden;
    }

    .dropdown.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .dropdown a,
    .dropdown button {

        width: 100%;

        padding: 14px 18px;

        background: none;
        border: none;

        text-align: left;

        cursor: pointer;

        text-decoration: none;

        color: #374151;

        font-size: 14px;

    }

    .dropdown a:hover,
    .dropdown button:hover {

        background: #f3f4f6;

    }

    .dropdown hr {

        margin: 0;
        border: none;
        border-top: 1px solid #eee;

    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const btn = document.getElementById('profileBtn');
        const dropdown = document.getElementById('profileDropdown');

        if (!btn || !dropdown) return;

        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('show');
        });

        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

    });
</script>
