@empty($detailpelatihan)
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
                    Data pelatihan yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/detailpelatihan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/detailpelatihan/' . $detailpelatihan->id_pelatihan. '/update') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Detail pelatihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama pelatihan</label>
                        <select name="id_pelatihan" id="id_pelatihan" class="form-control" readonly>
                            @foreach ($pelatihan as $l)
                            <option {{ $l->pelatihan == $detailpelatihan->id_pelatihan ? 'selected' : '' }} 
                            value="{{ $l->id_pelatihan }}">{{ $l->nama_pelatihan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Peserta</label>
                        <input value="{{ $detailpelatihan->quota_peserta }}" type="text" name="quota_peserta" id="quota_peserta"
                            class="form-control" placeholder="Enter Quota Peserta" required>
                        <small id="error-quota_peserta" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Biaya Pelatihan</label>
                        <input value="{{ $detailpelatihan->biaya }}" type="number" name="biaya" id="biaya"
                            class="form-control" placeholder="Enter biaya pelatihan" required>
                        <small id="error-biaya" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Lokasi Pelatihan</label>
                        <input value="{{ $detailpelatihan->lokasi }}" type="text" name="lokasi" id="lokasi"
                            class="form-control" placeholder="Enter lokasi pelatihan" required>
                        <small id="error-lokasi" class="error-text form-text text-danger"></small>
                    </div>
                    <p>Jadwal Pelatihan</p>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Periode</label>
                                <select class="form-control" name="id_periode" id="id_periode" required>
                                    <option value="{{ $detailpelatihan->periode->nama_periode }}">- Pilih periode -</option>
                                    @foreach ($periode as $l)
                                        <option {{ $l->id_periode == $detailpelatihan->id_periode ? 'selected' : '' }}
                                            value="{{ $l->id_periode }}"> {{ $l->nama_periode }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tanggal Mulai</label>
                                <input value="{{ $detailpelatihan->tanggal_mulai }}" type="date" name="tanggal_mulai"
                                    id="tanggal_mulai" class="form-control" required>
                                <small id="error-tanggal_mulai" class="error-text form-text text-danger"></small>
                            </div>
    
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tanggal Selesai</label>
                                <input value="{{ $detailpelatihan->tanggal_selesai }}" type="date" name="tanggal_selesai"
                                    id="tanggal_selesai" class="form-control" required>
                                <small id="error-tanggal_selesai" class="error-text form-text text-danger"></small>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p>Kategori Pelatihan</p>
                    </div>
    
                    <div class="row">
                        <div class="col-10">
                            <div class="form-group">
                                <label>Mata Kuliah Relevan</label>
                            </div>
                        </div>
                        <div class="col-2" style="padding-left">
                            <button type="button"
                                onclick="modalAction('{{ url('/detailpelatihan/' . $detailpelatihan->id_detail_pelatihan . '/editmk') }}')"
                                class="btn btn-success btn-sm">
                                <i class="fas fa-plus-square" style="margin-right: 8px;"></i>Edit
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
                                    <input type="hidden" name="id_mk[]" value="{{ $id }}">
                                @endforeach
                            </div>
                        </div>
                    @else
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
                    @endif
                    <div class="row">
                        <div class="col-10">
                            <div class="form-group">
                                <label>Bidang Minat Relevan</label>
                            </div>
                        </div>
                        <div class="col-2" style="padding-left">
                            <button type="button"
                                onclick="modalAction('{{ url('/detailpelatihan/' . $detailpelatihan->id_detail_pelatihan . '/editbd') }}')"
                                class="btn btn-success btn-sm">
                                <i class="fas fa-plus-square" style="margin-right: 8px;"></i>Edit
                            </button>
                        </div>
                    </div>
                    <!-- Display Session Data as Badges -->
                    @if (session()->has('id_bd'))
                        <div class="form-group">
                            <div>
                                @foreach (session('id_bd') as $id => $namabd)
                                    <!-- Display each bidang minat as badge -->
                                    <span class="custom-badge-bd">{{ $namabd }}</span>
                                    <input type="hidden" name="id_bd[]" value="{{ $id }}">
                                @endforeach
                            </div>
                        </div>
                    @else
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
            $("#form-edit").validate({
                rules: {
                    id_pelatihan: {
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
                                });

                                if (typeof pelatihan !== 'undefined') {
                                    pelatihan.ajax.reload(null, false); // Reload tabel tanpa mengubah posisi halaman
                            }
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
