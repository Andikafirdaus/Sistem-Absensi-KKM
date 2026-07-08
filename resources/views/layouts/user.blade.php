<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Absensi KKM</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- DataTables Bootstrap 5 -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Custom User CSS -->
    <link href="{{ asset('css/user-saas.css') }}" rel="stylesheet">

    @stack('css')
</head>
<body>
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <div class="user-layout">
        <!-- Sidebar -->
        <aside class="user-sidebar" id="user-sidebar">
            <div class="sidebar-header">
                <a href="{{ route('user.dashboard') }}" class="sidebar-brand">
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

            <!-- User Info -->
            <div class="sidebar-user-info">
                <div class="sidebar-user-avatar">
                    @if(Auth::user()->profile_photo_path)
                        <img src="{{ asset('public/uploads/'.Auth::user()->profile_photo_path) }}" alt="Avatar">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
                <div class="sidebar-user-details">
                    <span class="sidebar-user-name">{{ Auth::user()->name }}</span>
 <span class="sidebar-user-role">
    {{ Auth::user()->divisi ?: 'Belum ada divisi' }}
</span>
                </div>
            </div>

            <!-- Nav -->
            <div class="sidebar-nav">
                <div class="nav-item mb-2">
                    <small class="sidebar-section-label">Menu Utama</small>
                </div>

                <div class="nav-item">
                    <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('user.scan') }}" class="nav-link {{ request()->routeIs('user.scan') ? 'active' : '' }}">
                        <i class="bi bi-qr-code-scan"></i>
                        <span>Scan QR Absen</span>
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('user.history') }}" class="nav-link {{ request()->routeIs('user.history') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i>
                        <span>Riwayat Absensi</span>
                    </a>
                </div>

                <div class="nav-item mt-4 mb-2">
                    <small class="sidebar-section-label">Akun</small>
                </div>

                <div class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                        <i class="bi bi-person-fill"></i>
                        <span>Profil Saya</span>
                    </a>
                </div>
            </div>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link text-danger w-100 border-0 bg-transparent text-start" style="padding: 0.7rem 1rem; border-radius: 12px; display: flex; align-items: center; gap: 0.75rem; font-weight: 500; transition: all 0.3s; cursor: pointer;">
                        <i class="bi bi-box-arrow-right" style="font-size: 1.15rem; width: 22px; text-align: center; color: #EF4444;"></i>
                        <span style="color: #EF4444;">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="user-main">
            <!-- Topbar -->
            <header class="user-topbar">
                <div class="topbar-left">
                    <button id="sidebar-toggle" class="sidebar-toggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <h2 class="topbar-title d-none d-md-block">@yield('title', 'Dashboard')</h2>
                </div>

                <div class="topbar-right">
                    <!-- Realtime Clock -->
                    <div id="realtime-clock" class="realtime-clock d-none d-lg-flex">
                        <i class="bi bi-clock"></i> Memuat...
                    </div>

                    <!-- Notification Bell -->
                    <div class="dropdown">
                        <button class="notif-btn" id="notifDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell"></i>
                            <span class="notif-badge d-none" id="notif-badge-count">0</span>
                        </button>
                        <ul class="dropdown-menu notif-dropdown dropdown-menu-end" id="notif-dropdown-menu" aria-labelledby="notifDropdownBtn">
                            <div class="notif-header">
                                <h6>Notifikasi</h6>
                                <button class="btn btn-link btn-sm p-0 text-primary" id="mark-all-read" style="font-size: 0.8rem; text-decoration: none;">Tandai semua dibaca</button>
                            </div>
                            <div id="notif-list">
                                <div class="notif-empty">
                                    <i class="bi bi-bell-slash fs-3 d-block mb-2 text-muted"></i>
                                    Tidak ada notifikasi
                                </div>
                            </div>
                        </ul>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="dropdown profile-dropdown">
                        <button class="dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-info d-none d-sm-flex flex-column align-items-end me-1">
                                <span class="profile-name">{{ explode(' ', Auth::user()->name)[0] }}</span>
                            </div>
                           @if(Auth::user()->profile_photo_path)

    <img 
        src="{{ asset('public/uploads/'.Auth::user()->profile_photo_path) }}" 
        alt="Profile"
        class="profile-avatar"
    >

@else

    <img 
        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2563EB&color=fff"
        alt="Profile"
        class="profile-avatar"
    >

@endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="profileDropdown">
                            <li><h6 class="dropdown-header">Akun Saya</h6></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i> Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="user-content">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="user-footer">
                &copy; {{ date('Y') }} Sistem Absensi KKM. All rights reserved.
            </footer>
        </main>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- User Saas JS -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // ---- Realtime Clock ----
        const clockEl = document.getElementById('realtime-clock');
        if (clockEl) {
            function updateClock() {
                const now = new Date();
                const opts = { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
                clockEl.innerHTML = `<i class="bi bi-clock"></i> ${now.toLocaleDateString('id-ID', opts)}`;
            }
            updateClock();
            setInterval(updateClock, 1000);
        }

        // ---- Sidebar Toggle ----
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const userSidebar   = document.getElementById('user-sidebar');
        const overlay       = document.getElementById('sidebar-overlay');

        if (sidebarToggle && userSidebar) {
            sidebarToggle.addEventListener('click', function () {
                if (window.innerWidth >= 992) {
                    userSidebar.classList.toggle('collapsed');
                    const main = document.querySelector('.user-main');
                    if (main) {
                        main.style.marginLeft = userSidebar.classList.contains('collapsed') ? '0' : '260px';
                    }
                } else {
                    userSidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                }
            });
        }

        if (overlay && userSidebar) {
            overlay.addEventListener('click', function () {
                userSidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }

        // ---- Notifications ----
        let notifications = JSON.parse(localStorage.getItem('user_notifications_{{ Auth::id() }}') || '[]');

        function renderNotifications() {
            const list = document.getElementById('notif-list');
            const badge = document.getElementById('notif-badge-count');
            const unread = notifications.filter(n => !n.read).length;

            if (badge) {
                if (unread > 0) {
                    badge.textContent = unread > 9 ? '9+' : unread;
                    badge.classList.remove('d-none');
                } else {
                    badge.classList.add('d-none');
                }
            }

            if (!list) return;

            if (notifications.length === 0) {
                list.innerHTML = `<div class="notif-empty"><i class="bi bi-bell-slash fs-3 d-block mb-2 text-muted"></i>Tidak ada notifikasi</div>`;
                return;
            }

            let html = '';
            notifications.slice(0, 10).forEach(function (n, idx) {
                const iconClass = n.type === 'success' ? 'stat-icon-success' : (n.type === 'warning' ? 'stat-icon-warning' : 'stat-icon-danger');
                const iconName  = n.type === 'success' ? 'bi-check-circle-fill' : (n.type === 'warning' ? 'bi-exclamation-triangle-fill' : 'bi-x-circle-fill');
                html += `
                <div class="notif-item ${n.read ? '' : 'unread'}" data-idx="${idx}">
                    <div class="notif-item-icon ${iconClass}">
                        <i class="bi ${iconName}"></i>
                    </div>
                    <div class="notif-item-text">
                        <p>${n.message}</p>
                        <span class="notif-item-time">${n.time}</span>
                    </div>
                    ${!n.read ? '<div class="notif-unread-dot"></div>' : ''}
                </div>`;
            });
            list.innerHTML = html;

            // Mark as read on click
            list.querySelectorAll('.notif-item').forEach(function (item) {
                item.addEventListener('click', function () {
                    const idx = parseInt(this.getAttribute('data-idx'));
                    notifications[idx].read = true;
                    saveNotifications();
                    renderNotifications();
                });
            });
        }

        function saveNotifications() {
            localStorage.setItem('user_notifications_{{ Auth::id() }}', JSON.stringify(notifications));
        }

        function addNotification(message, type) {
            const now = new Date();
            const timeStr = now.toLocaleString('id-ID', { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' });
            notifications.unshift({ message: message, type: type, time: timeStr, read: false });
            if (notifications.length > 20) notifications = notifications.slice(0, 20);
            saveNotifications();
            renderNotifications();
        }

        // Mark All Read
        const markAllBtn = document.getElementById('mark-all-read');
        if (markAllBtn) {
            markAllBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                notifications.forEach(function (n) { n.read = true; });
                saveNotifications();
                renderNotifications();
            });
        }

        // Expose globally so scan page can use it
        window.addUserNotification = addNotification;

        // Initial render
        renderNotifications();

        // Check today's attendance status and add notification if not yet checked in
        @if(!isset($attendanceToday) || !$attendanceToday)
        const todayKey = 'notif_remind_{{ Auth::id() }}_' + new Date().toISOString().slice(0,10);
        if (!localStorage.getItem(todayKey)) {
            setTimeout(function() {
                addNotification('⏰ Anda belum melakukan absen hari ini. Segera scan QR!', 'warning');
                localStorage.setItem(todayKey, '1');
            }, 1500);
        }
        @endif

        // Notif jika sudah absen hari ini
        @if(isset($attendanceToday) && $attendanceToday)
        const absenKey = 'notif_absen_{{ Auth::id() }}_' + new Date().toISOString().slice(0,10);
        if (!localStorage.getItem(absenKey)) {
            @php $s = strtolower($attendanceToday->status ?? ''); $label = $s === 'present' ? 'Hadir' : ($s === 'late' ? 'Terlambat' : 'Alpha'); @endphp
            setTimeout(function() {
                addNotification('✅ Absen hari ini sudah tercatat — {{ $label }} pukul {{ substr($attendanceToday->check_in, 0, 5) }}', 'success');
                localStorage.setItem(absenKey, '1');
            }, 1500);
        }
        @endif

        // Session alerts
        @if(session('success'))
        addNotification('✅ {{ session("success") }}', 'success');
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ session("success") }}', timer: 3000, showConfirmButton: false });
        @endif

        @if(session('error'))
        addNotification('❌ {{ session("error") }}', 'danger');
        Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session("error") }}' });
        @endif

    });
    </script>

    @stack('scripts')
</body>
</html>
