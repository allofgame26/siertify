<form action="{{ url('/masterpelatihan/proses') }}" method="POST" id="form-tambah-sertifikasi">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama pelatihan</label>
                    <input value="" type="text" name="nama_pelatihan" id="nama_pelatihan"
                        class="form-control" placeholder="Enter Nama pelatihan" required>
                    <small id="error-nama_pelatihan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jenis Pelatihan Sertifikasi</label>
                    <select name="id_jenis_pelatihan_sertifikasi" id="id_jenis_pelatihan_sertifikasi" class="form-control" required>
                        <option value="">- Pilih Jenis Sertifikasi -</option>
                        @foreach ($jenis as $l)
                            <option value="{{ $l->id_jenis_pelatihan_sertifikasi }}">{{ $l->nama_jenis_sertifikasi }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_jenis_pelatihan_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Vendor</label>
                    <select name="id_vendor_pelatihan" id="id_vendor_pelatihan" class="form-control" required>
                        <option value="">- Pilih Vendor -</option>
                        @foreach ($vendor as $l)
                            <option value="{{ $l->id_vendor_pelatihan }}">{{ $l->nama_vendor_pelatihan }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_vendor_pelatihan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Level Pelatihan</label>
                    <select name="level_pelatihan" id="level_pelatihan" class="form-control" required>
                        <option value="internasional">Internasional</option>
                        <option value="nasional">Nasional</option>
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
        // Setup CSRF token untuk setiap AJAX request
        $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

        $("#form-tambah-sertifikasi").validate({
            rules: {
                nama_pelatihan: {
                    required: true,
                    maxlength: 100,
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
                            if (typeof datapelatihan !== 'undefined') {
                                datapelatihan.ajax.reload(null, false); // Reload tabel tanpa mengubah posisi halaman
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
