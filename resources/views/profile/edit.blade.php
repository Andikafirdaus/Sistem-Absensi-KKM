@extends('layouts.user')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0 fw-bold text-dark">Profil Saya</h3>
</div>

<div class="row g-4">
    <!-- Edit Profil -->
    <div class="col-lg-8">
        <div class="card shadow-sm rounded-4 border-0 mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 rounded-top-4">
                <h5 class="fw-bold mb-0">Informasi Pribadi</h5>
                <p class="text-muted small mt-1">Perbarui foto profil, nama, dan nomor HP Anda.</p>
            </div>
            <div class="card-body p-4">
                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> Profil berhasil diperbarui.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="mb-4 text-center">
                        <div class="position-relative d-inline-block">
                            @if(Auth::user()->profile_photo_path)
                                <img src="{{ asset('public/uploads/'.Auth::user()->profile_photo_path) }}" id="photo-preview" class="rounded-circle shadow-sm border border-3 border-light" width="120" height="120" style="object-fit: cover;">
                            @else
                                <div id="photo-placeholder" class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center shadow-sm border border-3 border-light" style="width: 120px; height: 120px; font-size: 48px; font-weight: bold;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <img src="" id="photo-preview" class="rounded-circle shadow-sm border border-3 border-light d-none" width="120" height="120" style="object-fit: cover;">
                            @endif
                            <label for="photo" class="position-absolute bottom-0 end-0 bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; cursor: pointer; transform: translate(10%, 10%);">
                                <i class="bi bi-camera text-primary"></i>
                            </label>
                            <input type="file" id="photo" name="photo" class="d-none" accept="image/*" onchange="previewImage(this)">
                        </div>
                        @error('photo')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control rounded-3 py-2 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control rounded-3 py-2 bg-light" id="email" value="{{ $user->email }}" readonly disabled>
                        <div class="form-text">Email tidak dapat diubah karena digunakan sebagai kredensial login.</div>
                    </div>

                    <div class="mb-4">
                        <label for="nomor_hp" class="form-label fw-semibold">Nomor HP</label>
                        <input type="text" class="form-control rounded-3 py-2 @error('nomor_hp') is-invalid @enderror" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp', $user->nomor_hp) }}" placeholder="Contoh: 08123456789">
                        @error('nomor_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Update Password -->
        <div class="card shadow-sm rounded-4 border-0 mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 rounded-top-4">
                <h5 class="fw-bold mb-0">Ubah Kata Sandi</h5>
                <p class="text-muted small mt-1">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>
            </div>
            <div class="card-body p-4">
                @if (session('status') === 'password-updated')
                    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> Kata sandi berhasil diubah.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="current_password" class="form-label fw-semibold">Kata Sandi Saat Ini</label>
                        <input type="password" class="form-control rounded-3 py-2 @error('current_password', 'updatePassword') is-invalid @enderror" id="current_password" name="current_password" autocomplete="current-password">
                        @error('current_password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Kata Sandi Baru</label>
                        <input type="password" class="form-control rounded-3 py-2 @error('password', 'updatePassword') is-invalid @enderror" id="password" name="password" autocomplete="new-password">
                        @error('password', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" class="form-control rounded-3 py-2 @error('password_confirmation', 'updatePassword') is-invalid @enderror" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                        @error('password_confirmation', 'updatePassword')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold shadow-sm">Ubah Kata Sandi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Organisasi (Read Only) -->
    <div class="col-lg-4">
        <div class="card shadow-sm rounded-4 border-0 mb-4 bg-primary text-white">
            <div class="card-body p-4 position-relative overflow-hidden">
                <i class="bi bi-building position-absolute opacity-10" style="font-size: 8rem; right: -20px; bottom: -20px; transform: rotate(-15deg);"></i>
                <h5 class="fw-bold mb-4 position-relative z-index-1">Informasi Organisasi</h5>
                
                <div class="mb-3 position-relative z-index-1">
                    <p class="text-white-50 small mb-0">Jabatan</p>
                    <h6 class="fw-bold">{{ $user->jabatan ?: '-' }}</h6>
                </div>
                
                <div class="mb-3 position-relative z-index-1">
                    <p class="text-white-50 small mb-0">Divisi</p>
                    <h6 class="fw-bold">{{ $user->divisi ?: '-' }}</h6>
                </div>
                
                <div class="mb-3 position-relative z-index-1">
                    <p class="text-white-50 small mb-0">Jurusan</p>
                    <h6 class="fw-bold">{{ $user->jurusan ?: '-' }}</h6>
                </div>
                
                <div class="position-relative z-index-1">
                    <p class="text-white-50 small mb-0">Angkatan</p>
                    <h6 class="fw-bold mb-0">{{ $user->angkatan ?: '-' }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                var preview = document.getElementById('photo-preview');
                var placeholder = document.getElementById('photo-placeholder');
                
                if (placeholder) {
                    placeholder.classList.add('d-none');
                }
                
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
