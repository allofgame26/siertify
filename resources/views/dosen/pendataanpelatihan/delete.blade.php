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
                <a href="{{ url('/pendataan/pelatihan/') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/pendataan/pelatihan/' . $pelatihan->id_detail_pelatihan . '/delete') }}" method="POST" id="form-delete-pelatihan">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Riwayat Pelatihan</h5>
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
                            <th class="text-right col-3">Nama pelatihan :</th>
                            <td class="col-9">{{ $pelatihan->nama_pelatihan}}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Vendor pelatihan :</th>
                            <td class="col-9">{{ $pelatihan->nama_vendor_pelatihan }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Periode pelatihan :</th>
                            <td class="col-9">{{ $pelatihan->nama_periode}}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Lokasi :</th>
                            <td class="col-9">{{ $pelatihan->lokasi }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nomor Sertifikat :</th>
                            <td class="col-9">{{ $pelatihan->no_pelatihan }}</td>
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
                                }).then(function() {
                                    // Reload halaman atau update data setelah Swal ditutup
                                    if (typeof tablepelatihan !== 'undefined') {
                                        tablepelatihan.ajax
                                    .reload(); // Reload data table jika ada
                                    } else {
                                        location
                                    .reload(); // Reload halaman jika tidak ada tablepelatihan
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