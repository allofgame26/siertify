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
                    Data Akun Pengguna yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/akunpengguna') }}" class="btn btn-info">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="" method="POST" id="form-show">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Jenis Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Pengguna</label>
                        <select name="id_identitas" id="id_identitas" class="form-control" readonly>
                            <option value="">- Pilih Nama -</option>
                            @foreach ($identitas as $l)
                                <option {{ $l->id_identitas == $akunpengguna->id_identitas ? 'selected' : '' }}
                                value="{{ $l->id_identitas }}">{{ $l->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="id_identitas" value="{{ $akunpengguna->id_identitas }}">
                        <small id="error-id_identitas" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Jenis Pengguna</label>
                        <select name="id_jenis_pengguna" id="id_jenis_pengguna" class="form-control" readonly>
                            <option value="">- Pilih Jenis Pengguna -</option>
                            @foreach ($jenispengguna as $l)
                                <option {{ $l->id_jenis_pengguna == $akunpengguna->id_jenis_pengguna ? 'selected' : '' }} 
                                value="{{ $l->id_jenis_pengguna }}">{{ $l->nama_jenis_pengguna }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="id_jenis_pengguna" value="{{ $akunpengguna->id_jenis_pengguna }}">
                        <small id="error-id_jenis_pengguna" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Periode</label>
                        <select name="id_periode" id="id_periode" class="form-control" readonly>
                            <option value="">- Pilih Periode -</option>
                            @foreach ($periode as $l)
                                <option {{ $l->id_periode == $akunpengguna->id_periode ? 'selected' : '' }} 
                                value="{{ $l->id_periode }}">{{ $l->nama_periode }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="id_periode" value="{{ $akunpengguna->id_periode }}">
                        <small id="error-id_periode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input value="{{ $akunpengguna->username }}" type="text" name="username" id="username"
                            class="form-control" placeholder="Enter Username" readonly>
                        <small id="error-username" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
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
    <script>
        $(document).ready(function() {
            $("#form-show").validate({
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
                                }).then(function() {
                                    // Reload halaman atau update data setelah Swal ditutup
                                    if (typeof tableakunpengguna !== 'undefined') {
                                        tableakunpengguna.ajax
                                            .reload(); // Reload data table jika ada
                                    } else {
                                        location
                                            .reload(); // Reload halaman jika tidak ada tablevendor
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
