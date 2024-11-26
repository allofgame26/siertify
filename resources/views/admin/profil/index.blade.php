@extends('layouts.template')
@section('content')
    <div class="col">
        <div class="card shadow-lg">
            <!-- Header -->
            <div class="card-header text-white" style="background-image: url('{{ asset('jti.jpg') }}'); background-size: cover; background-position: center; height: 120px; position: relative;">
                <div class="widget-user-image" style="position: absolute; bottom: -40px; left: 20px;">
                    {{-- profil user tlg nanti tamabhin backendnya --}}
                    <img class="img-circle" src="{{ asset('profil-exam.png') }}" alt="User Avatar">

                </div>
            </div>

            <!-- Footer -->
            <div class="card-body" style="padding-top: 50px;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        {{-- nama pengguna tlg tambahin backendnya --}}
                        <h5 class="mb-0">Yolanda Ekaputri Setyawan</h5>
                        {{-- JENIS PENGGUNA TP DITAMBAHIN JTI tlg tambahin backendnya --}}
                        <small>Admin</small>
                    </div>
                    <button onclick="modalAction('{{ url('/profil/edit') }}')" class="btn btn-warning"> <i
                            class="fa fa-pencil"></i> Edit
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Data Pribadi di sebelah kiri -->
            <div class="col-md-6">
                <div class="card card-success">
                    <div class="card-header bg-info" style="height: 46px; padding: 12px">
                        <h3 class="card-title">Data Pribadi</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama_lengkap" readonly>
                            </div>
                            <div class="form-group">
                                <label for="NIP">NIP</label>
                                <input type="password" class="form-control" id="NIP" readonly>
                            </div>
                            <div class='row'>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tempat_lahir">Tempat Lahir</label>
                                        <input type="password" class="form-control" id="tempat_lahir" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggal_lahir">Tanggal Lahir</label>
                                        <input type="password" class="form-control" id="tanggal_lahir" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <input type="password" class="form-control" id="jenis_kelamin" readonly>
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" class="form-control" id="alamat" style="height: 52px" readonly>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Detail Kontak dan Akun Pengguna di sebelah kanan -->
            <div class="col-md-6">
                <div class="card card-indigo">
                    <div class="card-header bg-info" style="height: 46px; padding: 12px">
                        <h3 class="card-title">Detail Kontak</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="no_telp">Nomor Telepon</label>
                                <input type="text" class="form-control" id="no_telp" readonly>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" readonly>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card card-primary">
                    <div class="card-header bg-info" style="height: 46px; padding: 12px">
                        <h3 class="card-title">Akun Pengguna</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" readonly>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" readonly> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('css')
    <style>


        .img-circle {
            border-radius: 50%;
            width: 120px;
            /* Ubah ukuran lebar */
            height: 120px;
            /* Ubah ukuran tinggi */
            border: px solid white;
        }

        .card-header {
            position: relative;
            background-color: #00A7C4;
        }

        .btn-warning {
            background-color: #FFC107;
            color: #000;
            border: none;
        }

        .btn-warning:hover {
            background-color: #FFB300;
        }

        .card-body {
            background-color: white;
        }

        h5 {
            font-weight: bold;
            color: #333;
        }

        small {
            color: #666;
        }

        .form-control[readonly] {
            background-color: #fff;
            /* Tetap putih */
            color: #495057;
            /* Warna teks default AdminLTE */
            opacity: 1;
            /* Hilangkan efek transparansi */
            cursor: not-allowed;
            /* Tunjukkan bahwa elemen ini tidak dapat diedit */
            
        }
    </style>
@endpush

@push('js')
    <script>
        function modalAction(url) {
            // Implementasi modal sesuai kebutuhan
            alert("Navigasi ke: " + url);
        }
    </script>
@endpush
