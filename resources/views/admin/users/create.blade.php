@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Pengguna Baru</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card shadow rounded-4 border-0">
    <div class="card-body p-4">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="divisi" class="form-label">Divisi</label>
                    <select class="form-select @error('divisi') is-invalid @enderror" id="divisi" name="divisi">
                        <option value="">Pilih Divisi</option>
                        <option value="Ketua" {{ old('divisi') == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                        <option value="Wakil Ketua" {{ old('divisi') == 'Wakil Ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                        <option value="Sekretaris" {{ old('divisi') == 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                        <option value="Bendahara" {{ old('divisi') == 'Bendahara' ? 'selected' : '' }}>Bendahara</option>
                        <option value="PDD" {{ old('divisi') == 'PDD' ? 'selected' : '' }}>PDD</option>
                        <option value="Humas" {{ old('divisi') == 'Humas' ? 'selected' : '' }}>Humas</option>
                        <option value="Acara" {{ old('divisi') == 'Acara' ? 'selected' : '' }}>Acara</option>
                        <option value="Logistik" {{ old('divisi') == 'Logistik' ? 'selected' : '' }}>Logistik</option>
                    </select>
                    @error('divisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="jurusan" class="form-label">Jurusan</label>
                    <select class="form-select @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan">
                        <option value="">Pilih Jurusan</option>
                        <option value="PGSD" {{ old('jurusan') == 'PGSD' ? 'selected' : '' }}>PGSD</option>
                        <option value="Manajemen" {{ old('jurusan') == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                        <option value="Akuntansi" {{ old('jurusan') == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
                        <option value="Gizi" {{ old('jurusan') == 'Gizi' ? 'selected' : '' }}>Gizi</option>
                        <option value="Sistem Informasi" {{ old('jurusan') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                        <option value="Pendidikan Jasmani" {{ old('jurusan') == 'Pendidikan Jasmani' ? 'selected' : '' }}>Pendidikan Jasmani</option>
                        <option value="Hukum" {{ old('jurusan') == 'Hukum' ? 'selected' : '' }}>Hukum</option>
                        <option value="Teknik Sipil" {{ old('jurusan') == 'Teknik Sipil' ? 'selected' : '' }}>Teknik Sipil</option>
                        <option value="Teknik Industri" {{ old('jurusan') == 'Teknik Industri' ? 'selected' : '' }}>Teknik Industri</option>
                        <option value="Teknik Elektro" {{ old('jurusan') == 'Teknik Elektro' ? 'selected' : '' }}>Teknik Elektro</option>
                        <option value="BK" {{ old('jurusan') == 'BK' ? 'selected' : '' }}>BK</option>
                        <option value="Psikologi" {{ old('jurusan') == 'Psikologi' ? 'selected' : '' }}>Psikologi</option>
                        <option value="Ilmu Komputer" {{ old('jurusan') == 'Ilmu Komputer' ? 'selected' : '' }}>Ilmu Komputer</option>
                    </select>
                    @error('jurusan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Role default: user (hidden) --}}
            <input type="hidden" name="role" value="user">

            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            
            <div class="mb-4 form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Akun Aktif</label>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Buat Pengguna</button>
        </form>
    </div>
</div>
@endsection
