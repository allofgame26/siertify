<form action="{{ url('/matkul/import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data Mata Kuliah</h5>
                <button type="button" class="close" data-dismiss="modal" arialabel="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Download Template</label>
                    <a href="{{ asset('template_matkul.xlsx') }}" class="btn btn-info btn-sm" download><i class="fa fa-file-excel"></i>  Download</a>
                    <small id="error-kategori_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Pilih File</label>
                    <input type="file" name="file_matkul" id="file_matkul" class="formcontrol" required>
                    <small id="error-file_matkul" class="error-text form-text textdanger"></small>
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
        $("#form-import").validate({
            rules: {
                file_matkul: {
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
                                    if (typeof tablematkul !== 'undefined') {
                                        tablematkul.ajax
                                    .reload(); // Reload data table jika ada
                                    } else {
                                        location
                                    .reload(); // Reload halaman jika tidak ada tablematkul
                                    }
                                });
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