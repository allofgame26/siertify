@extends('layouts.template')

@section('content')
    <!-- Navigation Tabs -->
    <div class="mb-3">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link @if (request()->is('pengajuan')) active @endif"
                    href="{{ url('/pengajuan') }}">Pelatihan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request()->is('sertifikasi')) active @endif"
                    href="{{ url('/sertifikasi') }}">Sertifikasi</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="card">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between mb-3">
                <h6 class="card-title mb-0">Sertifikasi</h6>
                <div>
                    <button onclick="modalAction('{{ url('/pengajuan/import') }}')" class="btn btn-primary btn-sm"><i
                            class="fas fa-upload me-1"></i>Import Data</button>
                    <a href="{{ url('/sertifikasi/export_excel') }}" class="btn btn-indigo btn-sm"><i
                            class="fa fa-file-excel me-1"></i>Export Excel</a>
                    <a href="{{ url('/pengajuan/export_pdf') }}" class="btn btn-pink btn-sm"><i
                            class="fa fa-file-pdf me-1"></i>Export PDF</a>
                </div>
            </div>

            <!-- Data Table Controls -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center">
                    <span class="small">Show</span>
                    <select class="form-select form-select-sm mx-2" style="width: 60px;">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>75</option>
                        <option>100</option>
                    </select>
                    <span class="small">entries</span>
                </div>
                <div class="search-box">
                    <input type="text" class="form-control form-control-sm" placeholder="Search...">
                </div>
            </div>

            <!-- Training Table -->
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th class="px-2">No</th>
                            <th class="px-2">Nama</th>
                            <th class="px-2">Tanggal Pelaksanaan</th>
                            <th class="px-2">Nama Vendor</th>
                            <th class="px-2">Status</th>
                            <th class="px-2">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('css')
    <style>
        /* General Typography */
        body {
            font-size: 13px;
        }

        /* Navigation */
        .nav-tabs .nav-link {
            border: none;
            padding: 6px 16px;
            font-size: 13px;
        }

        /* Card Styles */
        .card {
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 14px;
            font-weight: 500;
        }

        /* Table Styles */
        .table {
            font-size: 12px;
            margin-bottom: 0;
        }

        .table th {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 8px;
            font-weight: 500;
        }

        .table td {
            padding: 6px;
            vertical-align: middle;
        }

        /* Badges */
        .badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: normal;
        }

        /* Buttons */
        .btn-xs {
            padding: 2px 6px;
            font-size: 11px;
            line-height: 1.5;
            border-radius: 3px;
            margin: 0 1px;
        }

        .btn-sm {
            padding: 4px 8px;
            font-size: 12px;
            line-height: 1.5;
            margin: 0 2px;
        }

        /* Form Elements */
        .form-control,
        .form-select {
            font-size: 12px;
            padding: 4px 8px;
            height: calc(1.5em + 0.5rem + 2px);
        }

        /* Status Colors */
        .bg-success {
            background-color: #98FB98 !important;
            color: #006400;
        }

        .bg-danger {
            background-color: #FFB6C1 !important;
            color: #8B0000;
        }

        /* Spacing */
        .px-2 {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }

        /* Icons in buttons */
        .btn i {
            font-size: 11px;
        }

        /* Custom button colors */
        .btn-pink {
            background-color: #d81b60;
            color: white;
        }

        .btn-indigo {
            background-color: indigo;
            color: white;
        }

        /* Default style for tabs */
        .nav-tabs .nav-link {
            border: none;
            padding: 6px 16px;
            font-size: 13px;
            color: black;
            /* Default text color */
            background-color: #f8f9fa;
            /* Default background color */
            transition: background-color 0.3s, color 0.3s;
            /* Smooth transitions */
        }

        /* Active tab style */
        .nav-tabs .nav-link.active {
            color: white;
            /* Text color for active tab */
            background-color: #20B2AA;
            /* Background color for active tab */
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

        var dataPengajuan;
        $(document).ready(function() {
            dataPengajuan = $('#table_pengajuan').DataTable({
                // serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax: {
                    "url": "{{ url('pengajuan/list') }}",
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
                        data: "nama",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "tanggal_mulai",
                        className: "",
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "id_vendor.nama_vendor",
                        className: "",
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "status_disetujui",
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
