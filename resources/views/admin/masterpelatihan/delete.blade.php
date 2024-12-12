@empty($pelatihan)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/masterpelatihan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/masterpelatihan/' . $pelatihan->id_pelatihan . '/delete') }}" method="POST" id="form-delete-pelatihan">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data pelatihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
                        Apakah Anda ingin menghapus data seperti di bawah ini?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">ID:</th>
                            <td class="col-9">{{ $pelatihan->id_pelatihan}}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama pelatihan :</th>
                            <td class="col-9">{{ $pelatihan->firstWhere('id_pelatihan', $pelatihan->id_pelatihan)?->nama_pelatihan ?? 'Tidak Diketahui' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Jenis Pelatihan pelatihan:</th>
                            <td class="col-9">{{ $jenis->firstWhere('id_jenis_pelatihan_sertifikasi', $pelatihan->id_jenis_pelatihan_sertifikasi)?->nama_jenis_sertifikasi ?? 'Tidak Diketahui' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Vendor</th>
                            <td class="col-9">{{ $vendor->firstWhere('id_vendor_pelatihan', $pelatihan->id_vendor_pelatihan)?->nama_vendor_pelatihan ?? 'Tidak Diketahui' }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Level pelatihan</th>
                            <td class="col-9">{{ $pelatihan->level_pelatihan }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-delete-pelatihan").validate({
                rules: {},
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
                                if (typeof datapelatihan !== 'undefined') {
                                    datapelatihan.ajax.reload(null, false); // Reload tabel tanpa mengubah posisi halaman
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