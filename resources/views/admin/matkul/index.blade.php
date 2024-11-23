@extends('layouts.template')
@section('content')
    <div class="card card-outline card-info" style="margin-left: 10px; margin-right:10px">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/matkul/import') }}')" class="btn btn-primary btn-sm"><i class="fas fa-upload"></i>Import Data</button>
                <a href="{{ url('/matkul/export_excel') }}" class="btn btn-indigo btn-sm"><i class="fas fa-file-excel"></i>Export Excel</a>
                <a href="{{ url('/matkul/export_pdf') }}" class="btn btn-pink btn-sm"><i class="fas fa-file-pdf"></i> Export PDF</a>
                <button onclick="modalAction('{{ url('matkul/create_ajax') }}')"
                    class="btn btn-success btn-sm"><i class="fas fa-plus-square"></i>Tambah Data</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_matkul">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kode</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
<style>

.btn-pink {
    background-color: #d81b60;
    color:white;
}

.btn-indigo {
    background-color: indigo;
    color: white;
}

.btn-teal {
    background-color: #39cccc;
    color: white
}

.card-tools .btn i {
    margin-right: 8px;
}

</style>

@endpush

@push('js')
    <script>
        // Fungsi modalAction untuk load konten ke dalam modal
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var datamatkul;
        $(document).ready(function() {
            datamatkul = $('#table_matkul').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('matkul/list') }}",
                    "dataType": "json",
                    "type": "POST",
                },
                columns: [{
                        // nomor urut dari laravel datatable addIndexColumn()
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "nama_mk",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "kode_mk",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "deskripsi_mk",
                        className: "",
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush