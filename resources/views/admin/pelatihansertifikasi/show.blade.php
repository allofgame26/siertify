@empty($detailsertifikasi)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data Detail Sertifikasi yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/detailsertifikasi') }}" class="btn btn-info">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="" method="POST" id="form-show">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Sertifikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Data Sertifikasi</h5>
                    <div class="form-group">
                        <label>Nama Sertifikasi</label>
                        <input value="{{ $detailsertifikasi->sertifikasi->nama_sertifikasi }}" type="text" name="nama_sertifikasi" id="nama_sertifikasi"
                            class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Vendor</label>
                        <input value="{{ $detailsertifikasi->sertifikasi->vendorsertifikasi->nama_vendor_sertifikasi }}" type="text" name="id_vendor_sertifikasi" id="id_vendor_sertifikasi"
                            class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Jenis Sertifikasi</label>
                        <input value="{{ $detailsertifikasi->sertifikasi->jenissertifikasi->nama_jenis_sertifikasi }}" type="text" name="id_jenis_pelatihan_sertifikasi" id="id_jenis_pelatihan_sertifikasi"
                            class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label> Level Sertifikat</label>   
                        <input value="{{ $detailsertifikasi->sertifikasi->level_sertifikasi }}" type="text" name="level_sertifikasi" id="level_sertifikasi"
                            class="form-control" placeholder="Enter Username" readonly>
                        <small id="error-username" class="error-text form-text text-danger"></small>
                    </div>

                    <!-- Jadwal Pelatihan -->
                    <div class="mb-4">
                        <h5>Jadwal Pelatihan</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Periode</label>
                                    <input value="{{ $detailsertifikasi->periode->nama_periode }}" type="text" name="id_periode" id="id_periode"
                                    class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input value="{{ $detailsertifikasi->tanggal_mulai }}"  type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Selesai</label>
                                    <input value="{{ $detailsertifikasi->periode->tanggal_selesai }}" type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>lokasi</label>
                        <input value="{{ $detailsertifikasi->lokasi }}" type="text" name="lokasi" id="lokasi" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Quota Peserta</label>
                        <input value="{{ $detailsertifikasi->quota_peserta }}" type="text" name="quota_peserta" id="quota_peserta" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Biaya</label>
                        <input value="{{ $detailsertifikasi->biaya }}" type="number" name="biaya" id="biaya" class="form-control" required>
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
            $("#form-show").validate({
                rules: {
                    nama_sertifikasi: {
                    required: true,
                    number: true // Validasi tipe integer
                },
                id_vendor_sertifikasi: {
                    required: true,
                    number: true // Validasi tipe integer
                },
                id_jenis_pelatihan_sertifikasi: {
                    required: true,
                    number: true // Validasi tipe integer
                },
                level_sertifikasi: {
                    required: true,
                    minlength: 5,
                    maxlength: 20,
                },biaya: {
                    required: true,
                    number: true // Validasi tipe integer
                },
                lokasi: {
                    required: true,
                    maxlength: 50,
                },
                quota_peserta: {
                    required: true,
                    maxlength: 5,
                },
                id_periode: {
                    required: true,
                },
                tanggal_mulai: {
                    required: true,
                },
                tanggal_selesai: {
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
@endempty
