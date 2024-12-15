@extends('layouts.template')
@section('content')
    <div class="col">
        @empty($user)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
        @else
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            {{-- sertif belum disetujui --}}
                            <div class="col-lg-6 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>{{ $jmlSertifikasi }}</h3>
                                        <p>Sertifikasi</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <!-- ./col -->
                            <div class="col-lg-6 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{ $jmlPelatihan }}<sup style="font-size: 20px"></sup></h3>
                                        <p>Pelatihan</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 col-md-12">
                                <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog"
                                    data-backdrop="static" data-keyboard="false" data-width="75%"></div>
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="padding-left: 10px">
                                    <li class="nav-item">
                                        <a class="nav-link active bg-info" id="pills-home-tab" data-toggle="pill"
                                            href="#pills-home" role="tab" aria-controls="pelatihan"
                                            aria-selected="true">Pelatihan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                            role="tab" aria-controls="pills-profile" aria-selected="false">Sertifikasi</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <!-- Tab Pelatihan -->
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                        aria-labelledby="pills-home-tab">
                                        <div class="card card-outline card-info" style="margin-left: 10px; margin-right:10px">
                                            <div class="card-header">
                                                <h3 class="card-title">Riwayat Pelatihan</h3>
                                            </div>
                                            <div class="card-body">
                                                @if (session('success'))
                                                    <div class="alert alert-success">{{ session('success') }}</div>
                                                @endif
                                                @if (session('error'))
                                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                                @endif
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-hover table-sm"
                                                        id="table-pelatihan">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Periode</th>
                                                                <th>Nama Pelatihan</th>
                                                                <th>Nama Vendor</th>
                                                                <th>Level</th>
                                                                <th>Tanggal Pelaksanaan</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Tab Sertifikasi -->
                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                        aria-labelledby="pills-profile-tab">
                                        <div class="card card-outline card-info" style="margin-left: 10px; margin-right:10px">
                                            <div class="card-header">
                                                <h3 class="card-title">Riwayat Pelatihan</h3>
                                            </div>
                                            <div class="card-body">
                                                @if (session('success'))
                                                    <div class="alert alert-success">{{ session('success') }}</div>
                                                @endif
                                                @if (session('error'))
                                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                                @endif
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-hover table-sm"
                                                        id="table-sertifikasi">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Periode</th>
                                                                <th>Nama Sertifikasi</th>
                                                                <th>Nama Vendor</th>
                                                                <th>Level</th>
                                                                <th>Tanggal Pelaksanaan</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12">
                                <!-- Bidang Minat -->
                                <div class="col">
                                    <div class="card card-info">
                                        <div class="card-header bg-info" style="height: 46px; padding: 12px">
                                            <h3 class="card-title">Bidang Minat</h3>
                                        </div>
                                        <div class="card-body">
                                            @foreach ($bidangMinat as $bd)
                                                <span class="custom-badge-bd">{{ $bd }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Mata Kuliah -->
                                <div class="col mt-3">
                                    <div class="card card-info">
                                        <div class="card-header bg-info" style="height: 46px; padding: 12px">
                                            <h3 class="card-title">Mata Kuliah</h3>
                                        </div>
                                        <div class="card-body">
                                            @foreach ($mataKuliah as $mk)
                                                <span class="custom-badge-mk">{{ $mk }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                </div>
            </div>
        @endempty
    </div>
    -- Modal -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" data-width="75%" aria-hidden="true"></div>
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
            color: white;
        }

        .card-tools .btn i {
            margin-right: 8px;
        }

        .card-body {
            padding: 15px;
            /* Sesuaikan padding jika terlalu banyak */
            width: 100%;
            /* Pastikan card-body mengisi lebar penuh */
        }

        .table-responsive {
            overflow-x: auto;
            width: 100%;
        }

        #table-sertifikasi {}

        #table-sertifikasi th,
        #table-sertifikasi td {
            white-space: nowrap;
            /* Hindari teks yang terpotong atau meluber */
        }


        .custom-badge-mk {
            background-color: #FFFFEA;
            color: #BB6902;
            border: 1px solid #FFDF1B;
            border-radius: 16px;
            padding: 5px 15px;
            font-weight: medium;
            font-size: 14px;
            display: inline-block;
            margin: 5px;
            height: 28px;
            justify-content: center;
            text-align: center;
        }

        .custom-badge-bd {
            background-color: #F1FCF2;
            color: #1F7634;
            border: 1px solid #58D073;
            border-radius: 16px;
            padding: 5px 15px;
            font-weight: medium;
            font-size: 14px;
            display: inline-block;
            margin: 5px;
            height: 28px;
            justify-content: center;
            text-align: center;
        }

        /* Flexbox untuk menata kolom */
        .row {
            display: flex;
            flex-wrap: wrap;
        }

        /* Mengatur tata letak jika menggunakan Flexbox */
        .col-lg-4 {
            order: 2;
        }

        .col-lg-8 {
            order: 1;
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
        
        var dataPelatihan, dataSertifikasi;

        $(document).ready(function() {

            dataSertifikasi = $('#table-sertifikasi').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('/statistik/sertifikasi') }}/" + {{ $user->id_user }} + "/list/" +
                        {{ $user->id_periode }},
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
                        data: "nama_periode",
                        className: "text-center",
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
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "level_sertifikasi",
                        className: "text-center",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "tanggal_mulai",
                        className: "text-center",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                    }
                ]
            });

        });

        $(document).ready(function() {

            dataPelatihan = $('#table-pelatihan').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('/statistik/pelatihan') }}/" + {{ $user->id_user }} + "/list/" +
                        {{ $user->id_periode }},
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
                        data: "nama_periode",
                        className: "text-center",
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
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "level_pelatihan",
                        className: "text-center",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "tanggal_mulai",
                        className: "text-center",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                    }
                ]
            });

        });
    </script>
@endpush
