 @extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Pengguna</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary shadow-sm rounded-pill px-4">
        <i class="bi bi-person-plus me-1"></i> Tambah Pengguna Baru
    </a>
</div>

<div class="card shadow-sm rounded-4 border-0 mb-4">
    <div class="card-header py-3 bg-white border-bottom-0 d-flex flex-row align-items-center justify-content-between rounded-top-4">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
    </div>
    <div class="card-body p-4 pt-0">
        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-md-3 mb-2">
                <select id="filter_divisi" class="form-select">
                    <option value="">Semua Divisi</option>
                    <option value="Ketua">Ketua</option>
                    <option value="Wakil Ketua">Wakil Ketua</option>
                    <option value="Sekretaris">Sekretaris</option>
                    <option value="Bendahara">Bendahara</option>
                    <option value="PDD">PDD</option>
                    <option value="Humas">Humas</option>
                    <option value="Acara">Acara</option>
                    <option value="Logistik">Logistik</option>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <select id="filter_jurusan" class="form-select">
                    <option value="">Semua Jurusan</option>
                    <option value="PGSD">PGSD</option>
                    <option value="Manajemen">Manajemen</option>
                    <option value="Akuntansi">Akuntansi</option>
                    <option value="Gizi">Gizi</option>
                    <option value="Sistem Informasi">Sistem Informasi</option>
                    <option value="Pendidikan Jasmani">Pendidikan Jasmani</option>
                    <option value="Hukum">Hukum</option>
                    <option value="Teknik Sipil">Teknik Sipil</option>
                    <option value="Teknik Industri">Teknik Industri</option>
                    <option value="Teknik Elektro">Teknik Elektro</option>
                    <option value="BK">BK</option>
                    <option value="Psikologi">Psikologi</option>
                    <option value="Ilmu Komputer">Ilmu Komputer</option>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <select id="filter_status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle border-bottom" id="users-table" width="100%" cellspacing="0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Pengguna</th>
                        <th>Divisi</th>
                        <th>Jurusan</th>
                        <th width="10%">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
        },
        ajax: {
            url: "{{ route('admin.users.index') }}",
            data: function (d) {
                d.divisi = $('#filter_divisi').val();
                d.jurusan = $('#filter_jurusan').val();
                d.status = $('#filter_status').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'user_info', name: 'name'},
            {
                data: 'divisi',
                name: 'divisi',
                render: function(data, type, row) {
                    return data ? '<span class="badge bg-secondary">' + data + '</span>' : '-';
                }
            },
            {data: 'jurusan', name: 'jurusan'},
            {data: 'is_active', name: 'is_active'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        drawCallback: function() {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            $('.page-item.previous .page-link').html('<i class="bi bi-chevron-left"></i>');
            $('.page-item.next .page-link').html('<i class="bi bi-chevron-right"></i>');
        },
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>rtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="bi bi-file-earmark-excel"></i> Export Excel',
                className: 'btn btn-success btn-sm mb-3'
            }
        ]
    });

    $('#filter_divisi, #filter_jurusan, #filter_status').change(function(){
        table.draw();
    });
});

function deleteUser(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak akan dapat mengembalikan ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/users/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.success) {
                        Swal.fire('Terhapus!', response.message, 'success');
                        $('#users-table').DataTable().ajax.reload();
                    } else {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    let msg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan';
                    Swal.fire('Error!', msg, 'error');
                }
            });
        }
    });
}
</script>
@endpush
