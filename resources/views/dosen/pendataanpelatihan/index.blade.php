@extends('layouts.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%"></div>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="padding-left: 10px">
        <li class="nav-item">
            <a class="nav-link active bg-info" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                aria-controls="pelatihan" aria-selected="true">Pelatihan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                aria-controls="pills-profile" aria-selected="false">Sertifikasi</a>
        </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="card card-outline card-info" style="margin-left: 10px; margin-right:10px">
                <div class="card-header">
                    <h3 class="card-title">Pendataan Riwayat Pelatihan</h3>
                    <div class="card-tools">
                        <a href="{{ url('/pendataan/pelatihan/export_excel') }}" class="btn btn-indigo btn-sm"><i
                                class="fas fa-file-excel"></i>Export Excel</a>
                        <a href="{{ url('/pendataan/pelatihan/export_pdf') }}" class="btn btn-pink btn-sm"><i
                                class="fas fa-file-pdf"></i>Export PDF</a>
                        <button onclick="modalAction('{{ url('/pendataan/pelatihan/create') }}')"
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
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-1 control-label col-form-label">Filter:</label>
                                <div class="col-3">
                                    <select class="form-control" id="user_id" name="user_id" required>
                                        <option value="">- Semua -</option>
                                        @foreach ($user as $item)
                                            <option value="{{ $item->user_id }}">{{ $item->username }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">user</small>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <table class="table table-bordered table-striped table-hover table-sm" id="table-pelatihan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th>Nama Pelatihan</th>
                                <th>Nama Vendor</th>
                                <th>Level</th>
                                <th>Jenis Pelatihan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <Tbody></Tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="card card-outline card-primary" style="margin-left: 10px; margin-right:10px">
                <div class="card-header">
                    <h3 class="card-title">Pendataan Riwayat Sertifikasi</h3>
                    <div class="card-tools">
                        <a href="{{ url('/pendataan/sertifikasi/export_excel') }}" class="btn btn-indigo btn-sm"><i
                                class="fas fa-file-excel"></i>Export Excel</a>
                        <a href="{{ url('/pendataan/sertifikasi/export_pdf') }}" class="btn btn-pink btn-sm"><i
                                class="fas fa-file-pdf"></i>Export PDF</a>
                        <button onclick="modalAction('{{ url('/pendataan/sertifikasi/create') }}')"
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
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-1 control-label col-form-label">Filter:</label>
                                <div class="col-3">
                                    <select class="form-control" id="barang_id" name="barang_id" required>
                                        <option value="">- Semua -</option>
                                        @foreach ($barang as $item)
                                            <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">barang</small>
                                </div>
                                <div class="col-3">
                                    <select class="form-control" id="pelatihan_id" name="pelatihan_id" required>
                                        <option value="">- Semua -</option>
                                        @foreach ($pelatihan as $item)
                                            <option value="{{ $item->pelatihan_id }}">{{ $item->pelatihan_kode }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">kode pelatihan</small>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <table class="table table-bordered table-striped table-hover table-sm" id="table-sertifikasi">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th>Nama Sertifikasi</th>
                                <th>Nama Vendor</th>
                                <th>Level</th>
                                <th>Jenis Sertifikasi</th>
                                <th class="aksi">Aksi</th>
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
    <style>
        .btn-pink {
            background-color: #d81b60;
            color: white;
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

        .table th,
        .table td {
            padding: 10px;
            /* Menambahkan padding di semua kolom tabel */
        }

        .table th.text-center,
        .table td.text-center {
            text-align: center;
        }

        .table .aksi {
            padding-right: 15px;
            /* Memberikan padding ekstra di sisi kanan tombol aksi */
        }
    </style>
@endpush
@push('js')
    <script>
        // Function to load and show modal
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        var tablePelatihan, tableSertifikasi;

        $(document).ready(function() {
            // Initialize DataTable for pelatihan
            tablePelatihan = $('#table-pelatihan').DataTable({
                autoWidth: false,
                serverSide: true,
                ajax: {
                    url: "{{ url('pendataan/pelatihan/list') }}",
                    type: "POST",
                    dataType: "json"
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "nama_periode",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nama_pelatihan",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nama_vendor_pelatihan",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "level_pelatihan",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nama_jenis_sertifikasi",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false,
                        className: "text-center"
                    }
                ]
            });

            // Reload tablePelatihan when user_id changes
            $('#user_id').on('change', function() {
                tablePelatihan.ajax.reload();
            });

            // Initialize DataTable for sertifikasi
            tableSertifikasi = $('#table-sertifikasi').DataTable({
                autoWidth: false,
                serverSide: true,
                ajax: {
                    url: "{{ url('pendataan/sertifikasi/list') }}",
                    type: "POST",
                    dataType: "json"
                },
                columns: [{
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "nama_periode",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nama_sertifikasi",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nama_vendor_sertifikasi",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "level_sertifikasi",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nama_jenis_sertifikasi",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false,
                        className: "text-center"
                    }
                ]
            });

            // Reload tableSertifikasi on related dropdown change
            $('#barang_id, #sertifikasi_id').on('change', function() {
                tableSertifikasi.ajax.reload();
            });
        });
    </script>
@endpush
