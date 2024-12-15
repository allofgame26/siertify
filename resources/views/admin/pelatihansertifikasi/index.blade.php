@extends('layouts.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                aria-controls="pills-home" aria-selected="true">Sertifikasi </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                aria-controls="pills-profile" aria-selected="false">Pelatihan</a>
        </li>
        <!-- ID didalam class="nav-item" membuat halaman yang berbeda-->
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <!-- Tabel Transaksi Penjualan-->
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ $page->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ url('/detailsertifikasi/export_excel') }}" class="btn btn-indigo btn-sm"><i class="fas fa-file-excel"></i>Export Excel</a>
                        <a href="{{ url('/detailsertifikasi/export_pdf') }}" class="btn btn-pink btn-sm"><i class="fas fa-file-pdf"></i> Export PDF</a>
                        <button onclick="modalAction('{{ url('/detailsertifikasi/create') }}')" class="btn btn-success"><i class="fas fa-plus-square"></i>Tambah Data </button>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-1 control-label col-form-label">Filter:</label>
                                <div class="col-3">
                                    <select class="form-control" id="id_periode_sertifikasi" name="id_periode_sertifikasi" required>
                                        <option value="">- Semua -</option>
                                        @foreach ($periode as $item)
                                            <option value="{{ $item->id_periode }}">{{ $item->nama_periode }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Periode</small>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <table class="table table-bordered table-striped table-hover table-sm" id="table-sertifikasi">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Sertifikasi</th>
                                <th>Periode</th>
                                <th>Tanggal Mulai</th>
                                <th>Lokasi</th>
                                <th>Biaya</th>
                                <th>Status Disetujui</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <Tbody>

                        </Tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- table Detail Penjualan -->
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ $page->title }}</h3>
                    <div class="card-tools">
                        <a href="{{ url('/detailpelatihan/export_excel') }}" class="btn btn-indigo btn-sm"><i class="fas fa-file-excel"></i>Export Excel</a>
                        <a href="{{ url('/detailpelatihan/export_pdf') }}" class="btn btn-pink btn-sm"><i class="fas fa-file-pdf"></i> Export PDF</a>
                        <button onclick="modalAction('{{ url('/detailpelatihan/create') }}')" class="btn btn-success">Tambah Data</button>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-1 control-label col-form-label">Filter:</label>
                                <div class="col-3">
                                    <select class="form-control" id="id_periode" name="id_periode" required>
                                        <option value="">- Semua -</option>
                                        @foreach ($periode as $item)
                                            <option value="{{ $item->id_periode }}">{{ $item->nama_periode }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">periode</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-hover table-sm" id="table-pelatihan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pelatihan</th>
                                <th>Periode</th>
                                <th>Tanggal Mulai</th>
                                <th>Lokasi</th>
                                <th>Biaya</th>
                                <th>Status Disetujui</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <Tbody></Tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        var tablePenjualan;
        $(document).ready(function() {
            tablePenjualan = $('#table-sertifikasi').DataTable({
                autoWidth: false,
                serverSide: true,
                ajax: {
                    "url": "{{ url('detailsertifikasi/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.id_periode_sertifikasi = $('#id_periode_sertifikasi').val();
                    }
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "nama_sertifikasi",
                    className: "",
                    orderable: true,
                    searchable: true
                },{
                    data: "nama_periode",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "tanggal_mulai",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "lokasi",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "biaya_format",
                    className: "",
                    orderable: true,
                    searchable: false
                }, {
                    data: "status_disetujui",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });
            $('#id_periode_sertifikasi').on('change', function() {
                tablePenjualan.ajax.reload();
            });
        });

        var tableDetail;
        $(document).ready(function() {
            tableDetail = $('#table-pelatihan').DataTable({
                autoWidth: false,
                serverSide: true,
                ajax: {
                    "url": "{{ url('detailpelatihan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.id_periode = $('#id_periode').val();
                    }
                },
                columns: [{
                    // nomor urut dari laravel datatable addIndexColumn()
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "nama_pelatihan",
                    className: "",
                    orderable: true,
                    searchable: true
                },{
                    data: "nama_periode",
                    className: "",
                    orderable: true,
                    searchable: true
                },{
                    data: "tanggal_mulai",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "lokasi",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "biaya_format",
                    className: "",
                    orderable: true,
                    searchable: false
                }, {
                    data: "status_disetujui",
                    className: "",
                    orderable: true,
                    searchable: true
                }, {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }]
            });
            $('#id_periode').on('change', function() {
                tableDetail.ajax.reload();
            });
        });
    </script>
@endpush
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