<form action="{{ url('/pendataan/sertifikasi/ajax') }}" method="post" id="form-tambah-sertifikasi" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Riwyat Sertifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-8">
                        <p>Detail Sertifikasi</p>
                    </div>
                    <div class="col-4" style="padding-left: 50px">
                        <button onclick="modalAction('{{ url('/pendataan/sertifikasi/create_new') }}')"
                            class="btn btn-info btn-sm"><i class="fas fa-plus-square"
                                style="margin-right: 8px;"></i>Tambah Sertifikasi Baru</button>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama Sertifikasi</label>
                    <select name="id_sertifikasi" id="id_sertifikasi" class="form-control" required>
                        <option value="">- Pilih Nama -</option>
                        @foreach ($sertifikasi as $l)
                            <option value="{{ $l->id_sertifikasi }}"
                                data-level="{{ $l->level_sertifikasi }}" 
                                data-jenis="{{ $l->nama_jenis_sertifikasi }}"
                                data-vendor="{{ $l->nama_vendor_sertifikasi }}">
                                {{ $l->nama_sertifikasi }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Vendor Sertifikasi</label>
                    <input value="" type="text" name="nama_vendor_sertifikasi" id="nama_vendor_sertifikasi"
                        class="form-control" placeholder="" required>
                    <small id="error-nama_vendor_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Level Sertifikasi</label>
                            <input value="" type="text" name="level_sertifikasi" id="level_sertifikasi"
                                class="form-control" placeholder="" readonly>
                            <small id="error-level_sertifikasi" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Jenis Sertifikasi</label>
                            <input value="" type="text" name="id_jenis_pelatihan_sertifikasi" id="id_jenis_pelatihan_sertifikasi"
                                class="form-control" placeholder="" readonly>
                            <small id="error-jenis_sertifikasi" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    </div>
                    <div class="form-group">
                            <label>Biaya Sertifikasi</label>
                            <input value="" type="number" name="biaya" id="biaya"
                                class="form-control" placeholder="Enter biaya sertifikasi" required>
                            <small id="error-biaya" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Lokasi Sertifikasi</label>
                            <input value="" type="text" name="lokasi" id="lokasi"
                                class="form-control" placeholder="Enter lokasi sertifikasi" required>
                            <small id="error-lokasi" class="error-text form-text text-danger"></small>
                        </div>
                <p>Jadwal Sertifikasi</p>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Periode</label>
                            <select class="form-control" required name="id_periode" id="id_periode">
                                <option value="">- Pilih periode -</option>
                                @foreach ($periode as $p)
                                <option value="{{ $p->id_periode }}">{{ $p->nama_periode }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input value="" type="date" name="tanggal_mulai" id="tanggal_mulai"
                                class="form-control" required>
                            <small id="error-tanggal_mulai" class="error-text form-text text-danger"></small>
                        </div>

                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input value="" type="date" name="tanggal_selesai" id="tanggal_selesai"
                                class="form-control" required>
                            <small id="error-tanggal_selesai" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
                <div>
                    <p>Bukti Sertifikasi</p>
                </div>
                <div class="form-group">
                    <label>Tanggal Kadaluarsa Sertifikasi</label>
                    <input value="" type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa"
                        class="form-control" required>
                    <small id="error-tanggal_kadaluarsa" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nomor Sertifikat</label>
                    <input value="" type="text" name="no_sertifikasi" id="no_sertifikasi"
                        class="form-control" placeholder="Enter nomor sertifikat" required>
                    <small id="error-no_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Bukti Sertifikat</label>
                    <input type="file" name="bukti_sertifikasi" id="bukti_sertifikasi" class="formcontrol" required>
                    <small id="error-bukti_sertifikasi" class="error-text form-text textdanger"></small>
                </div>
                <input type="hidden" name="input_by" value="{{ Auth::user()->getRole() == 'DSN' ? 'dosen' : '' }}">

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

    .form-control[readonly] {
            background-color: #fff;
            /* Tetap putih */
            color: #495057;
            /* Warna teks default AdminLTE */
            opacity: 1;
            /* Hilangkan efek transparansi */
            cursor: not-allowed;
            /* Tunjukkan bahwa elemen ini tidak dapat diedit */
        }
</style>

<script>
    $(document).ready(function() {

        $('#id_sertifikasi').on('change', function() {
            // Ambil opsi yang dipilih
            let selectedOption = $(this).find(':selected');
            let level = selectedOption.data('level');
            let jenis = selectedOption.data('jenis');
            let vendor = selectedOption.data('vendor');
  
            // Set nilai ke input atau dropdown lain
            $('#level_sertifikasi').val(level); // Pilih level di dropdown
            $('#id_jenis_pelatihan_sertifikasi').val(jenis); // Isi input jenis sertifikasi
            $('#nama_vendor_sertifikasi').val(vendor); // Isi input jenis sertifikasi
        });

        $("#form-tambah-sertifikasi").validate({
            rules: {
                id_sertifikasi: {
                    required: true,
                    number: true 
                },
                id_periode: {
                    required: true,
                },
                tanggal_mulai: {
                    required: true,

                },
                tanggal_selesai: {
                    required: true
                },
                lokasi: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                biaya: {
                    required: true,
                    number: true,
                },
                no_sertifikasi: {
                    minlength: 1,
                    maxlength: 20,
                    required: true,

                },
                bukti_sertifikasi: {
                    required: true, 
                    extension: "pdf|jpg|jpeg|png"
                },
                tanggal_kadaluarsa: {
                    required: true
                }

            },
            submitHandler: function(form) {

                var formData = new FormData(form); // Gunakan FormData untuk file upload

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            }).then(function() {
                                    // Reload halaman atau update data setelah Swal ditutup
                                    if (typeof tablesertifikasi !== 'undefined') {
                                        tablesertifikasi.ajax
                                    .reload(); // Reload data table jika ada
                                    } else {
                                        location
                                    .reload(); // Reload halaman jika tidak ada tablevendor
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
