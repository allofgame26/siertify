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
<form action="" method="post" id="form-tambah-sertifikasi" enctype="multipart/form-data">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="exampleModalLabel">Penugasan sertifikasi</h5>
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
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Biaya Sertifikasi</label>
                            <input value="{{ $sertifikasi->biaya }}" type="number" name="biaya" id="biaya"
                                class="form-control" placeholder="Enter biaya sertifikasi" readonly>
                            <small id="error-biaya" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Lokasi Sertifikasi</label>
                            <input value="{{ $sertifikasi->lokasi }}" type="text" name="lokasi" id="lokasi"
                                class="form-control" placeholder="Enter lokasi sertifikasi" readonly>
                            <small id="error-lokasi" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
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
                            <input value="{{ $sertifikasi->tanggal_mulai }}" type="text" name="tanggal_mulai"
                                id="tanggal_mulai" class="form-control" readonly>
                            <small id="error-tanggal_mulai" class="error-text form-text text-danger"></small>
                        </div>

                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input value="{{ $sertifikasi->tanggal_selesai }}" type="text" name="tanggal_selesai"
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
                    <p>Peserta Sertifikasi</p>
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
                <button class="btn btn-info btn-unduh-surat" type="button"
                    data-id="{{ $sertifikasi->id_detail_sertifikasi }}"
                    onclick="modalAction('{{ url('/penugasan/sertifikasi/' . $sertifikasi->id_detail_sertifikasi . '/surat_tugas') }}')">
                    <i class="fas fa-download" style="margin-right: 8px;"></i>Unduh Surat Tugas</button>
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

    .scrollable-table {
        max-height: 200px;
        /* Tinggi maksimal */
        overflow-y: scroll;
        /* Scrollbar vertikal */
        border: 1px solid #ddd;
        padding: 5px;
    }

    .scrollable-table table {
        width: 100%;
        border-collapse: collapse;
    }

    .scrollable-table th,
    .scrollable-table td {
        padding: 8px;
        text-align: left;
    }
</style>

<script>
    $(document).ready(function() {

        // Event handler untuk tombol unduh surat tugas
        $(".btn-unduh-surat").on("click", function(e) {
            e.preventDefault(); // Mencegah form submit default

            var id = $(this).data("id"); // Ambil ID dari atribut data-id pada tombol
            var url = `/penugasan/sertifikasi/${id}/surat_tugas`;

            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest", // Pastikan request adalah AJAX
                },
                success: function(response) {
                    if (response.status === "processing") {
                        $('#modal-master').modal('hide');
                        Swal.fire({
                            icon: 'info',
                            text: response.message
                        }).then(() => {
                            location.reload(); // Refresh halaman setelah klik "OK"
                        });
                    } else if (response.status === "error") {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal",
                            text: response.message,
                        }).then(() => {
                            location.reload(); // Refresh halaman setelah klik "OK"
                        });
                    } else {
                        // Redirect untuk mengunduh file
                        window.location.href = url;
                        // Setelah beberapa detik, refresh halaman
                        setTimeout(function() {
                            location.reload();
                        }, 500); // Waktu jeda untuk memastikan unduhan dimulai
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Terjadi Kesalahan",
                        text: "Gagal mengunduh surat tugas.",
                    }).then(() => {
                        location.reload(); // Refresh halaman setelah klik "OK"
                    });
                },
            });

            return false; // Mencegah form untuk submit secara biasa
        });
    });
</script>
