<form action="{{ url('/pendataan/sertifikasi/storemk') }}" method="post" id="form-tambah-mk">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Mata Kuliah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-green">
                    <p>Pilih mata kuliah yang relevan dengan riwayat sertifikasi Anda</p>
                </div>
                <div class="form-group">
                    <input type="text" id="search-mk" class="form-control" placeholder="Cari mata kuliah...">
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox-container">
                            @foreach ($mk as $mk)
                                <div id="chk{{ $mk->id_mk }}" class="checkbox-item" value="{{ $mk->nama_mk }}">
                                    <label>
                                        <input type="checkbox" name="id_mk[]" value="{{ $mk->id_mk }}"
                                            @if (in_array($mk->id_mk, session('selected_mk', []))) checked @endif>
                                        {{ $mk->nama_mk }}
                                    </label>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="modal-footer">
                            <button type="button" onclick="modalAction('{{ url('/pendataan/sertifikasi/create_new') }}')"
                                class="btn btn-warning">Kembali</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    .checkbox-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        /* Membuat 2 kolom */
        gap: 10px;
        /* Memberikan jarak antar elemen */
    }

    .checkbox-item {
        display: flex;
        /* Mengatur elemen checkbox agar sejajar dengan label */
        align-items: center;
    }

    .alert-green {
        background-color: #F1FCF2;
        color: #1F7634;
    }
</style>


<script>
    $(document).ready(function() {
        // Cek dan cari mata kuliah
        $('#search-mk').on('keyup', function() {
            var searchTerm = $(this).val().toLowerCase();
            $('.checkbox-item').each(function() {
                var mkName = $(this).text().toLowerCase();
                $(this).toggle(mkName.indexOf(searchTerm) > -1);
            });
        });

        // Validasi form dan kirim data dengan AJAX
        $("#form-tambah-mk").validate({
            rules: {
                // Tambahkan aturan validasi jika perlu
            },
            submitHandler: function(form) {
                console.log('Form is valid'); // Debugging
                console.log(form.action); // Debugging
                console.log(form.method); // Debugging

                let data = $('#form-tambah-mk').find(':input').serializeArray();

                $.ajax({
                    url: form.action, // Mengambil URL dari form action
                    type: form.method, // Mengambil method dari form
                    data: data, // Mengambil data dari form
                    success: function(response) {
                        console.log(response); // Debugging
                        if (response.status) {
                            $('#modal-master').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
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
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText); // Debugging
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal mengirim data.'
                        });
                    }
                });
                return false; // Mencegah form untuk submit secara biasa
            }
        });
    });
</script>
