

@empty($user)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/profil') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/profil/' . $user->id_user . '/update') }}" method="POST" id="form-edit"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Foto Profil</label><br>
                        <!-- Foto profil yang akan diubah langsung -->
                        <img id="current-foto_profil" src="{{ asset('img/' . $user->identitas->foto_profil) }}"
                             class="img-foto_profil mb-2" alt="Foto Profil Saat Ini"
                             style="width: 100px; height: 100px; object-fit: cover;"><br>
                    
                        <!-- Input untuk memilih foto baru -->
                        <input type="file" name="foto_profil" id="foto_profil" class="form-control" accept="image/*">
                        
                        <small id="error-foto_profil" class="error-text form-text text-danger"></small>
                    </div>
                    
                    <div>
                        <h4>Data Pribadi</h4>
                    </div>

                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input value="{{ $user->identitas->nama_lengkap }}" type="text" name="nama_lengkap" id="nama_lengkap"
                            class="form-control" required>
                        <small id="error-nama_lengkap" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>NIP</label>
                        <input value="{{ $user->identitas->NIP }}" type="text" name="NIP" id="NIP" class="form-control"
                            required>
                        <small id="error-NIP" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input value="{{ $user->identitas->tempat_lahir }}" type="text" name="tempat_lahir"
                                    id="tempat_lahir" class="form-control" required>
                                <small id="error-tempat_lahir" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input value="{{ $user->identitas->tanggal_lahir }}" type="date" name="tanggal_lahir"
                                    id="tanggal_lahir" class="form-control" required>
                                <small id="error-tanggal_lahir" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                    <option value="$user->identitas->jenis_kelamin" disabled selected>-- Pilih Jenis Kelamin --
                                    </option>
                                    <option value="laki"
                                        {{ old('jenis_kelamin', $user->identitas->jenis_kelamin) === 'laki' ? 'selected' : '' }}>
                                        Laki-laki</option>
                                    <option value="perempuan"
                                        {{ old('jenis_kelamin', $user->identitas->jenis_kelamin) === 'perempuan' ? 'selected' : '' }}>
                                        Perempuan</option>
                                </select>
                                <small id="error-jenis_kelamin" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input value="{{ $user->identitas->alamat }}" type="text" name="alamat" id="alamat"
                            class="form-control" required>
                        <small id="error-alamat" class="error-text form-text text-danger"></small>
                    </div>

                    <div>
                        <h4>Detail Kontak</h4>
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepom</label>
                        <input value="{{ $user->identitas->no_telp }}" type="text" name="no_telp" id="no_telp"
                            class="form-control" required>
                        <small id="error-no_telp" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input value="{{ $user->identitas->email }}" type="email" name="email" id="email"
                            class="form-control" required>
                        <small id="error-email" class="error-text form-text text-danger"></small>
                    </div>

                    <div>
                        <h4>Akun Pengguna</h4>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input value="{{ $user->username }}" type="text" name="username" id="username"
                            class="form-control" required>
                        <small id="error-username" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input value="" type="password" name="password" id="password" class="form-control">
                        <small class="form-text text-muted">Abaikan jika tidak ingin ubah password</small>
                        <small id="error-password" class="error-text form-text text-danger"></small>
                    </div>
                    @if (Auth::user()->getRole() == 'DSN')

                    <div class="col">
                        <div class="card card-info">
                            <div class="card-header bg-info" style="height: 60px; padding: 12px">
                                <h3 class="card-title">Mata Kuliah</h3>
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
                            <div class="card-header bg-info" style="height: 60px; padding: 12px">
                                <h3 class="card-title">Bidang Minat</h3>
                            </div>
                            <div class="card-body">
                                @foreach ($user->bidangminat as $bd)
                                    <span class="custom-badge-bd">{{ $bd->nama_bd }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                </div>
                @endif
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
        </div>
    </form>
        
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
                            maxlength: 100,
                            required: true,
                        },
                        NIP: {
                            maxlength: 20,
                            required: true,
                        },
                        tempat_lahir: {
                            maxlength: 20,
                            required: true,
                        },
                        tanggal_lahir: {
                            required: true,
                        },
                        jenis_kelamin: {
                            required: true
                        },
                        alamat: {
                            required: true,
                            maxlength: 100
                        },
                        no_telp: {
                            required: true,
                            number: true,
                            maxlength: 15
                        },
                        email: {
                            required: true,
                            maxlength: 50
                        },
                        username: {
                            required: true,
                            minlength: 3,
                            maxlength: 20
                        },
                        password: {
                            minlength: 5,
                            maxlength: 20
                        },
                        foto_profil: {
                            extension: "jpg|jpeg|png"
                        }
                    },

                    submitHandler: function(form) {

                        var formData = new FormData(form); // Gunakan FormData untuk file upload
                        console.log(...formData);
                        
                        $.ajax({
                            url: form.action,
                            type: form.method,
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                if (response.status) {
                                    // Menampilkan notifikasi berhasil
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message
                                    }).then(function() {
                                        // Reload halaman atau update data setelah Swal ditutup
                                        if (typeof dataUser !== 'undefined') {
                                            dataUser.ajax
                                                .reload(); // Reload data table jika ada
                                        } else {
                                            location
                                                .reload(); // Reload halaman jika tidak ada dataUser
                                        }
                                    });
                                } else {
                                    // Menampilkan error dari validasi field
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
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Terjadi kesalahan. Silakan coba lagi nanti.'
                                });
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
