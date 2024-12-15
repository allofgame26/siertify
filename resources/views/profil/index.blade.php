@extends('layouts.template')
@section('content')
    <div class="col">
        @empty($user)
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
        @else
            <div class="card shadow-lg">
                <!-- Header -->
                <div class="card-header text-white"
                    style="background-image: url('{{ asset('jti.jpg') }}'); background-size: cover; background-position: center; height: 120px; position: relative;">
                    <div class="widget-user-image" style="position: absolute; bottom: -40px; left: 20px;">
                        {{-- profil user tlg nanti tamabhin backendnya --}}
                        <img class="img-circle"
                            src="{{ asset($user->identitas->foto_profil ? 'img/' . $user->identitas->foto_profil : 'img/profil-pic.png') }}"
                            alt="User Avatar">

                    </div>
                </div>

                <!-- Footer -->
                <div class="card-body" style="padding-top: 50px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            {{-- nama pengguna tlg tambahin backendnya --}}
                            <h5 class="mb-0">{{ $user->identitas->nama_lengkap }}</h5>
                            {{-- JENIS PENGGUNA TP DITAMBAHIN JTI tlg tambahin backendnya --}}
                            <small>{{ $user->jenis_pengguna->nama_jenis_pengguna }}</small>
                        </div>
                        <button onclick="modalAction('{{ url('/profil/' . $user->id_user . '/edit') }}')" class="btn btn-warning"> <i class="fa fa-pencil"></i> Edit
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
                                    <input type="text" class="form-control" id="nama_lengkap"
                                        value="{{ $user->identitas->nama_lengkap }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="NIP">NIP</label>
                                    <input type="text" class="form-control" value="{{ $user->identitas->NIP }}"
                                        id="NIP" readonly>
                                </div>
                                <div class='row'>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tempat_lahir">Tempat Lahir</label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->identitas->tempat_lahir }}" id="tempat_lahir" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_lahir">Tanggal Lahir</label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->identitas->tanggal_lahir }}" id="tanggal_lahir" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <input
                                        value="{{ $user->identitas->jenis_kelamin == 'laki' ? 'Laki-laki' : ($user->identitas->jenis_kelamin == 'perempuan' ? 'Perempuan' : '') }}"
                                        type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control"
                                        placeholder="Pilih jenis kelamin" required readonly>
                                    <small id="error-jenis_kelamin" class="error-text form-text text-danger"></small>
                                </div>

                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input value="{{ $user->identitas->alamat }}" type="text" name="alamat" id="alamat"
                                        style="height: 52px" class="form-control" placeholder="Enter Alamat" required readonly>
                                    <small id="error-alamat" class="error-text form-text text-danger"></small>
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
                                    <input type="text" class="form-control" value="{{ $user->identitas->no_telp }}"
                                        id="no_telp" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" value="{{ $user->identitas->email }}"
                                        id="email" readonly>
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
                                    <input type="text" class="form-control" value="{{ $user->username }}" id="username"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" readonly
                                        placeholder="*******">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if (Auth::user()->getRole() == 'DSN')
                <div class="col">
                    <div class="card card-info">
                        <div class="card-header bg-info d-flex align-items-center" style="height: 46px; padding: 12px">
                            <h3 class="card-title flex-grow-1 m-0">Mata Kuliah</h3>
                            <div class="card-tools d-flex justify-content-center">
                                <button onclick="modalAction('{{ url('/profil/' . $user->id_user . '/mk') }}')" class="btn btn-info btn-sm"><i class="fas fa-plus-square"></i>Tambah</button>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach ($user->matakuliah as $mk)
                                <span class="custom-badge-mk">{{ $mk->nama_mk }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card card-info">
                        <div class="card-header bg-info d-flex align-items-center" style="height: 46px; padding: 12px">
                            <h3 class="card-title flex-grow-1 m-0">Bidang Minat</h3>
                            <div class="card-tools d-flex justify-content-center">
                                <button onclick="modalAction('{{ url('/profil/' . $user->id_user . '/bd') }}')" class="btn btn-info btn-sm"><i class="fas fa-plus-square"></i>Tambah</button>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach ($user->bidangminat as $bd)
                                <span class="custom-badge-bd">{{ $bd->nama_bd }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    @endempty
       <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Konten modal akan dimuat di sini -->
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
            background-color: white;
        }

        .card-header {
            position: relative;
            background-color: #00A7C4;
        }

        .card-tools .btn i {
            margin-right: 8px;
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

        /* CSS untuk badge khusus */
        .custom-badge-mk {
            background-color: #FFFFEA;
            /* Warna kuning untuk latar */
            color: #BB6902;
            /* Warna teks hitam */
            border: 1px solid #FFDF1B;
            /* Warna border kuning gelap */
            border-radius: 16px;
            /* Membuat bentuknya lebih bulat */
            padding: 5px 15px;
            /* Padding dalam badge */
            font-weight: medium;
            /* Teks lebih tebal */
            font-size: 14px;
            /* Ukuran font */
            display: inline-block;
            /* Supaya terlihat seperti badge */
            margin: 5px;
            /* Jarak antar badge */
            height: 28px;
            justify-content: center;
            text-align: center;
        }

        .custom-badge-bd {
            background-color: #F1FCF2;
            /* Warna kuning untuk latar */
            color: #1F7634;
            /* Warna teks hitam */
            border: 1px solid #58D073;
            /* Warna border kuning gelap */
            border-radius: 16px;
            /* Membuat bentuknya lebih bulat */
            padding: 5px 15px;
            /* Padding dalam badge */
            font-weight: medium;
            /* Teks lebih tebal */
            font-size: 14px;
            /* Ukuran font */
            display: inline-block;
            /* Supaya terlihat seperti badge */
            margin: 5px;
            /* Jarak antar badge */
            height: 28px;
            justify-content: center;
            text-align: center;
        }
    </style>
@endpush

@push('js')
    <script>
     function modalAction(url = '') {
            console.log(url); // Debugging
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
    </script>
@endpush
