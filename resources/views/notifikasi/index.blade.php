@extends('layouts.template')
@section('content')
    <div class="card card-outline card-info" style="margin-left: 10px; margin-right:10px">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-hover table-striped" id="table_notifikasi">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pesan</th>
                        <th>Waktu</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        // Fungsi modalAction untuk load konten ke dalam modal
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        var table = $('#table_notifikasi').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('/notifikasi/') }}/{{ $id_user }}/list",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: "text-center"
                },
                {
                    data: 'pesan',
                    name: 'pesan'
                },
                {
                    data: 'created_at',
                    render: function(data) {
                        // Gunakan moment.js untuk menghitung waktu secara real-time
                        return moment(data).fromNow();
                    },
                    className: "text-center"
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

        // Refresh tabel setiap 60 detik untuk memperbarui waktu
        setInterval(function() {
            table.ajax.reload(null, false);
        }, 60000);
    </script>
@endpush
