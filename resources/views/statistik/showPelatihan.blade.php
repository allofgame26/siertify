@if (empty($pelatihan))
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
                <a href="{{ url('/pendataan/pelatihan/') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@endif
<form action="" method="post" id="form-tambah-pelatihan" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">Detail Data Riwayat Pelatihan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <p>Detail Pelatihan</p>
                </div>
                <div class="form-group">
                    <label>Nama Pelatihan</label>
                    <input value="{{ $pelatihan->nama_pelatihan }}" type="text" name="nama_pelatihan"
                        id="nama_pelatihan" class="form-control" placeholder="" readonly>
                    <small id="error-nama_nama_pelatihan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Vendor Pelatihan</label>
                    <input value="{{ $pelatihan->nama_vendor_pelatihan }}" type="text" name="nama_vendor_pelatihan"
                        id="nama_vendor_pelatihan" class="form-control" placeholder="" readonly>
                    <small id="error-nama_nama_vendor_pelatihan" class="error-text form-text text-danger"></small>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Level Pelatihan</label>
                            <input value="{{ $pelatihan->level_pelatihan }}" type="text" name="level_pelatihan"
                                id="level_pelatihan" class="form-control" placeholder="" readonly>
                            <small id="error-level_pelatihan" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Jenis Pelatihan</label>
                            <input value="{{ $pelatihan->nama_jenis_sertifikasi }}" type="text"
                                name="jenis_pelatihan" id="jenis_pelatihan" class="form-control" placeholder=""
                                readonly>
                            <small id="error-jenis_pelatihan" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Biaya Pelatihan</label>
                    <input value="{{ $pelatihan->biaya }}" type="number" name="biaya" id="biaya"
                        class="form-control" placeholder="Enter biaya pelatihan" readonly>
                    <small id="error-biaya" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Lokasi Pelatihan</label>
                    <input value="{{ $pelatihan->lokasi }}" type="text" name="lokasi" id="lokasi"
                        class="form-control" placeholder="Enter lokasi pelatihan" readonly>
                    <small id="error-lokasi" class="error-text form-text text-danger"></small>
                </div>
                <p>Jadwal Pelatihan</p>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Periode</label>
                            <input value="{{ $pelatihan->nama_periode }}" type="text" name="nama_periode"
                                id="nama_periode" class="form-control" placeholder="Enter nama_periode pelatihan"
                                readonly>
                            <small id="error-nama_periode" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input value="{{ $pelatihan->tanggal_mulai }}" type="text" name="tanggal_mulai"
                                id="tanggal_mulai" class="form-control" readonly>
                            <small id="error-tanggal_mulai" class="error-text form-text text-danger"></small>
                        </div>

                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input value="{{ $pelatihan->tanggal_selesai }}" type="text" name="tanggal_selesai"
                                id="tanggal_selesai" class="form-control" readonly>
                            <small id="error-tanggal_selesai" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <div>
                    <p>Kategori Pelatihan</p>
                </div>

                <div class="form-group">
                    <label>Mata Kuliah Relevan</label>
                </div>

                <div class="form-group">
                    @if (empty($mataKuliah))
                        <p style="color: #D9D9D9; ">Tidak ada mata kuliah terkait.</p>
                    @else
                        @foreach ($mataKuliah as $namaMk)
                            <!-- Display each mata kuliah as badge -->
                            <span class="custom-badge-mk">{{ $namaMk }}</span>
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
                        @foreach ($bidangMinat as $namabd)
                            <!-- Display each mata kuliah as badge -->
                            <span class="custom-badge-bd">{{ $namabd }}</span>
                        @endforeach
                    @endif
                </div>

                <div>
                    <p>Bukti Pelatihan</p>
                </div>
                <div class="form-group">
                    <label>Nomor Sertifikat</label>
                    <input value="{{ $pelatihan->no_pelatihan }}" type="text" name="no_pelatihan"
                        id="no_pelatihan" class="form-control" placeholder="Enter nomor sertifikat" readonly>
                    <small id="error-no_pelatihan" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Bukti Sertifikat</label>
                    <input type="text" value="{{ $pelatihan->bukti_pelatihan }}" name="bukti_pelatihan"
                        id="bukti_pelatihan" class="form-control" readonly>
                    <small id="error-bukti_pelatihan" class="error-text form-text textdanger"></small>
                </div>


                <input type="hidden" name="input_by" value="{{ Auth::user()->getRole() == 'DSN' ? 'dosen' : '' }}">

            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
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

        // $('#id_pelatihan').on('change', function() {
        //     // Ambil opsi yang dipilih
        //     let selectedOption = $(this).find(':selected');
        //     let level = selectedOption.data('level');
        //     let jenis = selectedOption.data('jenis');
        //     let vendor = selectedOption.data('vendor');

        //     // Set nilai ke input atau dropdown lain
        //     $('#level_pelatihan').val(level); // Pilih level di dropdown
        //     $('#jenis_pelatihan').val(jenis); // Isi input jenis pelatihan
        //     $('#vendor_pelatihan').val(vendor); // Isi input jenis pelatihan
        // });

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
