@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Greeting Section -->
<div class="dashboard-greeting">
    <h1 class="greeting-title">Selamat Datang, {{ Auth::user()->name }}</h1>
    <p class="greeting-subtitle">Semoga aktivitas hari ini berjalan lancar. Berikut adalah ringkasan sistem Anda.</p>
</div>

<!-- Quick Actions -->
<div class="row g-4 mb-4">
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.qr-code.index') }}" class="quick-action-btn">
            <i class="bi bi-qr-code"></i>
            <span>Generate QR</span>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.users.create') }}" class="quick-action-btn">
            <i class="bi bi-person-plus"></i>
            <span>Tambah User</span>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.attendances.export') }}" class="quick-action-btn">
            <i class="bi bi-file-earmark-excel"></i>
            <span>Export Excel</span>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('admin.attendances.index') }}" class="quick-action-btn">
            <i class="bi bi-card-list"></i>
            <span>Lihat Rekap</span>
        </a>
    </div>
</div>

<!-- Statistic Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4 col-xl-2">
        <div class="saas-card">
            <div class="saas-card-body">
                <div class="stat-card">
                    <div class="stat-icon-box stat-icon-primary">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Total User</div>
                        <div class="stat-value">{{ $totalUsers }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 col-xl-2">
        <div class="saas-card">
            <div class="saas-card-body">
                <div class="stat-card">
                    <div class="stat-icon-box stat-icon-success">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Hadir Hari Ini</div>
                        <div class="stat-value">{{ $totalPresentToday }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 col-xl-2">
        <div class="saas-card">
            <div class="saas-card-body">
                <div class="stat-card">
                    <div class="stat-icon-box stat-icon-warning">
                        <i class="bi bi-clock-fill"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Terlambat</div>
                        <div class="stat-value">{{ $totalLateToday }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 col-xl-2">
        <div class="saas-card">
            <div class="saas-card-body">
                <div class="stat-card">
                    <div class="stat-icon-box stat-icon-danger">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Belum Hadir</div>
                        <div class="stat-value">{{ $totalAbsentToday }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 col-xl-2">
        <div class="saas-card">
            <div class="saas-card-body">
                <div class="stat-card">
                    <div class="stat-icon-box stat-icon-primary">
                        <i class="bi bi-qr-code-scan"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">QR Aktif</div>
                        <div class="stat-value">{{ $activeQr }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 col-xl-2">
        <div class="saas-card">
            <div class="saas-card-body">
                <div class="stat-card">
                    <div class="stat-icon-box stat-icon-success">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Kehadiran</div>
                        <div class="stat-value">{{ $attendancePercentage }}%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Recent Activity -->
<div class="row g-4 mb-4">
    <!-- Chart -->
    <div class="col-xl-8">
        <div class="saas-card">
            <div class="saas-card-header">
                <h5 class="chart-title">Absensi 7 Hari Terakhir</h5>
            </div>
            <div class="saas-card-body">
                <div style="height: 300px;">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="col-xl-4">
        <div class="saas-card">
            <div class="saas-card-header">
                <h5 class="chart-title">Aktivitas Terbaru</h5>
            </div>
            <div class="saas-card-body">
                <ul class="activity-list">
                    @forelse($recentActivities as $activity)
                        <li class="activity-item">
                            <div class="activity-icon">
                                @if($activity->action == 'login')
                                    <i class="bi bi-box-arrow-in-right"></i>
                                @elseif($activity->action == 'generate_qr')
                                    <i class="bi bi-qr-code"></i>
                                @elseif(str_contains(strtolower($activity->action), 'update'))
                                    <i class="bi bi-pencil"></i>
                                @else
                                    <i class="bi bi-circle"></i>
                                @endif
                            </div>
                            <div class="activity-content">
                                <p><strong>{{ $activity->user->name ?? 'System' }}</strong> {{ $activity->description }}</p>
                                <span class="activity-time">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                        </li>
                    @empty
                        <li class="activity-item text-muted">Belum ada aktivitas.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Recent Attendances Table -->
<div class="row g-4">
    <div class="col-12">
        <div class="saas-card">
            <div class="saas-card-header">
                <h5 class="chart-title">Absensi Terbaru</h5>
            </div>
            <div class="saas-card-body">
                <div class="table-responsive">
                    <table class="table saas-table w-100">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Divisi</th>
                                <th>Tanggal</th>
                                <th>Jam Absen</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAttendances as $att)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($att->user->name) }}&background=2563EB&color=fff" class="rounded-circle" width="32" height="32" alt="Avatar">
                                            <span class="fw-medium">{{ $att->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted" style="font-size: 0.85rem;">{{ $att->user->divisi ?: '-' }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($att->date)->translatedFormat('d M Y') }}</td>
                                    <td>
                                        @if($att->check_in)
                                            <span class="fw-medium text-primary"><i class="bi bi-clock me-1"></i>{{ substr($att->check_in, 0, 5) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php $s = strtolower($att->status); @endphp
                                        @if($s === 'present')
                                            <span class="badge badge-saas badge-success-soft">Hadir</span>
                                        @elseif($s === 'late')
                                            <span class="badge badge-saas badge-warning-soft">Terlambat</span>
                                        @elseif($s === 'absent')
                                            <span class="badge badge-saas badge-danger-soft">Alpha</span>
                                        @else
                                            <span class="badge badge-saas badge-primary-soft">{{ ucfirst($att->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada data absensi hari ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('attendanceChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData['labels'] ?? []) !!},
                datasets: [
                    {
                        label: 'Hadir',
                        data: {!! json_encode($chartData['present'] ?? []) !!},
                        backgroundColor: '#22C55E',
                        borderRadius: 6,
                        barPercentage: 0.6
                    },
                    {
                        label: 'Terlambat',
                        data: {!! json_encode($chartData['late'] ?? []) !!},
                        backgroundColor: '#F59E0B',
                        borderRadius: 6,
                        barPercentage: 0.6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                family: "'Poppins', sans-serif",
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0F172A',
                        titleFont: { family: "'Poppins', sans-serif", size: 13 },
                        bodyFont: { family: "'Poppins', sans-serif", size: 12 },
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { family: "'Poppins', sans-serif" } },
                        grid: { borderDash: [4, 4], color: '#E2E8F0' },
                        border: { display: false }
                    },
                    x: {
                        ticks: { font: { family: "'Poppins', sans-serif" } },
                        grid: { display: false },
                        border: { display: false }
                    }
                }
            }
        });
    }
});
</script>
@endpush
