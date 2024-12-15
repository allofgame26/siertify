<form action="{{ url('/pendataan/pelatihan/ajax') }}" method="post" id="form-tambah-pelatihan" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Riwyat Pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-8">
                        <p>Detail Pelatihan</p>
                    </div>
                    <div class="col-4" style="padding-left: 50px">
                        <button onclick="modalAction('{{ url('/pendataan/pelatihan/create_new') }}')"
                            class="btn btn-info btn-sm"><i class="fas fa-plus-square"
                                style="margin-right: 8px;"></i>Tambah Pelatihan Baru</button>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama Pelatihan</label>
                    <select name="id_pelatihan" id="id_pelatihan" class="form-control" required>
                        <option value="">- Pilih Nama -</option>
                        @foreach ($pelatihan as $l)
                            <option value="{{ $l->id_pelatihan }}"
                                data-level="{{ $l->level_pelatihan }}" 
                                data-jenis="{{ $l->nama_jenis_sertifikasi }}"
                                data-vendor="{{ $l->nama_vendor_pelatihan }}">
                                {{ $l->nama_pelatihan }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_pelatihan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Vendor Pelatihan</label>
                    <input value="" type="text" name="vendor_pelatihan" id="vendor_pelatihan"
                        class="form-control" placeholder="" required>
                    <small id="error-nama_vendor_pelatihan" class="error-text form-text text-danger"></small>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Level Pelatihan</label>
                            <input value="" type="text" name="level_pelatihan" id="level_pelatihan"
                                class="form-control" placeholder="" readonly>
                            <small id="error-level_pelatihan" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Jenis Pelatihan</label>
                            <input value="" type="text" name="jenis_pelatihan" id="jenis_pelatihan"
                                class="form-control" placeholder="" readonly>
                            <small id="error-jenis_pelatihan" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
                    <div class="form-group">
                            <label>Biaya Pelatihan</label>
                            <input value="" type="number" name="biaya" id="biaya"
                                class="form-control" placeholder="Enter biaya pelatihan" required>
                            <small id="error-biaya" class="error-text form-text text-danger"></small>
                        </div>
                        <div class="form-group">
                            <label>Lokasi Pelatihan</label>
                            <input value="" type="text" name="lokasi" id="lokasi"
                                class="form-control" placeholder="Enter lokasi pelatihan" required>
                            <small id="error-lokasi" class="error-text form-text text-danger"></small>
                        </div>
                <p>Jadwal Pelatihan</p>
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
                    <p>Bukti Pelatihan</p>
                </div>
                <div class="form-group">
                    <label>Nomor Sertifikat</label>
                    <input value="" type="text" name="no_pelatihan" id="no_pelatihan"
                        class="form-control" placeholder="Enter nomor sertifikat" required>
                    <small id="error-no_pelatihan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Bukti Sertifikat</label>
                    <input type="file" name="bukti_pelatihan" id="bukti_pelatihan" class="formcontrol" required>
                    <small id="error-bukti_pelatihan" class="error-text form-text textdanger"></small>
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

        $('#id_pelatihan').on('change', function() {
            // Ambil opsi yang dipilih
            let selectedOption = $(this).find(':selected');
            let level = selectedOption.data('level');
            let jenis = selectedOption.data('jenis');
            let vendor = selectedOption.data('vendor');

            // Set nilai ke input atau dropdown lain
            $('#level_pelatihan').val(level); // Pilih level di dropdown
            $('#jenis_pelatihan').val(jenis); // Isi input jenis pelatihan
            $('#vendor_pelatihan').val(vendor); // Isi input jenis pelatihan
        });

        $("#form-tambah-pelatihan").validate({
            rules: {
                id_pelatihan: {
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
                no_pelatihan: {
                    minlength: 1,
                    maxlength: 20,
                    required: true,

                },
                bukti_pelatihan: {
                    required: true, 
                    extension: "pdf|jpg|jpeg|png"
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
                                    if (typeof tablepelatihan !== 'undefined') {
                                        tablepelatihan.ajax
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
