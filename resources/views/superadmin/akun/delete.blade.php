<<<<<<< HEAD
@empty($jenispengguna)
=======
@empty($datapengguna)
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
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
<<<<<<< HEAD
                <a href="{{ url('/jenispengguna') }}" class="btn btn-warning">Kembali</a>
=======
                <a href="{{ url('/datapengguna') }}" class="btn btn-warning">Kembali</a>
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
            </div>
        </div>
    </div>
@else
<<<<<<< HEAD
    <form action="{{ url('/jenispengguna/' . $jenispengguna->id_jenis_pengguna . '/delete') }}" method="POST" id="form-delete-jenispengguna">
=======
    <form action="{{ url('/datapengguna/' . $datapengguna->id_identitas . '/delete') }}" method="POST" id="form-delete-datapengguna">
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
<<<<<<< HEAD
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data jenis Pengguna</h5>
=======
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data jenis</h5>
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
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
<<<<<<< HEAD
                            <td class="col-9">{{ $jenispengguna->id_jenis_pengguna}}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Jenis Pengguna :</th>
                            <td class="col-9">{{ $jenispengguna->nama_jenis_pengguna }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Kode Jenis Pengguna :</th>
                            <td class="col-9">{{ $jenispengguna->kode_jenis_pengguna }}</td>
=======
                            <td class="col-9">{{ $datapengguna->id_identitas}}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Nama Lengkap :</th>
                            <td class="col-9">{{ $datapengguna->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">NIP :</th>
                            <td class="col-9">{{ $datapengguna->NIP }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Alamat :</th>
                            <td class="col-9">{{ $datapengguna->alamat }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">E - Mail :</th>
                            <td class="col-9">{{ $datapengguna->email }}</td>
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
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
<<<<<<< HEAD

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

            $("#form-delete-jenispengguna").validate({
=======
            $("#form-delete-datapengguna").validate({
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
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
<<<<<<< HEAD

                                if (typeof datajenispengguna !== 'undefined') {
                                    datajenispengguna.ajax.reload(null, false); // Reload tabel tanpa mengubah posisi halaman
                            }

=======
                                if (typeof datapengguna !== 'undefined') {
                                    datapengguna.ajax.reload(null, false); // Reload tabel tanpa mengubah posisi halaman
                            }
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
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