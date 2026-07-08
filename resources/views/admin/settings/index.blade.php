@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pengaturan Sistem</h1>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow rounded-4 border-0 mb-4">
            <div class="card-header py-3 bg-white border-bottom-0 rounded-top-4">
                <h6 class="m-0 font-weight-bold text-primary">Konfigurasi Global</h6>
            </div>
            <div class="card-body p-4 pt-0">
                @if(session('success'))
                    <div class="alert alert-success border-0 bg-success text-white">{{ session('success') }}</div>
                @endif
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    
                    <h5 class="mb-3 mt-2 font-weight-bold text-dark">Informasi Organisasi</h5>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold text-uppercase">Nama Organisasi</label>
                        <input type="text" name="org_name" class="form-control" value="{{ $setting->org_name ?? 'KKM Absensi' }}" required>
                    </div>

                    <h5 class="mb-3 mt-4 font-weight-bold text-dark">Jam Kerja & Absensi</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Jam Masuk</label>
                            <input type="time" name="start_time" class="form-control" value="{{ $setting->start_time ?? '08:00' }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Jam Keluar</label>
                            <input type="time" name="end_time" class="form-control" value="{{ $setting->end_time ?? '17:00' }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Toleransi Terlambat (Menit)</label>
                            <input type="number" name="late_tolerance" class="form-control" value="{{ $setting->late_tolerance ?? 15 }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small fw-bold text-uppercase">Validasi QR (Menit)</label>
                            <input type="number" name="qr_validity_minutes" class="form-control" value="{{ $setting->qr_validity_minutes ?? 5 }}" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3 px-4 shadow-sm">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
