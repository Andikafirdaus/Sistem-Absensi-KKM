@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
{{-- Welcome Banner --}}
<div class="user-welcome">
    <div class="position-relative" style="z-index: 1;">
        <h2 class="mb-1">Selamat Datang, {{ explode(' ', Auth::user()->name)[0] }} </h2>
        <p>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            @if(Auth::user()->divisi)
                &bull; {{ Auth::user()->divisi }}
            @endif
        </p>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    {{-- Status Hari Ini --}}
    <div class="col-6 col-md-3">
        <div class="saas-card">
            <div class="saas-card-body">
                <div class="stat-card">
                    <div class="stat-icon-box {{ $attendanceToday ? ($attendanceToday->status == 'Late' || strtolower($attendanceToday->status) == 'late' ? 'stat-icon-warning' : 'stat-icon-success') : 'stat-icon-primary' }}">
                        <i class="bi {{ $attendanceToday ? 'bi-check-circle-fill' : 'bi-clock-fill' }}"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Status Hari Ini</div>
                        @if($attendanceToday)
                            @php $s = strtolower($attendanceToday->status); @endphp
                            <div class="stat-value" style="font-size: 1rem; line-height: 1.3;">
                                @if($s === 'present')
                                    <span class="text-success fw-bold">Hadir</span>
                                @elseif($s === 'late')
                                    <span class="text-warning fw-bold">Terlambat</span>
                                @else
                                    <span class="text-danger fw-bold">Alpha</span>
                                @endif
                            </div>
                            <div class="stat-meta">
                                <i class="bi bi-clock text-primary me-1"></i>Pukul {{ substr($attendanceToday->check_in, 0, 5) }}
                            </div>
                        @else
                            <div class="stat-value" style="font-size: 1rem;">Belum Absen</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Hadir Bulan Ini --}}
    <div class="col-6 col-md-3">
        <div class="saas-card">
            <div class="saas-card-body">
                <div class="stat-card">
                    <div class="stat-icon-box stat-icon-success">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Hadir Bulan Ini</div>
                        <div class="stat-value">{{ $totalPresent }}</div>
                        <div class="stat-meta">Hari</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Terlambat --}}
    <div class="col-6 col-md-3">
        <div class="saas-card">
            <div class="saas-card-body">
                <div class="stat-card">
                    <div class="stat-icon-box stat-icon-warning">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Terlambat</div>
                        <div class="stat-value">{{ $totalLate }}</div>
                        <div class="stat-meta">Kali bulan ini</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Persentase --}}
    <div class="col-6 col-md-3">
        <div class="saas-card">
            <div class="saas-card-body">
                <div class="stat-card">
                    <div class="stat-icon-box stat-icon-info">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-title">Kehadiran</div>
                        <div class="stat-value">{{ $persentase }}%</div>
                        <div class="mt-1" style="height: 4px; background: #E2E8F0; border-radius: 4px;">
                            <div style="width: {{ $persentase }}%; height: 100%; border-radius: 4px; background: {{ $persentase < 50 ? '#EF4444' : ($persentase < 80 ? '#F59E0B' : '#22C55E') }};"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="saas-card mb-4" style="height:auto;">
    <div class="saas-card-header">
        <h5><i class="bi bi-lightning-fill text-warning me-2"></i>Aksi Cepat</h5>
    </div>
<div class="saas-card-body" style="padding-bottom:25px;">
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <a href="{{ route('user.scan') }}" class="quick-action-card">
                    <div class="icon-box" style="background: rgba(37,99,235,0.1);">
                        <i class="bi bi-qr-code-scan" style="color: #2563EB;"></i>
                    </div>
                    <div>
                        <div class="card-label">Scan QR Absen</div>
                        <p class="card-desc">Absen via kamera — satu kali per hari</p>
                    </div>
                    <i class="bi bi-chevron-right ms-auto" style="color: #94A3B8;"></i>
                </a>
            </div>
            <div class="col-12 col-md-4">
                <a href="{{ route('user.history') }}" class="quick-action-card">
                    <div class="icon-box" style="background: rgba(34,197,94,0.1);">
                        <i class="bi bi-clock-history" style="color: #22C55E;"></i>
                    </div>
                    <div>
                        <div class="card-label">Lihat Riwayat</div>
                        <p class="card-desc">Rekap absensi lengkap</p>
                    </div>
                    <i class="bi bi-chevron-right ms-auto" style="color: #94A3B8;"></i>
                </a>
            </div>
            <div class="col-12 col-md-4">
                <a href="{{ route('profile.edit') }}" class="quick-action-card">
                    <div class="icon-box" style="background: rgba(99,102,241,0.1);">
                        <i class="bi bi-person-lines-fill" style="color: #6366F1;"></i>
                    </div>
                    <div>
                        <div class="card-label">Edit Profil</div>
                        <p class="card-desc">Perbarui data diri</p>
                    </div>
                    <i class="bi bi-chevron-right ms-auto" style="color: #94A3B8;"></i>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Banner absen --}}
@if(!$attendanceToday)
<div class="saas-card" style="border: 2px solid rgba(37,99,235,0.2);">
    <div class="saas-card-body">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon-box stat-icon-primary" style="width: 52px; height: 52px;">
                    <i class="bi bi-bell-fill" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <div class="fw-bold" style="font-size: 1rem; color: #0F172A;">Anda belum absen hari ini!</div>
                    <div style="font-size: 0.85rem; color: #64748B;">Scan QR Code untuk melakukan absen. Hanya <strong>satu kali</strong> per hari.</div>
                </div>
            </div>
            <a href="{{ route('user.scan') }}" class="btn btn-primary px-4" style="border-radius: 50px; font-weight: 600; font-size: 0.875rem;">
                <i class="bi bi-qr-code-scan me-2"></i>Scan Sekarang
            </a>
        </div>
    </div>
</div>
@elseif($attendanceToday)
{{-- Sudah absen --}}
@php $s = strtolower($attendanceToday->status); @endphp
<div class="saas-card mb-4" 
     style="
        border: 2px solid {{ $s === 'late' ? 'rgba(245,158,11,0.25)' : 'rgba(34,197,94,0.25)' }};
        height:auto;
     "
    <div class="saas-card-body">
        <div class="d-flex align-items-center gap-3">
            <div class="stat-icon-box {{ $s === 'late' ? 'stat-icon-warning' : 'stat-icon-success' }}" style="width: 52px; height: 52px;">
                <i class="bi bi-check-circle-fill" style="font-size: 1.5rem;"></i>
            </div>
            <div>
                <div class="fw-bold" style="font-size: 1rem; color: #0F172A;">
                    Absen hari ini sudah tercatat —
                    @if($s === 'present') <span class="text-success">Hadir</span>
                    @elseif($s === 'late') <span class="text-warning">Terlambat</span>
                    @else <span class="text-danger">Alpha</span>
                    @endif
                </div>
                <div style="font-size: 0.85rem; color: #64748B;">
                    Pukul {{ substr($attendanceToday->check_in, 0, 5) }} WIB. Sampai jumpa besok!
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
