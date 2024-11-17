<form action="{{ url('/vendor/sertifikasi/ajax') }}" method="post" id="form-tambah-vendor">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Vendor Sertifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Vendor Sertifikasi</label>
                    <input value="" type="text" name="nama_vendor_sertifikasi" id="nama_vendor_sertifikasi"
                        class="form-control" placeholder="Enter nama vendor" required>
                    <small id="error-nama_vendor_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-8">
                            <label>Alamat Vendor</label>
                            <input value="" type="text" name="alamat_vendor_sertifikasi"
                                id="alamat_vendor_sertifikasi" class="form-control" placeholder="Enter alamat" required>
                            <small id="error-alamat_vendor_sertifikasi" class="error-text form-text text-danger"></small>

                        </div>
                        <div class="col-4">
                            <label>Kota Vendor</label>
                            <input value="" type="text" name="kota_vendor_sertifikasi" id="kota_vendor_sertifikasi"
                                class="form-control" placeholder="Enter kota" required>
                            <small id="error-kota_vendor_sertifikasi" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input value="" type="text" name="notelp_vendor_sertifikasi" id="notelp_vendor_sertifikasi"
                        class="form-control" placeholder="Enter nomor telepon" required>
                    <small id="error-notelp_vendor_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Alamat Website</label>
                    <input value="" type="text" name="web_vendor_sertifikasi" id="web_vendor_sertifikasi"
                        class="form-control" placeholder="Enter alamat web" required>
                    <small id="error-web_vendor_sertifikasi" class="error-text form-text text-danger"></small>
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
        $("#form-tambah-vendor").validate({
            rules: {
                nama_vendor_sertifikasi: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                alamat_vendor_sertifikasi: {
                    minlength: 3,
                    maxlength: 255,
                    required: true,
                },
                kota_vendor_sertifikasi: {
                    minlength: 3,
                    maxlength: 25,
                    required: true,
                },
                notelp_vendor_sertifikasi: {
                    minlength: 1,
                    maxlength: 15,
                    required: true,
                  
                },
                web_vendor_sertifikasi: {
                    minlength: 1,
                    maxlength: 30,
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
                            datavendor.ajax.reload();
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
