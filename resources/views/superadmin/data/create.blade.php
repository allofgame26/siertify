<form action="{{ url('/datapengguna/proses') }}" method="post" id="form-tambah-datapengguna" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Pilih Foto Profil</label>
                    <input type="file" name="foto_profil" id="foto_profil" class="form-control">
                    <small id="error-foto_profil" class="error-text form-text textdanger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input value="" type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                        placeholder="Enter Nama Lengkap" required>
                    <small id="error-nama_lengkap" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nomor Induk Pengajar (NIP)</label>
                    <input value="" type="text" name="NIP" id="NIP" class="form-control"
                        placeholder="Enter NIP" required>
                    <small id="error-NIP" class="error-text form-text text-danger"></small>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input value="" type="text" name="tempat_lahir" id="tempat_lahir"
                                class="form-control" placeholder="Enter Tempat Lahir" required>
                            <small id="error-tempat_lahir" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tangal Lahir</label>
                            <input value="" type="date" name="tanggal_lahir" id="tanggal_lahir"
                                class="form-control" placeholder="Pilih tanggal" required>
                            <small id="error-tanggal_lahir" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="laki">Laki-Laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                            <small id="error-jenis_kelamin" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input value="" type="text" name="alamat" id="alamat" class="form-control"
                        placeholder="Enter Alamat" required>
                    <small id="error-alamat" class="error-text form-text text-danger"></small>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nomor Telepon</label>
                            <input value="" type="text" name="no_telp" id="no_telp" class="form-control"
                                placeholder="Enter Nomor Telefon" required>
                            <small id="error-no_telp" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>E-mail</label>
                            <input value="" type="text" name="email" id="email" class="form-control"
                                placeholder="Enter E - Mail" required>
                            <small id="error-email" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
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

        // // Mengganti foto profil langsung ketika memilih file baru
        // $("#foto_profil").change(function() {
        //     const reader = new FileReader();
        //     reader.onload = function(e) {
        //         $('#current-foto_profil').attr('src', e.target
        //         .result); // Mengganti src gambar profil saat ini
        //     }
        //     reader.readAsDataURL(this.files[0]);
        // });

        $("#form-tambah-datapengguna").validate({
            rules: {
                nama_lengkap: {
                    required: true,
                    minlength: 10,
                    maxlength: 100
                },
                NIP: {
                    required: true,
                    minlength: 10,
                    maxlength: 20
                },
                tempat_lahir: {
                    required: true,
                    minlength: 5,
                    maxlength: 10
                },
                tanggal_lahir: {
                    required: true,
                    date: true,
                },
                jenis_kelamin: {
                    required: true,
                },
                alamat: {
                    required: true,
                    minlength: 10,
                    maxlength: 100
                },
                no_telp: {
                    required: true,
                    minlength: 10,
                    maxlength: 15
                },
                email: {
                    required: true,
                    email: true,
                    minlength: 10,
                    maxlength: 50
                },
                foto_profil: {
                    extension: "jpg|jpeg|png"
                }
            },
            submitHandler: function(form) {

                var formData = new FormData(form); // Gunakan FormData untuk file upload
                console.log('Validasi Berhasil, Form akan disubmit');

                $.ajax({
                    url: form.action, // URL dari atribut action form
                    type: form.method, // Metode POST
                    data: formData,
                    contentType: false,
                processData: false,
                    dataType: 'json', // Format data yang diharapkan
                    // contentType: false,
                    // processData: false:
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
                            }).then(function() {
                                // Reload halaman atau update data setelah Swal ditutup
                                if (typeof datapengguna !== 'undefined') {
                                    datapengguna.ajax.reload(); // Reload data table jika ada
                                } else {
                                    location.reload(); // Reload halaman jika tidak ada dataUser
                                }
                            });
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
                            text: xhr.responseJSON?.message ||
                                'Gagal menyimpan data. Silakan coba lagi.'
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
