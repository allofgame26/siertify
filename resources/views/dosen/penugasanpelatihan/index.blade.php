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
                    <h3 class="card-title">Penugasan Pelatihan</h3>
                    <div class="card-tools">
                        <a href="{{ url('/penugasan/pelatihan/export_excel') }}" class="btn btn-indigo btn-sm"><i
                                class="fas fa-file-excel"></i>Export Excel</a>
                        <a href="{{ url('/penugasan/pelatihan/export_pdf') }}" class="btn btn-pink btn-sm"><i
                                class="fas fa-file-pdf"></i>Export PDF</a>
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
                                    <select class="form-control" id="id_periode_pelatihan" name="id_periode_pelatihan" required>
                                        <option value="">- Semua -</option>
                                        @foreach ($periode as $item)
                                            <option value="{{ $item->id_periode }}">{{ $item->nama_periode }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-hover table-sm" id="table-pelatihan">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th>Nama Pelatihan</th>
                                <th>Nama Vendor</th>
                                <th>Level</th>
                                <th>Jenis Pelatihan</th>
                                <th>Tanggal Pelaksanaan</th>
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
                    <h3 class="card-title">Penugasan Sertifikasi</h3>
                    <div class="card-tools">
                        <a href="{{ url('/penugasan/sertifikasi/export_excel') }}" class="btn btn-indigo btn-sm"><i
                                class="fas fa-file-excel"></i>Export Excel</a>
                        <a href="{{ url('/penugasan/sertifikasi/export_pdf') }}" class="btn btn-pink btn-sm"><i
                                class="fas fa-file-pdf"></i>Export PDF</a>
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-hover table-sm" id="table-sertifikasi">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th>Nama Sertifikasi</th>
                                <th>Nama Vendor</th>
                                <th>Level</th>
                                <th>Jenis Sertifikasi</th>
                                <th>Tanggal Pelaksanaan</th>
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
                    url: "{{ url('penugasan/pelatihan/list') }}",
                    type: "POST",
                    dataType: "json",
                    data: function(d) {
                        console.log($('#id_periode_pelatihan').val());  // Debugging nilai id_periode
                        d.id_periode_pelatihan = $('#id_periode_pelatihan').val();
                    }
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
                        data: "tanggal_mulai",
                        orderable: true,
                        searchable: true
                    }
                    ,
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,
                        searchable: false,
                        className: "text-center"
                    }
                ]
            });

            $('#id_periode_pelatihan').on('change', function() {
                tablePelatihan.ajax.reload(); // Memuat ulang tabel pelatihan
              
            });

            // Initialize DataTable for sertifikasi
            tableSertifikasi = $('#table-sertifikasi').DataTable({
                autoWidth: false,
                serverSide: true,
                ajax: {
                    url: "{{ url('penugasan/sertifikasi/list') }}",
                    type: "POST",
                    dataType: "json",
                    data: function(d) {
                        d.id_periode_sertifikasi = $('#id_periode_sertifikasi').val();
                    }
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
                        data: "tanggal_mulai",
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

            $('#id_periode_sertifikasi').on('change', function() {
                tableSertifikasi.ajax.reload(); // Memuat ulang tabel pelatihan
              
            });
        });
    </script>
@endpush
