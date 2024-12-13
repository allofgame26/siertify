<form action="{{ url('/pendataan/sertifikasi/new') }}" method="post" id="form-tambah-sertifikasi-baru" enctype="multipart/form-data">
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
                <div class="row">
                    <div class="col-10">
                        <p>Detail Sertifikasi</p>
                    </div>
                    <div class="col-2" style="padding-left">
                        <button onclick="modalAction('{{ url('/pendataan/sertifikasi/create') }}')"
                            class="btn btn-info btn-sm">Kembali</button>
                    </div>
                </div>
                <div class="form-group">
                    <label>Nama Sertifikasi</label>
                    <input value="" type="text" name="nama_sertifikasi" id="nama_sertifikasi" class="form-control"
                        placeholder="Enter nama sertifikasi" >
                    <small id="error-nama_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Vendor Sertifikasi</label>
                    <select name="id_vendor_sertifikasi" id="id_vendor_sertifikasi" class="form-control">
                        <option value="">- Pilih Vendor -</option>
                        @foreach ($vendorSertifikasi as $l)
                            <option value="{{ $l->id_vendor_sertifikasi }}">
                                {{ $l->nama_vendor_sertifikasi }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_vendor_sertifikasi" class="error-text form-text text-danger"></small>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Level Sertifikasi</label>
                            <select name="level_sertifikasi" id="level_sertifikasi" class="form-control" required>
                                <option value="" disabled selected>Pilih Level</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Internasional">Internasional</option>
                            </select>
                            <small id="error-level_sertifikasi" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Jenis Sertifikasi</label>
                            <select name="id_jenis_pelatihan_sertifikasi" id="id_jenis_pelatihan_sertifikasi"
                                class="form-control">
                                <option value="" disabled selected>Pilih Jenis</option>
                                @foreach ($jenisPelatihan as $l)
                                    <option value="{{ $l->id_jenis_pelatihan_sertifikasi }}">
                                        {{ $l->nama_jenis_sertifikasi }}</option>
                                @endforeach

                            </select>
                            <small id="error-id_jenis_pelatihan_sertifikasi"
                                class="error-text form-text text-danger"></small>
                        </div>
                    </div>
        
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Biaya Sertifikasi</label>
                            <input value="" type="number" name="biaya" id="biaya" class="form-control"
                                placeholder="Enter biaya pelatihan" required>
                            <small id="error-biaya" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Lokasi Sertifikasi</label>
                            <input value="" type="text" name="lokasi" id="lokasi" class="form-control"
                                placeholder="Enter lokasi pelatihan" required>
                            <small id="error-lokasi" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
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
                    <p>Kategori Sertifikasi</p>
                </div>

                <div class="row">
                    <div class="col-10">
                        <div class="form-group">
                            <label>Mata Kuliah Relevan</label>
                        </div>
                    </div>
                    <div class="col-2" style="padding-left">
                        <button
                        type="button"
                            onclick="modalAction('{{ url('/pendataan/sertifikasi/' . Auth::user()->id_user . '/createmk') }}')"
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
                            onclick="modalAction('{{ url('/pendataan/sertifikasi/' . Auth::user()->id_user . '/createbd') }}')"
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
                <input value="" type="text" name="no_sertifikasi" id="no_sertifikasi" class="form-control"
                    placeholder="Enter nomor sertifikat" required>
                <small id="error-no_sertifikasi" class="error-text form-text text-danger"></small>
            </div>
            <div class="form-group">
                <label>Bukti Sertifikat</label>
                <input type="file" name="bukti_sertifikasi" id="bukti_sertifikasi" class="form-control" required>
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



{{-- 
@if (session('showModal')) --}}


<script>
    $(document).ready(function() {

        // // Fungsi aksi modal
        // function modalAction(button) {
        //     let idPelatihan = $(button).data('id');
        //     console.log("ID Pelatihan:", idPelatihan);
        // }

        $('#form-tambah-sertifikasi-baru').validate({
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
                bukti_sertifikasi: {
                    required: true,
                    extension: "pdf|jpg|jpeg|png"
                },
                'id_mk[]' : {
                    required: true
                }, 
                'id_bd[]' :{
                    required: true
                }

            }, 
            submitHandler: function(form) {

                var formData = new FormData(form);

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response){
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
                                    .reload(); // Reload halaman jika tidak ada tablesertifikasi
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
        })
    });
</script>

{{-- @endif --}}




