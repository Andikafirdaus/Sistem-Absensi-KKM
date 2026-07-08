@extends('layouts.user')

@section('title', 'Riwayat Absensi')

@section('content')
{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="fw-bold mb-1" style="color: #0F172A;">Riwayat Absensi</h4>
        <p class="mb-0" style="color: #64748B; font-size: 0.875rem;">Rekap kehadiran Anda secara lengkap</p>
    </div>
</div>

<div class="saas-card">
    <div class="saas-card-body">
        {{-- Filters --}}
        <div class="row mb-4 g-3">
            <div class="col-md-3 col-6">
                <label class="form-label small fw-semibold text-muted mb-1">Bulan</label>
                <select id="filter_month" class="form-select form-select-sm" style="border-radius: 8px;">
                    <option value="">Semua Bulan</option>
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3 col-6">
                <label class="form-label small fw-semibold text-muted mb-1">Tahun</label>
                <select id="filter_year" class="form-select form-select-sm" style="border-radius: 8px;">
                    <option value="">Semua Tahun</option>
                    @for($i = date('Y'); $i >= 2024; $i--)
                        <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3 col-12">
                <label class="form-label small fw-semibold text-muted mb-1">Status</label>
                <select id="filter_status" class="form-select form-select-sm" style="border-radius: 8px;">
                    <option value="">Semua Status</option>
                    <option value="Present">Hadir</option>
                    <option value="Late">Terlambat</option>
                    <option value="Absent">Alpha</option>
                </select>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table saas-table w-100 align-middle" id="history-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Jam Absen</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
.dataTables_wrapper .dataTables_length select,
.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    padding: 0.3rem 0.6rem;
    font-size: 0.875rem;
    color: #0F172A;
    font-family: 'Poppins', sans-serif;
    outline: none;
}
.dataTables_wrapper .dataTables_filter input:focus {
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
}
.dataTables_wrapper .dataTables_info {
    font-size: 0.8rem;
    color: #64748B;
    padding-top: 0.75rem;
}
.dataTables_wrapper .dataTables_paginate { padding-top: 0.75rem; }
.dataTables_wrapper .dataTables_paginate .paginate_button { border-radius: 8px !important; font-size: 0.8rem; font-family: 'Poppins', sans-serif; }
.dataTables_wrapper .dataTables_paginate .paginate_button.current { background: #2563EB !important; border-color: #2563EB !important; color: white !important; }
.dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #F8FAFC !important; border-color: #E2E8F0 !important; color: #2563EB !important; }
.form-select { border: 1px solid #E2E8F0; font-size: 0.875rem; color: #0F172A; font-family: 'Poppins', sans-serif; }
.form-select:focus { border-color: #2563EB; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function () {
    let table = $('#history-table').DataTable({
        processing: true,
        serverSide: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
        },
        ajax: {
            url: "{{ route('user.history') }}",
            data: function (d) {
                d.month  = $('#filter_month').val();
                d.year   = $('#filter_year').val();
                d.status = $('#filter_status').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'date', name: 'date' },
            {
                data: 'check_in',
                name: 'check_in',
                render: function (data) {
                    if (!data || data === '-') return '<span class="text-muted">-</span>';
                    return `<span class="fw-medium text-primary"><i class="bi bi-clock me-1"></i>${data}</span>`;
                }
            },
            { data: 'status', name: 'status' },
            { data: 'notes', name: 'notes' }
        ],
        order: [[1, 'desc']],
        drawCallback: function() {
            $('.page-item.previous .page-link').html('<i class="bi bi-chevron-left"></i>');
            $('.page-item.next .page-link').html('<i class="bi bi-chevron-right"></i>');
        }
    });

    $('#filter_month, #filter_year, #filter_status').on('change', function () {
        table.draw();
    });
});
</script>
@endpush
