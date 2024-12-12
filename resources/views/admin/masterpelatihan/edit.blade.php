@empty($pelatihan)
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
                    Data pelatihan yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/masterpelatihan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/masterpelatihan/' . $pelatihan->id_pelatihan. '/update') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Master pelatihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama pelatihan</label>
                        <input value="{{ $pelatihan->nama_pelatihan }}" type="text" name="nama_pelatihan" id="nama_pelatihan"
                            class="form-control" placeholder="Enter Nama pelatihan" required>
                        <small id="error-nama_pelatihan" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Jenis Pelatihan Sertifikasi</label>
                        <select name="id_jenis_pelatihan_sertifikasi" id="id_jenis_pelatihan_sertifikasi" class="form-control" required>
                            <option value="">- Pilih Jenis pelatihan -</option>
                            @foreach ($jenis as $l)
                                <option {{ $l->id_jenis_pelatihan_sertifikasi == $pelatihan->id_jenis_pelatihan_sertifikasi ? 'selected' : '' }}
                                value="{{ $l->id_jenis_pelatihan_sertifikasi }}">{{ $l->nama_jenis_sertifikasi }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_jenis_pelatihan_sertifikasi" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Vendor</label>
                        <select name="id_vendor_pelatihan" id="id_vendor_pelatihan" class="form-control" required>
                            <option value="">- Pilih Vendor -</option>
                            @foreach ($vendor as $l)
                                <option {{ $l->id_vendor_pelatihan == $pelatihan->id_vendor_pelatihan ? 'selected' : '' }} 
                                value="{{ $l->id_vendor_pelatihan }}">{{ $l->nama_vendor_pelatihan }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_vendor_pelatihan" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Level pelatihan</label>
                        <select name="level_pelatihan" id="level_pelatihan" class="form-control" required>
                            <option  value="internasional" {{ $pelatihan->level_pelatihan == 'internasional' ? 'selected' : '' }}>Internasional</option>
                            <option value="nasional" {{ $pelatihan->level_pelatihan == 'nasional' ? 'selected' : '' }}>Nasional</option>
                        </select>
                        <small id="error-level_pelatihan" class="error-text form-text text-danger"></small>
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
                    nama_pelatihan: {
                    required: true,
                    maxlength: 40,
                },
                id_jenis_pelatihan_sertifikasi: {
                    required: true,
                    number: true // Validasi tipe integer
                },
                id_vendor_pelatihan: {
                    required: true,
                    number: true // Validasi tipe integer
                },
                level_pelatihan: {
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

                                if (typeof pelatihan !== 'undefined') {
                                    pelatihan.ajax.reload(null, false); // Reload tabel tanpa mengubah posisi halaman
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
