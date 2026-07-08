@extends('layouts.admin')

@section('title', 'Data Absensi')

@section('content')
{{-- Page Header --}}
<div class="dashboard-greeting">
    <h1 class="greeting-title">Data Absensi</h1>
    <p class="greeting-subtitle">Rekap seluruh data kehadiran peserta KKM</p>
</div>

<div class="saas-card">
    <div class="saas-card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
        <h5 style="font-size: 1rem; font-weight: 600; margin: 0;">
            <i class="bi bi-calendar-check-fill text-primary me-2"></i>Riwayat Absensi
        </h5>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <input type="date" id="filter_date" class="form-control form-control-sm"
                   value="{{ date('Y-m-d') }}"
                   style="border-radius: 8px; border: 1px solid #E2E8F0; font-size: 0.875rem; min-width: 150px;">
            <button class="btn btn-sm btn-primary px-3" id="btn-filter" style="border-radius: 8px; font-weight: 500;">
                <i class="bi bi-funnel me-1"></i> Saring
            </button>
            <a href="{{ route('admin.attendances.export') }}?date={{ date('Y-m-d') }}"
               id="btn-export"
               class="btn btn-sm btn-success px-3"
               style="border-radius: 8px; font-weight: 500;">
                <i class="bi bi-file-earmark-excel me-1"></i> Ekspor Excel
            </a>
        </div>
    </div>

    <div class="saas-card-body">
        <div class="table-responsive">
            <table class="table saas-table w-100" id="attendances-table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Divisi</th>
                        <th>Tanggal</th>
                        <th>Jam Absen</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    var table = $('#attendances-table').DataTable({
        processing: true,
        serverSide: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
        },
        ajax: {
            url: "{{ route('admin.attendances.index') }}",
            data: function (d) {
                d.date = $('#filter_date').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            {
                data: 'user_name',
                name: 'user.name',
            },
            { data: 'user_divisi', name: 'user.divisi', defaultContent: '-' },
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
        ],
        order: [[3, 'desc']],
        drawCallback: function () {
            $('.page-item.previous .page-link').html('<i class="bi bi-chevron-left"></i>');
            $('.page-item.next .page-link').html('<i class="bi bi-chevron-right"></i>');
        }
    });

    $('#btn-filter').on('click', function () {
        table.draw();
        const dateVal = $('#filter_date').val();
        $('#btn-export').attr('href', "{{ route('admin.attendances.export') }}?date=" + dateVal);
    });
});
</script>

<style>
.dataTables_wrapper .dataTables_length select,
.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    padding: 0.3rem 0.6rem;
    font-size: 0.875rem;
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
.dataTables_wrapper .dataTables_paginate {
    padding-top: 0.75rem;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 8px !important;
    font-size: 0.8rem;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #2563EB !important;
    border-color: #2563EB !important;
    color: white !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #F8FAFC !important;
    border-color: #E2E8F0 !important;
    color: #2563EB !important;
}
</style>
@endpush
