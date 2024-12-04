@empty($user)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/pengajuan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/pengajuan/' . $pengajuan->id_pelatihan . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Pengajuan Pelatihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label>Nama Pelatihan</label>
                    <input value="{{ $pengajuan->nama_pelatihan }}" type="text" name="nama_pelatihan" id="nama_pelatihan"
                        class="form-control" required>
                    <small id="error-username" class="error-text form-text text-danger"></small>
                </div>
                    <div class="form-group">
                        <label>Level</label>
                        <select name="level_pelatihan" id="level_pelatihan" class="form-control" required>
                            <option value="">- Pilih Level -</option>
                            @foreach ($level as $l)
                                <option {{ $l->level_pelatihan == $pengajuan->id_pelatihan ? 'selected' : '' }} value="{{ $l->id_pelatihan }}">
                                    {{ $l->level_pelatihan }}</option>
                            @endforeach
                        </select>
                        <small id="error-id_pelatihan" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                      <label>Jenis Pelatihan</label>
                      <select name="nama_jenis_sertifikasi" id="nama_jenis_sertifikasi" class="form-control" required>
                          <option value="">- Pilih Jenis Pelatihan -</option>
                          @foreach ($jenis as $l)
                              <option {{ $l->nama_jenis_sertifikasi == $pengajuan->id_jenis_pelatihan_sertifikasi ? 'selected' : '' }} value="{{ $l->id_jenis_pelatihan_sertifikasi }}">
                                  {{ $l->nama_jenis_sertifikasi }}</option>
                          @endforeach
                      </select>
                      <small id="error-id_jenis_pelatihan_sertifikasi" class="error-text form-text text-danger"></small>
                  </div>
                  <div class="form-group">
                    <label>Vendor Pelatihan</label>
                    <select name="nama_vendor_pelatihan" id="nama_vendor_pelatihan" class="form-control" required>
                        <option value="">- Pilih Vendor Pelatihan -</option>
                        @foreach ($vendor as $l)
                            <option {{ $l->nama_vendor_pelatihan == $pengajuan->id_vendor_pelatihan ? 'selected' : '' }} value="{{ $l->id_vendor_pelatihan }}">
                                {{ $l->nama_vendor_pelatihan }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_vendor_pelatihan" class="error-text form-text text-danger"></small>
                </div>
                    <div class="form-group">
                        <label>Lokasi</label>
                        <input value="{{ $pengajuan->lokasi }}" type="text" name="lokasi" id="lokasi"
                            class="form-control" required>
                        <small id="error-lokasi" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Biaya Pelatihan</label>
                        <input value="{{ $pengajuan->biaya }}" type="text" name="biaya" id="biaya" class="form-control"
                            required>
                        <small id="error-biaya" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Peserta</label>
                        <input value="{{ $pengajuan->quota_peserta }}" type="text" name="quota_peserta" id="quota_peserta" class="form-control"
                            required>
                        <small id="error-quota_peserta" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-edit").validate({
                rules: {
                    level_id: {
                        required: true,
                        number: true
                    },
                    username: {
                        required: true,
                        minlength: 3,
                        maxlength: 20
                    },
                    nama: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    password: {
                        minlength: 6,
                        maxlength: 20
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
                                dataUser.ajax.reload();
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