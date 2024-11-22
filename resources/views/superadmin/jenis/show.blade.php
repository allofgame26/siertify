@empty($jenispengguna)
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
                    Data Jenis Pengguna yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/vendor/pelatihan/') }}" class="btn btn-info">Kembali</a>
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
                        <label>ID Jenis Pengguna</label>
                        <input value="{{ $jenispengguna->id_jenis_pengguna }}" type="text" name="id_jenis_pengguna"
                            id="id_jenis_pengguna" class="form-control" readonly>
                        <small id="error-id_jenis_pengguna" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Nama Jenis Pengguna</label>
                        <input value="{{ $jenispengguna->nama_jenis_pengguna }}" type="text" name="jenispengguna"
                            id="jenispengguna" class="form-control" readonly>
                        <small id="error-jenispengguna" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Kode Jenis Pengguna</label>
                        <input value="{{ $jenispengguna->kode_jenis_pengguna}}" type="text" name="kode_jenis_pengguna" id="kode_jenis_pengguna" class="form-control" placeholder="Enter Jenis Pengguna" readonly>
                        <small id="error-kode_jenis_pengguna" class="error-text form-text text-danger"></small>
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
                    nama_vendor_pelatihan: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    alamat_vendor_pelatihan: {
                        minlength: 3,
                        maxlength: 255,
                        required: true,
                    },
                    kota_vendor_pelatihan: {
                        minlength: 3,
                        maxlength: 25,
                        required: true,
                    },
                    notelp_vendor_pelatihan: {
                        minlength: 1,
                        maxlength: 15,
                        required: true,
                    },
                    web_vendor_pelatihan: {
                        minlength: 1,
                        maxlength: 30,
                        required: true,

                    },
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
                                    if (typeof tablevendor !== 'undefined') {
                                        tablevendor.ajax
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
