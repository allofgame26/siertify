@empty($datapengguna)
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
    <form action="{{ url('/datapengguna/' . $datapengguna->id_identitas . '/update') }}" method="POST" id="form-edit"
        enctype="multipart/form-data">>
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
                        <label>Foto Profil</label><br>
                        <!-- Foto profil yang akan diubah langsung -->
                        <img id="current-foto_profil" src="{{ asset('img/' . $datapengguna->foto_profil) }}" class="img-foto_profil mb-2" alt="Foto Profil Saat Ini" style="width: 100px; height: 100px; object-fit: cover;"><br>
                        <input type="file" name="foto_profil" id="foto_profil"  value="{{ $datapengguna->foto_profil }}" class="form-control" accept="image/*">
                        <small id="error-foto_profil" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input value="{{ $datapengguna->nama_lengkap }}" type="text" name="nama_lengkap"
                            id="nama_lengkap" class="form-control" placeholder="Enter Nama Lengkap" required>
                        <small id="error-nama_lengkap" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Nomor Induk Pengajar (NIP)</label>
                        <input value="{{ $datapengguna->NIP }}" type="text" name="NIP" id="NIP"
                            class="form-control" placeholder="Enter NIP" required>
                        <small id="error-NIP" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input value="{{ $datapengguna->tempat_lahir }}" type="text" name="tempat_lahir"
                                    id="tempat_lahir" class="form-control" placeholder="Enter Tempat Lahir" required>
                                <small id="error-tempat_lahir" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tangal Lahir</label>
                                <input value="{{ $datapengguna->tanggal_lahir }}" type="date" name="tanggal_lahir"
                                    id="tanggal_lahir" class="form-control" placeholder="Pilih tanggal" required>
                                <small id="error-tanggal_lahir" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                    <option value="">- Pilih Jenis Kelamin -</option>
                                    <option value="laki" {{ ($datapengguna->jenis_kelamin == 'laki') ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="perempuan" {{ ($datapengguna->jenis_kelamin == 'perempuan') ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                <small id="error-jenis_kelamin" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input value="{{ $datapengguna->alamat }}" type="text" name="alamat" id="alamat"
                            class="form-control" placeholder="Enter Alamat" required>
                        <small id="error-alamat" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Telepon</label>
                                <input value="{{ $datapengguna->no_telp }}" type="text" name="no_telp" id="no_telp"
                                    class="form-control" placeholder="Enter Nomor Telefon" required>
                                <small id="error-no_telp" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input value="{{ $datapengguna->email }}" type="text" name="email" id="email"
                                    class="form-control" placeholder="Enter E - Mail" required>
                                <small id="error-email" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
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

            // Mengganti foto profil langsung ketika memilih file baru
            $("#foto_profil").change(function() {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#current-foto_profil').attr('src', e.target
                    .result); // Mengganti src gambar profil saat ini
                }
                reader.readAsDataURL(this.files[0]);
            });

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
                    },
                    foto_profil: {
                        extension: "jpg|jpeg|png"
                    }
                },
                submitHandler: function(form) {

                    var formData = new FormData(form); // Gunakan FormData untuk file upload

                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: formData,
                        contentType: false,
                processData: false,
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                }).then(function() {
                                    // Reload halaman atau update data setelah Swal ditutup
                                    if (typeof datapengguna !== 'undefined') {
                                        datapengguna.ajax.reload(); // Reload data table jika ada
                                    } else {
                                        location.reload(); // Reload halaman jika tidak ada dataUser
                                    }
                                });
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
