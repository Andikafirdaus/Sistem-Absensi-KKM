@extends('layouts.user')

@section('title', 'Scan QR Absen')

@section('content')
<div class="scan-container">

    {{-- Header Card --}}
    <div class="scan-card mb-4">
        <div class="scan-header">
            <div class="mb-3">
                <i class="bi bi-qr-code-scan" style="font-size: 2.5rem; opacity: 0.9;"></i>
            </div>
            <h4>Scan QR Code</h4>
            <p>Arahkan kamera ke QR Code untuk melakukan absen &bull; Satu kali per hari</p>
        </div>

        <div class="scan-body">
            {{-- Jika sudah absen hari ini --}}
            @if(isset($attendanceToday) && $attendanceToday)
                @php $s = strtolower($attendanceToday->status); @endphp
                <div class="text-center p-4" style="background: {{ $s === 'late' ? 'rgba(245,158,11,0.07)' : 'rgba(34,197,94,0.07)' }}; border-radius: 12px; border: 1.5px solid {{ $s === 'late' ? 'rgba(245,158,11,0.3)' : 'rgba(34,197,94,0.3)' }};">
                    <i class="bi bi-check-circle-fill {{ $s === 'late' ? 'text-warning' : 'text-success' }}" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 fw-bold mb-1">Absen Sudah Tercatat!</h5>
                    <p class="mb-1" style="font-size: 0.9rem; color: #475569;">
                        Status: <strong>{{ $s === 'present' ? 'Hadir' : ($s === 'late' ? 'Terlambat' : 'Alpha') }}</strong>
                        &bull; Pukul {{ substr($attendanceToday->check_in, 0, 5) }} WIB
                    </p>
                    <p class="mb-3" style="font-size: 0.85rem; color: #64748B;">Anda sudah melakukan absen hari ini. Sampai jumpa besok!</p>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-primary px-4" style="border-radius: 50px; font-weight: 600; font-size: 0.875rem;">
                        <i class="bi bi-house me-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            @else
                {{-- Camera Scanner --}}
                <div id="qr-reader"></div>

                {{-- Status Area --}}
                <div class="scan-status-area mt-3" id="scan-status-area" style="display: none;">
                    <div class="scan-status-icon" id="scan-status-icon"></div>
                    <div id="scan-status-text" style="font-size: 0.9rem; color: #64748B;"></div>
                </div>

                {{-- Info --}}
                <div class="mt-4 p-3 rounded-3 d-flex align-items-start gap-2" style="background: rgba(37,99,235,0.06); border: 1px solid rgba(37,99,235,0.15);">
                    <i class="bi bi-info-circle-fill text-primary mt-1" style="flex-shrink: 0;"></i>
                    <div style="font-size: 0.82rem; color: #475569; line-height: 1.5;">
                        <strong class="text-primary">Petunjuk:</strong> Pastikan QR Code berada dalam area kotak scan dan pencahayaan cukup.
                        Absen hanya dapat dilakukan <strong>satu kali per hari</strong>.
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Back button --}}
    <a href="{{ route('user.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none" style="color: #64748B; font-size: 0.875rem; font-weight: 500;">
        <i class="bi bi-arrow-left-circle"></i> Kembali ke Dashboard
    </a>
</div>
@endsection

@push('css')
<style>
#qr-reader__dashboard_section_swaplink,
#qr-reader__filescan_input,
#html5-qrcode-anchor-scan-type-change,
[id*="html5-qrcode-anchor-scan-type-change"],
#qr-reader__header_message {
    display: none !important;
}
#qr-reader { border: none !important; width: 100% !important; }
#qr-reader__scan_region { background: #0F172A; border-radius: 12px; overflow: hidden; }
#qr-reader__scan_region img { display: none !important; }
#qr-reader__scan_region video { width: 100% !important; border-radius: 12px; display: block; }
#qr-reader__dashboard_section { padding: 0.75rem 0 0 !important; }
#qr-reader__dashboard_section_csr button {
    background: #2563EB !important; color: white !important; border: none !important;
    border-radius: 50px !important; padding: 0.5rem 1.5rem !important;
    font-weight: 600 !important; font-size: 0.875rem !important; cursor: pointer !important;
    font-family: 'Poppins', sans-serif !important; transition: all 0.3s !important;
}
#qr-reader__dashboard_section_csr button:hover { background: #1D4ED8 !important; }
#qr-reader__status_span { font-size: 0.8rem !important; color: #64748B !important; font-family: 'Poppins', sans-serif !important; }
</style>
@endpush

@push('scripts')
@if(!isset($attendanceToday) || !$attendanceToday)
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let scanning = true;
    const statusArea = document.getElementById('scan-status-area');
    const statusIcon = document.getElementById('scan-status-icon');
    const statusText = document.getElementById('scan-status-text');

    function showStatus(icon, text) {
        statusArea.style.display = 'block';
        statusIcon.innerHTML = icon;
        statusText.innerHTML = text;
    }

    function onScanSuccess(decodedText) {
        if (!scanning) return;
        scanning = false;

        html5QrCode.stop().then(() => {
            document.getElementById('qr-reader').innerHTML =
                '<div style="height:180px; background:#F0FDF4; border-radius:12px; display:flex; align-items:center; justify-content:center;"><i class="bi bi-check-circle-fill" style="font-size:3rem; color:#22C55E;"></i></div>';
        }).catch(() => {});

        showStatus(
            '<div class="spinner-border text-primary" role="status" style="width: 2rem; height: 2rem;"><span class="visually-hidden">Memproses...</span></div>',
            'Memproses data absensi, harap tunggu...'
        );

        $.ajax({
            url: "{{ route('user.scan.store') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}", token: decodedText },
            success: function (response) {
                if (response.success) {
                    if (window.addUserNotification) {
                        window.addUserNotification('✅ ' + response.message, 'success');
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Absen Berhasil!',
                        html: response.message,
                        timer: 3000,
                        showConfirmButton: false,
                        customClass: { popup: 'rounded-4' }
                    }).then(() => {
                        window.location.href = "{{ route('user.dashboard') }}";
                    });
                } else {
                    if (window.addUserNotification) {
                        window.addUserNotification('❌ ' + response.message, 'danger');
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Absen Gagal',
                        text: response.message,
                        customClass: { popup: 'rounded-4' }
                    }).then(() => {
                        // Jika sudah absen, redirect ke dashboard
                        if (response.message.includes('sudah melakukan absen')) {
                            window.location.href = "{{ route('user.dashboard') }}";
                        } else {
                            scanning = true;
                            statusArea.style.display = 'none';
                            startScanner();
                        }
                    });
                }
            },
            error: function () {
                if (window.addUserNotification) {
                    window.addUserNotification('❌ Terjadi kesalahan. Coba lagi.', 'danger');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
                    customClass: { popup: 'rounded-4' }
                }).then(() => {
                    scanning = true;
                    statusArea.style.display = 'none';
                    startScanner();
                });
            }
        });
    }

    let html5QrCode;

    function startScanner() {
        const readerEl = document.getElementById('qr-reader');
        if (!readerEl) return;

        if (html5QrCode) {
            try { html5QrCode.clear(); } catch(e) {}
        }
        
        html5QrCode = new Html5Qrcode("qr-reader");

        // Pada Android/Chrome, auto-start sering diblokir jika tidak ada User Gesture (terutama jika izin "Only this time").
        // Kita coba start secara langsung, jika gagal (karena permission ditolak otomatis atau butuh gesture), kita tampilkan tombol.
        html5QrCode.start(
            { facingMode: { exact: "environment" } },
            { fps: 15, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 },
            onScanSuccess,
            () => {}
        ).then(onCameraStarted).catch(err => {
            // Fallback ke ideal environment
            html5QrCode.start(
                { facingMode: "environment" },
                { fps: 15, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 },
                onScanSuccess,
                () => {}
            ).then(onCameraStarted).catch(() => {
                showCameraError();
            });
        });
    }

    function onCameraStarted() {
        setTimeout(() => {
            const swapLink = document.getElementById('html5-qrcode-anchor-scan-type-change');
            if (swapLink) swapLink.style.display = 'none';
            const header = document.getElementById('qr-reader__header_message');
            if (header) header.style.display = 'none';
        }, 400);
    }

    function showCameraError() {
        document.getElementById('qr-reader').innerHTML = `
            <div class="text-center p-4" style="background: #FEF2F2; border-radius: 12px; border: 1px solid #FCA5A5;">
                <i class="bi bi-camera-video-off-fill text-danger" style="font-size: 2.5rem;"></i>
                <p class="mt-2 mb-1 fw-bold text-danger">Kamera Menolak Ditampilkan</p>
                <p class="text-muted mb-3" style="font-size: 0.85rem; line-height: 1.4;">
                    Ini terjadi karena browser memblokir akses otomatis (terutama jika Anda memilih "Hanya kali ini"). <br>
                    <strong>Solusi:</strong> Klik tombol di bawah ini untuk meminta ulang izin akses kamera.
                </p>
                <button id="btn-manual-start" class="btn btn-primary btn-sm px-4" style="border-radius: 50px;">
                    <i class="bi bi-camera me-1"></i> Mulai Kamera Manual
                </button>
            </div>`;
            
        document.getElementById('btn-manual-start').addEventListener('click', function() {
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memulai...';
            this.disabled = true;
            
            // Try again on user gesture
            if (html5QrCode) {
                try { html5QrCode.clear(); } catch(e) {}
            }
            html5QrCode = new Html5Qrcode("qr-reader");
            html5QrCode.start(
                { facingMode: "environment" },
                { fps: 15, qrbox: { width: 250, height: 250 }, aspectRatio: 1.0 },
                onScanSuccess,
                () => {}
            ).then(onCameraStarted).catch(() => {
                alert("Browser benar-benar memblokir kamera. Silakan periksa ikon gembok/pengaturan situs di URL bar dan pastikan Izin Kamera di-Allow (Diizinkan), lalu refresh halaman.");
                window.location.reload();
            });
        });
    }

    startScanner();

    window.addEventListener('beforeunload', function () {
        if (html5QrCode) html5QrCode.stop().catch(() => {});
    });
});
</script>
@endif
@endpush
