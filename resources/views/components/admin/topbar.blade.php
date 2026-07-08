<header class="admin-topbar">
    <div class="topbar-left">
        <button id="sidebar-toggle" class="sidebar-toggle">
            <i class="bi bi-list"></i>
        </button>
        <h2 class="topbar-title d-none d-md-block">@yield('title', 'Admin Dashboard')</h2>
    </div>

    <div class="topbar-right">
        <!-- Realtime Clock -->
        <div id="realtime-clock" class="realtime-clock d-none d-lg-flex">
            <i class="bi bi-clock"></i> Memuat...
        </div>

        <!-- Notification Bell -->
        <div class="dropdown">
            <button class="topbar-action" id="adminNotifBtn" data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; border: none; position: relative; padding: 0.4rem; border-radius: 8px; transition: all 0.3s;">
                <i class="bi bi-bell"></i>
                <span class="topbar-badge d-none" id="admin-notif-badge">0</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end p-0 shadow" id="admin-notif-menu" style="width: 340px; max-height: 420px; overflow-y: auto; border-radius: 16px; border: 1px solid #E2E8F0;" aria-labelledby="adminNotifBtn">
                <div style="padding: 0.9rem 1.25rem; border-bottom: 1px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; background: white; z-index: 1; border-radius: 16px 16px 0 0;">
                    <h6 style="margin: 0; font-weight: 700; font-size: 0.95rem;">Notifikasi</h6>
                    <button id="admin-mark-all-read" style="background: none; border: none; color: #2563EB; font-size: 0.8rem; font-weight: 500; cursor: pointer; padding: 0;">Tandai semua dibaca</button>
                </div>
                <div id="admin-notif-list">
                    <div style="text-align: center; padding: 2rem; color: #64748B; font-size: 0.875rem;">
                        <i class="bi bi-bell-slash" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                        Tidak ada notifikasi
                    </div>
                </div>
            </ul>
        </div>

        <!-- Profile Dropdown -->
        <div class="dropdown profile-dropdown">
            <button class="dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-info d-none d-sm-flex">
                    <span class="profile-name">{{ Auth::user()->name }}</span>
                    <span class="profile-role">Administrator</span>
                </div>
                <!-- Generate avatar from name -->
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=2563EB&color=fff" alt="Profile" class="profile-avatar">
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="profileDropdown">
                <li><h6 class="dropdown-header">Akun Saya</h6></li>
                <li>
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                        <i class="bi bi-person me-2"></i> Profil
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                        <i class="bi bi-gear me-2"></i> Pengaturan
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

    // ---- Admin Notifications (localStorage based) ----
    const NOTIF_KEY = 'admin_notifications_{{ Auth::id() }}';
    let notifications = JSON.parse(localStorage.getItem(NOTIF_KEY) || '[]');

    function renderAdminNotifications() {
        const list  = document.getElementById('admin-notif-list');
        const badge = document.getElementById('admin-notif-badge');
        if (!list || !badge) return;

        const unread = notifications.filter(n => !n.read).length;

        if (unread > 0) {
            badge.textContent = unread > 9 ? '9+' : unread;
            badge.classList.remove('d-none');
        } else {
            badge.classList.add('d-none');
        }

        if (notifications.length === 0) {
            list.innerHTML = `<div style="text-align:center; padding: 2rem; color: #64748B; font-size: 0.875rem;"><i class="bi bi-bell-slash" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>Tidak ada notifikasi</div>`;
            return;
        }

        const iconMap = {
            success: { cls: 'rgba(34,197,94,0.1)', color: '#22C55E', icon: 'bi-check-circle-fill' },
            warning: { cls: 'rgba(245,158,11,0.1)',  color: '#F59E0B', icon: 'bi-exclamation-triangle-fill' },
            danger:  { cls: 'rgba(239,68,68,0.1)',   color: '#EF4444', icon: 'bi-x-circle-fill' },
            info:    { cls: 'rgba(37,99,235,0.1)',   color: '#2563EB', icon: 'bi-info-circle-fill' },
        };

        let html = '';
        notifications.slice(0, 10).forEach(function (n, idx) {
            const im = iconMap[n.type] || iconMap.info;
            html += `
            <div class="notif-item-row ${n.read ? '' : 'unread-row'}" data-idx="${idx}" style="
                display: flex; align-items: flex-start; gap: 0.75rem;
                padding: 0.85rem 1.25rem; cursor: pointer;
                border-bottom: 1px solid rgba(226,232,240,0.5);
                background: ${n.read ? 'transparent' : 'rgba(37,99,235,0.03)'};
                transition: background 0.2s;">
                <div style="width: 36px; height: 36px; border-radius: 50%; background: ${im.cls}; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="bi ${im.icon}" style="color: ${im.color}; font-size: 0.9rem;"></i>
                </div>
                <div style="flex-grow: 1; min-width: 0;">
                    <p style="margin: 0 0 0.2rem; font-size: 0.83rem; line-height: 1.4; color: #0F172A;">${n.message}</p>
                    <span style="font-size: 0.75rem; color: #64748B;">${n.time}</span>
                </div>
                ${!n.read ? '<div style="width: 8px; height: 8px; border-radius: 50%; background: #2563EB; flex-shrink: 0; margin-top: 5px;"></div>' : ''}
            </div>`;
        });
        list.innerHTML = html;

        list.querySelectorAll('.notif-item-row').forEach(function (row) {
            row.addEventListener('mouseenter', function () {
                this.style.background = '#F8FAFC';
            });
            row.addEventListener('mouseleave', function () {
                const idx = parseInt(this.getAttribute('data-idx'));
                this.style.background = notifications[idx] && !notifications[idx].read ? 'rgba(37,99,235,0.03)' : 'transparent';
            });
            row.addEventListener('click', function () {
                const idx = parseInt(this.getAttribute('data-idx'));
                if (notifications[idx]) {
                    notifications[idx].read = true;
                    saveAdminNotifications();
                    renderAdminNotifications();
                }
            });
        });
    }

    function saveAdminNotifications() {
        localStorage.setItem(NOTIF_KEY, JSON.stringify(notifications));
    }

    function addAdminNotification(message, type) {
        const now = new Date();
        const timeStr = now.toLocaleString('id-ID', { day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit' });
        notifications.unshift({ message, type, time: timeStr, read: false });
        if (notifications.length > 20) notifications = notifications.slice(0, 20);
        saveAdminNotifications();
        renderAdminNotifications();
    }

    // Mark all read
    const markAllBtn = document.getElementById('admin-mark-all-read');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            notifications.forEach(n => n.read = true);
            saveAdminNotifications();
            renderAdminNotifications();
        });
    }

    // Expose globally
    window.addAdminNotification = addAdminNotification;

    // Add daily notifications based on data
    const todayKey = 'admin_notif_daily_{{ Auth::id() }}_' + new Date().toISOString().slice(0, 10);
    if (!localStorage.getItem(todayKey)) {
        localStorage.setItem(todayKey, '1');
        // Delayed so page loads first
        setTimeout(function () {
            // We'll add notifications based on PHP data passed from controller
            @php
                $today = \Carbon\Carbon::today();
                $presentCount = \App\Models\Attendance::whereDate('date', $today)->whereIn('status', ['Present', 'Late'])->count();
                $lateCount = \App\Models\Attendance::whereDate('date', $today)->where('status', 'Late')->count();
                $totalUsersForNotif = \App\Models\User::where('role', 'user')->count();
                $absentCount = max(0, $totalUsersForNotif - $presentCount);
                $activeQrCount = \App\Models\QrToken::where('is_active', true)->where('expires_at', '>', \Carbon\Carbon::now())->count();
            @endphp

            @if($presentCount > 0)
            addAdminNotification('📊 Hari ini {{ $presentCount }} peserta sudah hadir ({{ $lateCount }} terlambat).', 'info');
            @endif

            @if($absentCount > 0)
            addAdminNotification('⚠️ {{ $absentCount }} peserta belum hadir hari ini.', 'warning');
            @endif

            @if($activeQrCount == 0)
            addAdminNotification('🔑 Tidak ada QR Code aktif. Segera generate QR baru.', 'danger');
            @else
            addAdminNotification('✅ {{ $activeQrCount }} QR Code aktif tersedia untuk absensi.', 'success');
            @endif
        }, 1200);
    }

    // Session alerts also as notifications
    @if(session('success'))
    addAdminNotification('✅ {{ session("success") }}', 'success');
    @endif
    @if(session('error'))
    addAdminNotification('❌ {{ session("error") }}', 'danger');
    @endif

    // Initial render
    renderAdminNotifications();
});
</script>
