@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Anggota</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row">
    <!-- Profil Anggota -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow-sm rounded-4 border-0 mb-4">
            <div class="card-body p-4 text-center">
                @if($user->profile_photo_path)
                    @php
                        $photoPath = $user->profile_photo_path;
                        if (strpos($photoPath, 'profile-photos/') !== 0) {
                            $photoPath = 'profile-photos/' . $photoPath;
                        }
                    @endphp
                    <img src="{{ asset('uploads/'.$photoPath) }}" alt="{{ $user->name }}" class="rounded-circle mb-3 border border-3 border-light shadow-sm" width="120" height="120" style="object-fit: cover;">
                @else
                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3 shadow-sm border border-3 border-light" style="width: 120px; height: 120px; font-size: 48px; font-weight: bold;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif
                <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-2">{{ $user->email }}</p>
                <div class="mb-3">
                    @if($user->is_active)
                        <span class="badge bg-success rounded-pill px-3">Aktif</span>
                    @else
                        <span class="badge bg-danger rounded-pill px-3">Tidak Aktif</span>
                    @endif
                </div>
                
                <hr class="my-4">
                
                <div class="text-start">
                    <p class="mb-2"><strong>Divisi:</strong> <br> {{ $user->divisi ?: '-' }}</p>
                    <p class="mb-2"><strong>Jurusan:</strong> <br> {{ $user->jurusan ?: '-' }}</p>
                    <p class="mb-0"><strong>Bergabung Sejak:</strong> <br> {{ $user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Riwayat Absensi -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow-sm rounded-4 border-0 mb-4">
            <div class="card-header py-3 bg-white border-bottom-0 rounded-top-4">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Absensi</h6>
            </div>
            <div class="card-body p-4 pt-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="history-table">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $attendance)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                                    <td>{{ $attendance->check_in }}</td>
                                    <td>{{ $attendance->check_out ?: '-' }}</td>
                                    <td>
                                        @if($attendance->status == 'Present')
                                            <span class="badge bg-success">Hadir</span>
                                        @elseif($attendance->status == 'Late')
                                            <span class="badge bg-warning">Terlambat</span>
                                        @elseif($attendance->status == 'Absent')
                                            <span class="badge bg-danger">Alpha</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $attendance->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $attendance->notes ?: '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat absensi.</td>
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
$(document).ready(function() {
    $('#history-table').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
        },
        order: [[0, 'desc']],
        drawCallback: function() {
            $('.page-item.previous .page-link').html('<i class="bi bi-chevron-left"></i>');
            $('.page-item.next .page-link').html('<i class="bi bi-chevron-right"></i>');
        }
    });
});
</script>
@endpush
