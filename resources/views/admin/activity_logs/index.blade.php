@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Catatan Aktivitas</h1>

    <form id="clearLogForm"
          action="{{ route('admin.activity-logs.clear') }}"
          method="POST">

        @csrf
        @method('DELETE')

        <button type="button"
                onclick="hapusLog()"
                class="btn btn-danger rounded-pill">
            <i class="bi bi-trash"></i>
            Bersihkan Log
        </button>

    </form>
</div>


<div class="card shadow rounded-4 border-0 mb-4">

    <div class="card-header py-3 bg-white border-bottom-0 rounded-top-4">
        <h6 class="m-0 font-weight-bold text-primary">
            Log Sistem
        </h6>
    </div>


    <div class="card-body p-4 pt-0">

        <div class="table-responsive">

            <table class="table table-hover border-bottom"
                   id="logs-table"
                   width="100%"
                   cellspacing="0">

                <thead class="table-light">

                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Waktu</th>
                        <th width="15%">Pengguna</th>
                        <th width="15%">Aksi</th>
                        <th>Keterangan</th>
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


    $('#logs-table').DataTable({

        processing: true,

        serverSide: true,


        language: {

            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',

        },


        ajax: "{{ route('admin.activity-logs.index') }}",


        columns: [

            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },


            {
                data: 'created_at',
                name: 'created_at'
            },


            {
                data: 'user_name',
                name: 'user.name',
                orderable: false
            },


            {
                data: 'action',
                name: 'action'
            },


            {
                data: 'description',
                name: 'description'
            }

        ],


        order: [
            [1, 'desc']
        ],


        drawCallback: function() {

            $('.dataTables_paginate > .pagination')
                .addClass('pagination-rounded');


            $('.page-item.previous .page-link')
                .html('<i class="bi bi-chevron-left"></i>');


            $('.page-item.next .page-link')
                .html('<i class="bi bi-chevron-right"></i>');

        }

    });


});



// KONFIRMASI HAPUS LOG
function hapusLog()
{

    Swal.fire({

        title: 'Hapus semua log?',

        text: 'Semua catatan aktivitas akan dibersihkan.',

        icon: 'warning',

        showCancelButton: true,

        confirmButtonText: 'Ya, hapus',

        cancelButtonText: 'Batal'


    }).then((result) => {


        if(result.isConfirmed)
        {

            document.getElementById('clearLogForm').submit();

        }


    });

}

</script>

@endpush