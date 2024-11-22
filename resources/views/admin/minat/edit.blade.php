@empty($minat)
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
                    Data bidang minat yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/minat') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/minat/' . $minat->id_bd. '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data minat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Bidang Minat</label>
                        <input value="{{ $minat->nama_bd }}" type="text" name="nama_bd"
                            id="nama_bd" class="form-control" required>
                        <small id="error-nama_bd" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Kode Bidang Minat</label>
                        <input value="{{ $minat->kode_bd }}" type="text" name="kode_bd"
                            id="kode_bd" class="form-control" required>
                        <small id="error-kode_bd" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input value="{{ $minat->deskripsi_bd }}" type="text" name="deskripsi_bd" id="deskripsi_bd"
                            class="form-control" required>
                        <small id="error-deskripsi_bd" class="error-text form-text text-danger"></small>
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
                    nama_minat_sertifikasi: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                kode_bd: {
                    required: true,
                    minlength: 1,
                    maxlength: 10
                },
                deskripsi_pendek: {
                    minlength: 1,
                    maxlength: 255,
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
                                });
                                dataminat.ajax.reload();
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
