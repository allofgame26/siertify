@empty($sertifikasi)
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
                    Data Sertifikasi yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/sertifikasi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/sertifikasi/' . $sertifikasi->id_sertifikasi. '/update') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Master Sertifikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Sertifikasi</label>
                        <input value="{{ $sertifikasi->nama_sertifikasi }}" type="text" name="nama_sertifikasi" id="nama_sertifikasi"
                            class="form-control" placeholder="Enter Nama Sertifikasi" required>
                        <small id="error-nama_sertifikasi" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Jenis Pelatihan Sertifikasi</label>
                        <select name="id_jenis_pelatihan_sertifikasi" id="id_jenis_pelatihan_sertifikasi" class="form-control" required>
                            <option value="">- Pilih Jenis Sertifikasi -</option>
                            @foreach ($jenis as $l)
                                <option {{ $l->id_jenis_pelatihan_sertifikasi == $sertifikasi->id_jenis_pelatihan_sertifikasi ? 'selected' : '' }}
                                value="{{ $l->id_jenis_pelatihan_sertifikasi }}">{{ $l->nama_jenis_sertifikasi }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_jenis_pelatihan_sertifikasi" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Vendor</label>
                        <select name="id_vendor_sertifikasi" id="id_vendor_sertifikasi" class="form-control" required>
                            <option value="">- Pilih Vendor -</option>
                            @foreach ($vendor as $l)
                                <option {{ $l->id_vendor_sertifikasi == $sertifikasi->id_vendor_sertifikasi ? 'selected' : '' }} 
                                value="{{ $l->id_vendor_sertifikasi }}">{{ $l->nama_vendor_sertifikasi }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_vendor_sertifikasi" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Level Sertifikasi</label>
                        <select name="level_sertifikasi" id="level_sertifikasi" class="form-control" required>
                            <option  value="internasional" {{ $sertifikasi->level_sertifikasi == 'internasional' ? 'selected' : '' }}>Internasional</option>
                            <option value="nasional" {{ $sertifikasi->level_sertifikasi == 'nasional' ? 'selected' : '' }}>Nasional</option>
                        </select>
                        <small id="error-level_sertifikasi" class="error-text form-text text-danger"></small>
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
                    nama_sertifikasi: {
                    required: true,
                    maxlength: 40,
                },
                id_jenis_pelatihan_sertifikasi: {
                    required: true,
                    number: true // Validasi tipe integer
                },
                id_vendor_sertifikasi: {
                    required: true,
                    number: true // Validasi tipe integer
                },
                level_sertifikasi: {
                    required: true,
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

                                if (typeof sertifikasi !== 'undefined') {
                                    sertifikasi.ajax.reload(null, false); // Reload tabel tanpa mengubah posisi halaman
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
