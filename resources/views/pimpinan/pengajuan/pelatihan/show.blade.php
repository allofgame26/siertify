@empty($pelatihan)
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
                    Data Detail pelatihan yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/pengajuan') }}" class="btn btn-info">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/pengajuan/pelatihan/'. $pelatihan->id_detail_pelatihan . '/update') }}" method="POST" id="form-show">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Penugasan Pelatihan</h5>
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
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Biaya Pelatihan</label>
                                <input value="{{ $pelatihan->biaya }}" type="number" name="biaya" id="biaya"
                                    class="form-control" placeholder="Enter biaya pelatihan" readonly>
                                <small id="error-biaya" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Lokasi Pelatihan</label>
                                <input value="{{ $pelatihan->lokasi }}" type="text" name="lokasi" id="lokasi"
                                    class="form-control" placeholder="Enter lokasi pelatihan" readonly>
                                <small id="error-lokasi" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
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
                        <p>Peserta Pelatihan</p>
                    </div>
                    <div class="scrollable-table">
                        <table class="table table-bordered table-striped table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                </tr>
                            </thead>
                            <TBody>
                                @foreach ($peserta as $index => $p)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $p->nama_lengkap }}</td>
                                        <td>{{ $p->NIP }}</td>
                                    </tr>
                                @endforeach
                            </TBody>
    
                        </table>
                    </div>
    
    
                    <input type="hidden" name="input_by" value="{{ Auth::user()->getRole() == 'DSN' ? 'dosen' : '' }}">
    
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Kembali</button>
                    <button type="submit" class="btn btn-success">Setujui</button>
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
                    nama_pelatihan: {
                    required: true,
                },
                id_vendor_pelatihan: {
                    required: true,
                },
                id_jenis_pelatihan_sertifikasi: {
                    required: true,
                },
                level_pelatihan: {
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
@endempty
