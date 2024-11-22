<<<<<<< HEAD
@empty($jenispengguna)
=======
@empty($datapengguna)
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data jenis yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/jenis') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
<<<<<<< HEAD
    <form action="{{ url('/jenispengguna/' . $jenispengguna->id_jenis_pengguna. '/update') }}" method="POST" id="form-edit">
=======
    <form action="{{ url('/datapengguna/' . $datapengguna->id_identitas. '/update') }}" method="POST" id="form-edit">
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data jenis</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
<<<<<<< HEAD
                        <label>Nama Jenis Pengguna</label>
                        <input value="{{ $jenispengguna->nama_jenis_pengguna }}" type="text" name="nama_jenis_pengguna" id="nama_jenis_pengguna" class="form-control" placeholder="Enter Nama Jenis Pengguna" required>
                        <small id="error-nama_jenis_pengguna" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Kode Jenis Pengguna</label>
                        <input value="{{ $jenispengguna->kode_jenis_pengguna }}" type="text" name="kode_jenis_pengguna" id="kode_jenis_pengguna"
                            class="form-control" placeholder="Enter Kode Jenis Pengguna" required>
                        <small id="error-kode_jenis_pengguna" class="error-text form-text text-danger"></small>
=======
                        <label>Nama Lengkap</label>
                        <input value="{{ $datapengguna->nama_lengkap }}" type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                            placeholder="Enter Nama Lengkap" required>
                        <small id="error-nama_lengkap" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Nomor Induk Pengajar (NIP)</label>
                        <input value="{{ $datapengguna->NIP }}" type="text" name="NIP" id="NIP"
                            class="form-control" placeholder="Enter NIP" required>
                        <small id="error-NIP" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input value="{{ $datapengguna->tempat_lahir }}" type="text" name="tempat_lahir" id="tempat_lahir"
                            class="form-control" placeholder="Enter Tempat Lahir" required>
                        <small id="error-tempat_lahir" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tangal Lahir</label>
                        <input value="{{ $datapengguna->tanggal_lahir }}" type="date" name="tanggal_lahir" id="tanggal_lahir"
                        class="form-control" placeholder="Pilih tanggal" required>
                        <small id="error-tanggal_lahir" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="{{ $datapengguna->jenis_kelamin }}" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="laki">Laki-Laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                        <small id="error-jenis_kelamin" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input value="{{ $datapengguna->alamat }}" type="text" name="alamat" id="alamat"
                            class="form-control" placeholder="Enter Alamat" required>
                        <small id="error-alamat" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input value="{{ $datapengguna->no_telp }}" type="text" name="no_telp" id="no_telp"
                            class="form-control" placeholder="Enter Nomor Telefon" required>
                        <small id="error-no_telp" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input value="{{ $datapengguna->email }}" type="text" name="email" id="email"
                            class="form-control" placeholder="Enter E - Mail" required>
                        <small id="error-email" class="error-text form-text text-danger"></small>
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </div>
    </form>

    <style>
        .modal-header {
            padding: 10px;
            /* Sesuaikan nilai padding */
        }

        .modal-content {
            border-radius: 10px;
            /* Sesuaikan nilai radius */
        }
    </style>
    <script>
        $(document).ready(function() {
<<<<<<< HEAD

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

            $("#form-edit").validate({
                rules: {
                    nama_jenis_pengguna: {
                    required: true,
                    minlength: 5,
                    maxlength: 50
                },
                    kode_jenis_pengguna: {
                    required: true,
                    minlength: 3,
                    maxlength: 5
=======
            $("#form-edit").validate({
                rules: {
                    nama_lengkap: {
                    required: true,
                    minlength: 10,
                    maxlength: 100
                },
                NIP: {
                    required: true,
                    minlength: 10,
                    maxlength: 20
                },
                tempat_lahir: {
                    required: true,
                    minlength: 5,
                    maxlength: 10
                },
                tanggal_lahir: {
                    required: true,
                    date: true,
                },
                jenis_kelamin: {
                    required: true,
                },
                alamat: {
                    required: true,
                    minlength: 10,
                    maxlength: 100
                },
                no_telp: {
                    required: true,
                    minlength: 10,
                    maxlength: 15
                },
                email: {
                    required: true,
                    email: true,
                    minlength: 10,
                    maxlength: 50
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
                }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });

<<<<<<< HEAD
                                if (typeof datajenispengguna !== 'undefined') {
                                    datajenispengguna.ajax.reload(null, false); // Reload tabel tanpa mengubah posisi halaman
=======
                                if (typeof datapengguna !== 'undefined') {
                                    datapengguna.ajax.reload(null, false); // Reload tabel tanpa mengubah posisi halaman
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
                            }
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty
