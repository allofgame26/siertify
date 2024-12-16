@extends('layouts.template')
@section('content')
    <div class="col">
        <div class="card">
            <div class="card card-info">
                <div class="card-header" style="height: 46px; padding: 12px">
                    <h3 class="card-title">Statistik Pelatihan dan Sertifikasi Dosen</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="barChart2"
                            style="min-height: 250px; height: 250px; max-height: 400px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <div class="card card-outline card-info" style="margin-left: 10px; margin-right:10px">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a href="{{ url('/statistik/export_excel') }}" class="btn btn-indigo btn-sm"><i
                        class="fas fa-file-excel"></i>Export Excel</a>
                <a href="{{ url('/statistik/export_pdf') }}" class="btn btn-pink btn-sm"><i
                        class="fas fa-file-pdf"></i> Export PDF</a>
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
                                <option value="">- Periode -</option>
                                @foreach ($periode as $item)
                                    <option value="{{ $item->id_periode }}">{{ $item->nama_periode }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <select class="form-control" id="id_identitas" name="id_identitas" required>
                                <option value="">- Dosen -</option>
                                @foreach ($identitas as $item)
                                    <option value="{{ $item->id_identitas }}">{{ $item->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_statistik">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Dosen</th>
                        <th>Periode</th>
                        <th>Jumlah Pelatihan</th>
                        <th>Jumlah Sertifikasi</th>
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
    </style>
@endpush

@push('js')
    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('adminlte/dist/js/pages/dashboard.js') }}"></script>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('adminlte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>


    <script>
        
        // Fungsi modalAction untuk load konten ke dalam modal
              function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        // Include CSRF token in all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

        var dataStatistik;

        $(document).ready(function() {

            
            dataStatistik = $('#table_statistik').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('statistik/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    data: function(d) {
                        console.log($('#id_periode').val());  // Debugging nilai id_periode
                        d.id_periode = $('#id_periode').val(),
                        d.id_identitas = $('#id_identitas').val();
                    }
                },
                columns: [{
                        // nomor urut dari laravel datatable addIndexColumn()
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "nama_lengkap",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "nama_periode",
                        className: "text-center",
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "jumlah_pelatihan",
                        className: "text-center",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "jumlah_sertifikasi",
                        className: "text-center",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "aksi",
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                        className: "text-center"
                    }
                ]
            });

            $('#id_periode').on('change', function() {
                dataStatistik.ajax.reload(); // Memuat ulang tabel pelatihan
              
            });

            $('#id_identitas').on('change', function() {
                dataStatistik.ajax.reload(); // Memuat ulang tabel pelatihan
              
            });



            // BAR CHART SERTIFIKASI
            var ctx = document.getElementById('barChart2').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                            label: 'Jumlah Pelatihan',
                            data: {!! json_encode($pelatihanData) !!},
                            backgroundColor: '#3C8DBC',
                        },
                        {
                            label: 'Jumlah Sertifikasi',
                            data: {!! json_encode($sertifikasiData) !!},
                            backgroundColor: '#605CA8',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetFill: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });



        });
    </script>
@endpush
