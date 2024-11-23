@empty($periode)
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
                    Data periode yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/periode') }}" class="btn btn-info">Kembali</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Detail periode Pelatihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Periode</label>
                        <input value="{{ $periode->nama_periode }}" type="text" name="nama_periode" id="nama_periode" class="form-control"
                            placeholder="Enter Nama Periode" readonly>
                        <small id="error-nama_periode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input value="{{ $periode->tanggal_mulai }}" type="date" name="tanggal_mulai" id="tanggal_mulai"
                        class="form-control" placeholder="Pilih tanggal" readonly>
                        <small id="error-tanggal_mulai" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input value="{{ $periode->tanggal_selesai }}" type="date" name="tanggal_selesai" id="tanggal_selesai"
                        class="form-control" placeholder="Pilih tanggal" readonly>
                        <small id="error-tanggal_selesai" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tahun Periode</label>
                        <input value="{{ $periode->tahun_periode }}" type="text" name="tahun_periode" id="tahun_periode"
                            class="form-control" placeholder="Enter Tahun Periode" readonly>
                        <small id="error-tahun_periode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Periode</label>
                        <input value="{{ $periode->deskripsi_periode }}" type="text" name="deskripsi_periode" id="deskripsi_periode"
                            class="form-control" placeholder="Enter Deskripsi Periode" readonly>
                        <small id="error-deskripsi_periode" class="error-text form-text text-danger"></small>
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
                    nama_periode_pelatihan: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    alamat_periode_pelatihan: {
                        minlength: 3,
                        maxlength: 255,
                        required: true,
                    },
                    kota_periode_pelatihan: {
                        minlength: 3,
                        maxlength: 25,
                        required: true,
                    },
                    notelp_periode_pelatihan: {
                        minlength: 1,
                        maxlength: 15,
                        required: true,
                    },
                    web_periode_pelatihan: {
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
                                    if (typeof tableperiode !== 'undefined') {
                                        tableperiode.ajax
                                            .reload(); // Reload data table jika ada
                                    } else {
                                        location
                                            .reload(); // Reload halaman jika tidak ada tableperiode
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
