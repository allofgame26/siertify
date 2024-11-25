<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIERTIFY - Sistem Informasi Pendataan Sertifikasi dan Pelatihan Dosen JTI</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- Sweet Alert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Header/Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-teal-600">SIERTIFY</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="#" class="text-gray-700 hover:text-gray-900 px-3 py-2">Beranda</a>
                    <a href="" class="btn btn-primary">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">
                Sistem Informasi Pendataan Sertifikasi dan Pelatihan Dosen JTI!
            </h1>
            <p class="text-lg text-gray-600">
                Platform ini dirancang untuk memudahkan proses pendataan pengajuan dan pengumpulan sertifikasi serta pelatihan dosen di Jurusan Teknologi Informasi.
            </p>
        </div>

        <!-- Dashboard Preview -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-12">
            <div class="grid grid-cols-4 gap-4 mb-8">
                <div class="bg-yellow-100 p-4 rounded-lg">
                    <h3 class="font-bold text-xl">10</h3>
                    <p class="text-sm">Sertifikasi</p>
                </div>
                <div class="bg-green-100 p-4 rounded-lg">
                    <h3 class="font-bold text-xl">20</h3>
                    <p class="text-sm">Total User</p>
                </div>
                <div class="bg-blue-100 p-4 rounded-lg">
                    <h3 class="font-bold text-xl">1</h3>
                    <p class="text-sm">Review Sertifikasi</p>
                </div>
                <div class="bg-purple-100 p-4 rounded-lg">
                    <h3 class="font-bold text-xl">0</h3>
                    <p class="text-sm">Menunggu Persetujuan</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-teal-50 p-4 rounded-lg">
                    <h4 class="font-semibold mb-4">Presentase Sertifikasi Per Program</h4>
                    <!-- Placeholder for pie chart -->
                    <div class="h-64 bg-teal-100 rounded-lg"></div>
                </div>
                <div class="bg-teal-50 p-4 rounded-lg">
                    <h4 class="font-semibold mb-4">Statistik Program Sertifikasi</h4>
                    <!-- Placeholder for bar chart -->
                    <div class="h-64 bg-teal-100 rounded-lg"></div>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <div class="grid grid-cols-2 gap-8 items-center mb-12">
            <div>
                <img src="{{ asset('landingpagefoto.png') }}" alt="SIERTIFY Mobile Preview" class="rounded-lg shadow-lg">
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Tentang SIERTIFY</h2>
                <p class="text-gray-600">
                    Sistem Informasi Pendataan Sertifikasi dan Pelatihan Dosen JTI adalah platform terintegrasi yang dirancang khusus untuk memudahkan dosen dalam mengelola data sertifikasi dan pelatihan secara efisien. Dengan sistem ini, setiap proses dari pendaftaran hingga persetujuan sertifikasi dapat diakses dengan mudah dan transparan, mendorong pengembangan kompetensi dosen berjalan lebih terarah.
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#17A2B8] text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-start space-x-6">
                <!-- Logo and Info -->
                <div class="flex items-start space-x-4">
                    <!-- Logo -->
                    <div class="w-16 h-16">
                        <img src="{{ asset('POLINEMA-LOGO.png') }}" alt="Logo JTI POLINEMA" class="w-full h-full object-contain">
                    </div>
                    <!-- Company Info -->
                    <div class="text-white">
                        <h3 class="text-2xl font-bold mb-4">JTI POLINEMA</h3>
                        <div class="space-y-2">
                            <p class="text-sm">Jurusan Teknologi Informatika Politeknik Negeri Malang</p>
                            <p class="text-sm">Jl. Soekarno-Hatta No. 9 Malang 65141</p>
                            <p class="text-sm">PO.Box 04 Malang</p>
                            <p class="text-sm">Telepon : +62 (0341) 404424 - 404425</p>
                            <p class="text-sm">Faks : +62 (0341) 404420</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright Bar -->
        <div class="bg-[#0E7182] py-3">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm">
                    Copyright © 2014-2021 <span class="font-medium">SIERTIFY</span>. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
    
</body>
</html>
<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
<!-- Datatables & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colvis.min.js') }}"></script>
<!-- sweet alert2 -->
<script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>