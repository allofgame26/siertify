@if (empty($sertifikasi))
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data vendor yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/pendataan/sertifikasi/') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@endif
<form action="{{ url('/penugasan/sertifikasi/' . $sertifikasi->id_detail_sertifikasi . '/store') }}" method="post"
    id="form-edit-sertifikasi" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Riwayat Sertifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <p>Detail Sertifikasi</p>
                </div>
                <div class="form-group">
                    <label>Nama Sertifikasi</label>
                    <input value="{{ $sertifikasi->nama_sertifikasi }}" type="text" name="nama_sertifikasi"
                        id="nama_sertifikasi" class="form-control" placeholder="" readonly>
                    <small id="error-nama_nama_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Vendor Sertifikasi</label>
                    <input value="{{ $sertifikasi->nama_vendor_sertifikasi }}" type="text" name="nama_vendor_sertifikasi"
                        id="nama_vendor_sertifikasi" class="form-control" placeholder="" readonly>
                    <small id="error-nama_nama_vendor_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Level Sertifikasi</label>
                            <input value="{{ $sertifikasi->level_sertifikasi }}" type="text" name="level_sertifikasi"
                                id="level_sertifikasi" class="form-control" placeholder="" readonly>
                            <small id="error-level_sertifikasi" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Jenis Sertifikasi</label>
                            <input value="{{ $sertifikasi->nama_jenis_sertifikasi }}" type="text"
                                name="jenis_pelatihan" id="jenis_pelatihan" class="form-control" placeholder=""
                                readonly>
                            <small id="error-jenis_pelatihan" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Biaya Sertifikasi</label>
                    <input value="{{ $sertifikasi->biaya }}" type="number" name="biaya" id="biaya"
                        class="form-control" placeholder="Enter biaya sertifikasi" readonly>
                    <small id="error-biaya" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Lokasi Sertifikasi</label>
                    <input value="{{ $sertifikasi->lokasi }}" type="text" name="lokasi" id="lokasi"
                        class="form-control" placeholder="Enter lokasi sertifikasi" readonly>
                    <small id="error-lokasi" class="error-text form-text text-danger"></small>
                </div>
                <p>Jadwal Sertifikasi</p>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Periode</label>
                            <input value="{{ $sertifikasi->nama_periode }}" type="text" name="nama_periode"
                                id="nama_periode" class="form-control" placeholder="Enter nama_periode sertifikasi"
                                readonly>
                            <small id="error-nama_periode" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input value="{{ $sertifikasi->tanggal_selesai }}" type="text" name="tanggal_selesai"
                                id="tanggal_selesai" class="form-control" readonly>
                            <small id="error-tanggal_selesai" class="error-text form-text text-danger"></small>
                        </div>

                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input value="{{ $sertifikasi->tanggal_selesai }}" type="date" name="tanggal_selesai"
                                id="tanggal_selesai" class="form-control" readonly>
                            <small id="error-tanggal_selesai" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
                <div>
                    <p>Kategori Sertifikasi</p>
                </div>
                        <div class="form-group">
                            <label>Mata Kuliah Relevan</label>
                        </div>
                    <div class="form-group">
                        @if (empty($mataKuliah))
                            <p style="color: #D9D9D9; ">Tidak ada mata kuliah terkait.</p>
                        @else
                            @foreach ($mataKuliah as $mk)
                                <!-- Display each mata kuliah as badge -->
                                <span class="custom-badge-mk">{{ $mk->nama_mk }}</span>
                                <input type="hidden" name="id_mk[]" value="{{ $mk->id_mk}}">
                            @endforeach
                        @endif
                    </div>
         
                        <div class="form-group">
                            <label>Bidang Minat Relevan</label>
                        </div>
                    <div class="form-group">
                        @if (empty($bidangMinat))
                            <p style="color: #D9D9D9;">Tidak ada bidang minat terkait.</p>
                        @else
                            @foreach ($bidangMinat as $bd)
                                <!-- Display each bidang minat as badge -->
                                <span class="custom-badge-bd">{{ $bd->nama_bd }}</span>
                                <input type="hidden" name="id_bd[]" value="{{ $bd->id_bd }}">
                            @endforeach
                        @endif
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
                    <input value="" type="text" name="no_sertifikasi"
                        id="no_sertifikasi" class="form-control" placeholder="Enter nomor sertifikat" required>
                    <small id="error-no_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Bukti Sertifikat</label>
                    <input type="file" value="" name="bukti_sertifikasi"
                        id="bukti_sertifikasi" class="form-control">
                    <small id="error-bukti_sertifikasi" class="error-text form-text textdanger"></small>
                </div>

                <input type="hidden" name="input_by" value="{{ Auth::user()->getRole() == 'DSN' ? 'dosen' : '' }}">

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-success">Simpan</button>
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

    .custom-badge-mk {
        background-color: #FFFFEA;
        /* Warna kuning untuk latar */
        color: #BB6902;
        /* Warna teks hitam */
        border: 1px solid #FFDF1B;
        /* Warna border kuning gelap */
        border-radius: 16px;
        /* Membuat bentuknya lebih bulat */
        padding: 5px 15px;
        /* Padding dalam badge */
        font-weight: medium;
        /* Teks lebih tebal */
        font-size: 14px;
        /* Ukuran font */
        display: inline-block;
        /* Supaya terlihat seperti badge */
        margin: 5px;
        /* Jarak antar badge */
        height: 28px;
        justify-content: center;
        text-align: center;
    }

    .custom-badge-bd {
        background-color: #F1FCF2;
        /* Warna kuning untuk latar */
        color: #1F7634;
        /* Warna teks hitam */
        border: 1px solid #58D073;
        /* Warna border kuning gelap */
        border-radius: 16px;
        /* Membuat bentuknya lebih bulat */
        padding: 5px 15px;
        /* Padding dalam badge */
        font-weight: medium;
        /* Teks lebih tebal */
        font-size: 14px;
        /* Ukuran font */
        display: inline-block;
        /* Supaya terlihat seperti badge */
        margin: 5px;
        /* Jarak antar badge */
        height: 28px;
        justify-content: center;
        text-align: center;
    }
</style>

<script>
    $(document).ready(function() {

        $("#form-edit-sertifikasi").validate({
            rules: {
                rules: {
                    nama_sertifikasi: {
                        required: true,
                        minlength: 5,
                        maxlength: 100
                    },
                    id_vendor_sertifikasi: {
                        required: true,
                    },
                    id_jenis_pelatihan_sertifikasi: {
                        required: true
                    },
                    id_periode: {
                        required: true,
                        number: true
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
                        number: true
                    },
                    no_sertifikasi: {
                        minlength: 1,
                        maxlength: 20,
                        required: true,
                    },
                    'id_mk[]': {
                        required: true
                    },
                    'id_bd[]': {
                        required: true
                    }
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
