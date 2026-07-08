<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay" id="sidebar-overlay"></div>

<aside class="admin-sidebar" id="admin-sidebar">
<div class="sidebar-header">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">

<div>
    <img 
        src="{{ asset('public/uploads/logo/logo-kkm.png') }}"
        alt="Logo KKM"
        style="
            width:45px;
            height:45px;
            object-fit:contain;
        "
    >
</div>
        <span>Absensi KKM</span>

    </a>
</div>

    <div class="sidebar-nav">
        <div class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>
        </div>
        
        <div class="nav-item mt-4 mb-2">
            <small class="sidebar-section-label">Manajemen Data</small>
        </div>

        <div class="nav-item">
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Kelola User</span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('admin.qr-code.index') }}" class="nav-link {{ request()->routeIs('admin.qr-code.*') ? 'active' : '' }}">
                <i class="bi bi-qr-code-scan"></i>
                <span>QR Code</span>
            </a>
        </div>
        
        <div class="nav-item">
            <a href="{{ route('admin.attendances.index') }}" class="nav-link {{ request()->routeIs('admin.attendances.index') ? 'active' : '' }}">
                <i class="bi bi-calendar-check-fill"></i>
                <span>Data Absensi</span>
            </a>
        </div>

        <div class="nav-item mt-4 mb-2">
            <small class="sidebar-section-label">Laporan &amp; Pengaturan</small>
        </div>

        <div class="nav-item">
            <a href="{{ route('admin.attendances.export') }}" class="nav-link">
                <i class="bi bi-file-earmark-excel-fill"></i>
                <span>Export Excel</span>
            </a>
        </div>

        <div class="nav-item">
            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear-fill"></i>
                <span>Pengaturan Sistem</span>
            </a>
        </div>

        <div class="nav-item">
            <a href="{{ route('admin.activity-logs.index') }}" class="nav-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                <i class="bi bi-journal-text"></i>
                <span>Log Aktivitas</span>
            </a>
        </div>

        <div class="nav-item mt-4 mb-2">
            <small class="sidebar-section-label">Akun</small>
        </div>

        <div class="nav-item">
            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <i class="bi bi-person-fill"></i>
                <span>Profil</span>
            </a>
        </div>

        <div class="nav-item mt-auto pt-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link text-danger w-100 border-0 bg-transparent text-start">
                    <i class="bi bi-box-arrow-right text-danger"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
