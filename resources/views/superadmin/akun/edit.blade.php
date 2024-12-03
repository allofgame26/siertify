@empty($akunpengguna)
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
                <a href="{{ url('/akunpengguna') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/akunpengguna/' . $akunpengguna->id_user. '/update') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Akun Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Pengguna</label>
                        <select name="id_identitas" id="id_identitas" class="form-control" required>
                            <option value="">- Pilih Nama -</option>
                            @foreach ($identitas as $l)
                                <option {{ $l->id_identitas == $akunpengguna->id_identitas ? 'selected' : '' }}
                                value="{{ $l->id_identitas }}">{{ $l->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_identitas" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Jenis Pengguna</label>
                        <select name="id_jenis_pengguna" id="id_jenis_pengguna" class="form-control" required>
                            <option value="">- Pilih Jenis Pengguna -</option>
                            @foreach ($jenispengguna as $l)
                                <option {{ $l->id_jenis_pengguna == $akunpengguna->id_jenis_pengguna ? 'selected' : '' }} 
                                value="{{ $l->id_jenis_pengguna }}">{{ $l->nama_jenis_pengguna }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_jenis_pengguna" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input value="{{ $akunpengguna->username }}" type="text" name="username" id="username"
                            class="form-control" placeholder="Enter Username">
                        <small id="error-username" class="error-text form-text text-danger"></small>
                    </div>  
                    <div class="form-group">
                        <label>Password</label>
                        <input value="" type="password" name="password" id="password"
                            class="form-control" placeholder="">
                        <small id="error-password" class="error-text form-text text-danger"></small>
                        <small class="form-text text-muted">Abaikan (jangan diisi) jika tidak ingin
                            mengganti password user.</small>
                    </div> 
                    <div class="form-group">
                        <label>Periode</label>
                        <select name="id_periode" id="id_periode" class="form-control" required>
                            <option value="">- Pilih Periode -</option>
                            @foreach ($periode as $l)
                                <option {{ $l->id_periode == $akunpengguna->id_periode ? 'selected' : '' }} 
                                value="{{ $l->id_periode }}">{{ $l->nama_periode }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_periode" class="error-text form-text text-danger"></small>
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
            $("#form-edit").validate({
                rules: {
                    id_identitas: {
                    required: true,
                    number: true // Validasi tipe integer
                },
                id_jenis_pengguna: {
                    required: true,
                    number: true // Validasi tipe integer
                },
                id_periode: {
                    required: true,
                    number: true // Validasi tipe integer
                },
                username: {
                    required: true,
                    minlength: 5,
                    maxlength: 20,
                },
                password: {
                    minlength: 8,
                    maxlength: 255
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

                                if (typeof datapengguna !== 'undefined') {
                                    datapengguna.ajax.reload(null, false); // Reload tabel tanpa mengubah posisi halaman
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
