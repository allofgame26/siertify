<<<<<<< HEAD
<form action="{{ url('/jenispengguna/import_proses') }}" method="POST" id="form-import" enctype="multipart/form-data">
=======
<form action="{{ url('/datapengguna/import_proses') }}" method="POST" id="form-import" enctype="multipart/form-data">
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data jenis</h5>
                <button type="button" class="close" data-dismiss="modal" arialabel="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Download Template</label>
<<<<<<< HEAD
                    <a href="{{ asset('template_jenispenggunasuperadmin.xlsx') }}" class="btn btn-info btn-sm" download><i class="fa fa-file-excel"></i>  Download</a>
=======
                    <a href="{{ asset('template_datapengguna.xlsx') }}" class="btn btn-info btn-sm" download><i class="fa fa-file-excel"></i>  Download</a>
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
                    <small id="error-kategori_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Pilih File</label>
<<<<<<< HEAD
                    <input type="file" name="file_jenispengguna" id="file_jenispengguna" class="formcontrol" required>
=======
                    <input type="file" name="file_datapengguna" id="file_datapengguna" class="formcontrol" required>
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
                    <small id="error-file_datapengguna" class="error-text form-text textdanger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btnwarning">Batal</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </div>
</form>
<style>
    .form-group .btn i {
    margin-right: 5px;
}
</style>
<script>
    $(document).ready(function() {

        $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

        $("#form-import").validate({
            rules: {
<<<<<<< HEAD
                file_jenispengguna: {
=======
                file_jenis: {
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
                    required: true,
                    extension: "xlsx"
                },
            },
            submitHandler: function(form) {
                var formData = new FormData(form); // Jadikan form ke FormData untuk menghandle file
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData, // Data yang dikirim berupa FormData
                    processData: false, // setting processData dan contentType ke false, untuk menghandle file
                    contentType: false,
                    success: function(response) {
                        if (response.status) { // jika sukses
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            }).then(function() {
                                    // Reload halaman atau update data setelah Swal ditutup
<<<<<<< HEAD
                                    if (typeof datajenispengguna !== 'undefined') {
                                        datajenispengguna.ajax
=======
                                    if (typeof datapengguna !== 'undefined') {
                                        datapengguna.ajax
>>>>>>> 3a2ea7e6cf5887fb28adc3b8a3e7a744c4e6e93d
                                    .reload(); // Reload data table jika ada
                                    } else {
                                        location
                                    .reload(); // Reload halaman jika tidak ada tablejenis
                                    }
                                });e
                        } else { // jika error
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
