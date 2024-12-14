<form action="{{ url('/detailsertifikasi/proses') }}" method="POST" id="form-tambah-detailsertifikasi" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Detail Sertifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Detail Pelatihan</h5>
                    <div class="form-group">
                        <label>Nama Sertifikasi</label>
                        <select name="id_sertifikasi" id="id_sertifikasi" class="form-control">
                            <option value="">Pilih Sertifikasi</option>
                            @foreach ($sertifikasi as $l)
                            <option value="{{ $l->id_sertifikasi }}">{{ $l->nama_sertifikasi }}</option>
                            @endforeach
                        </select>
                    </div>
                <div class="mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Biaya Pelatihan</label>
                                <input type="number" name="biaya" id="biaya" class="form-control" placeholder="Enter biaya pelatihan">
                            </div>
                            <div class="form-group">
                                <label>Lokasi</label>
                                <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Enter lokasi pelatihan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jumlah Peserta</label>
                                <input type="text" name="quota_peserta" id="quota_peserta" class="form-control" placeholder="Enter jumlah peserta">
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Jadwal Pelatihan -->
                <div class="mb-4">
                    <h5>Jadwal Pelatihan</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Periode</label>
                                <select name="id_periode" id="id_periode" class="form-control">
                                    <option value="">Pilih Periode</option>
                                    @foreach ($periode as $l)
                                    <option value="{{ $l->id_periode }}">{{ $l->nama_periode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Kategori Pelatihan -->
                <div class="row">
                    <div class="col-10">
                        <div class="form-group">
                            <label>Mata Kuliah Relevan</label>
                        </div>
                    </div>
                    <div class="col-2" style="padding-left">
                        <button
                        type="button"
                            onclick="modalAction('{{ url('/detailsertifikasi/' . Auth::user()->id_user . '/createmk') }}')"
                            class="btn btn-success btn-sm">
                            <i class="fas fa-plus-square" style="margin-right: 8px;"></i>Tambah
                        </button>
                    </div>
                </div>
                <!-- Display Session Data as Badges -->
                @if (session()->has('id_mk'))
                    <div class="form-group">
                        <div>
                            @foreach (session('id_mk') as $id => $namaMk)
                                <!-- Display each mata kuliah as badge -->
                                <span class="custom-badge-mk">{{ $namaMk }} </span>
                                <input type="hidden"  name="id_mk[]" value="{{ $id }}">
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-10">
                        <div class="form-group">
                            <label>Bidang Minat Relevan</label>
                        </div>
                    </div>
                    <div class="col-2" style="padding-left">
                        <button
                        type="button"
                            onclick="modalAction('{{ url('/detailsertifikasi/' . Auth::user()->id_user . '/createbd') }}')"
                            class="btn btn-success btn-sm">
                            <i class="fas fa-plus-square" style="margin-right: 8px;"></i>Tambah
                        </button>
                    </div>
                </div>
                 <!-- Display Session Data as Badges -->
                 @if (session()->has('id_bd'))
                 <div class="form-group">
                     <div>
                         @foreach (session('id_bd') as $id => $namabd)
                             <!-- Display each mata kuliah as badge -->
                             <span class="custom-badge-bd">{{ $namabd }} </span>
                            <input type="hidden"  name="id_bd[]" value="{{ $id }}">
                         @endforeach
                     </div>
                 </div>
             @endif

            <input type="hidden" name="input_by" value="dosen">
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
        // Setup CSRF token untuk setiap AJAX request
        $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

        $("#form-tambah-detailsertifikasi").validate({
            rules: {
                id_sertifikasi: {
                    required: true,
                },
                biaya: {
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
                'id_mk[]' : {
                    required: true
                }, 
                'id_bd[]' :{
                    required: true
                }
                
            },
            submitHandler: function(form) {
                console.log('Validasi Berhasil, Form akan disubmit');
                $.ajax({
                    url: $(form).attr('action'), // URL dari atribut action form
                    type: 'POST', // Metode POST
                    data: $(form).serialize(), // Serialize form untuk data request
                    dataType: 'json', // Format data yang diharapkan
                    beforeSend: function() {
                        // Disable tombol submit sebelum proses selesai
                        $('button[type="submit"]').prop('disabled', true);
                    },
                    success: function(response) {
                        if (response.status) {
                            // Tutup modal
                            $('#myModal').modal('hide');
                            // Reset form
                            $(form)[0].reset();
                            // Tampilkan pesan sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });

                            // Reload DataTable jika instance tersedia
                            if (typeof datadetailsertifikasi !== 'undefined') {
                                datadetailsertifikasi.ajax.reload(null, false); // Reload tabel tanpa mengubah posisi halaman
                            }

                        } else {
                            // Reset error message
                            $('.error-text').text('');
                            // Tampilkan pesan error jika ada
                            if (response.msgField) {
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                            }
                            // Tampilkan alert error
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', xhr.responseJSON);
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: xhr.responseJSON?.message || 'Gagal menyimpan data. Silakan coba lagi.'
                        });
                    },
                    complete: function() {
                        // Aktifkan kembali tombol submit setelah proses selesai
                        $('button[type="submit"]').prop('disabled', false);
                    }
                });
                return false; // Mencegah form submit secara default
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
