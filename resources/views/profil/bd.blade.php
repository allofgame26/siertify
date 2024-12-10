<form action="{{ url('/profil/' . $idselected. '/prosesbd') }}" method="POST" id="form-tambah-bd">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Bidang Minat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama User</label>
                    <select name="id_user" id="id_user" class="form-control" readonly>
                        <option value="">- Pilih Nama -</option>
                        @foreach ($akun as $l)
                        <option {{ $l->id_user == $idselected ? 'selected' : '' }}
                        value="{{ $l->id_user }}"> {{ $l->username }} </option>
                        @endforeach
                    </select>
                    <small id="error-id_user" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Bidang Minat</label>
                    <select name="id_bd" id="id_bd" class="form-control" required>
                        <option value="">- Pilih Bidang Minat -</option>
                        @foreach ($bd as $k)
                        <option value="{{ $k->id_bd }}">
                        {{ $k->nama_bd }}
                        </option>
                        @endforeach
                    </select>
                    <small id="error-id_bd" class="error-text form-text text-danger"></small>
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
        // Setup CSRF token untuk setiap AJAX request
        $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

        $("#form-tambah-bd").validate({
            rules: {
                id_user: {
                    required: true,
                    number: true // Validasi tipe integer
                },
                id_bd: {
                    required: true,
                    number: true // Validasi tipe integer
                }
            },
            submitHandler: function(form) {
                console.log('Validasi Berhasil, Form akan disubmit');
                $.ajax({
                    url: $(form).attr('action'), // URL dari atribut action form
                    type: 'POST', // Metode POST
                    data: $(form).serialize(), // Serialize form untuk data request
                    dataType: 'json', // Format data yang diharapkan
                    beforeSend: function() {
                        // Disable tombol submit sebelum proses selesai
                        $('button[type="submit"]').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.status) {
                            // Tutup modal
                            $('#myModal').modal('hide');
                            // Reset form
                            $(form)[0].reset();
                            // Tampilkan pesan sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });

                            // Reload DataTable jika instance tersedia
                            if (typeof databd !== 'undefined') {
                                databd.ajax.reload(null, false); // Reload tabel tanpa mengubah posisi halaman
                            }

                        } else {
                            // Reset error message
                            $('.error-text').text('');
                            // Tampilkan pesan error jika ada
                            if (response.msgField) {
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                            }
                            // Tampilkan alert error
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr.responseJSON);
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: xhr.responseJSON?.message || 'Gagal menyimpan data. Silakan coba lagi.'
                        });
                    },
                    complete: function() {
                        // Aktifkan kembali tombol submit setelah proses selesai
                        $('button[type="submit"]').prop('disabled', false);
                    }
                });
                return false; // Mencegah form submit secara default
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
