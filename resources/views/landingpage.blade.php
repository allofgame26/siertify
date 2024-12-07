<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIERTIFY - Sistem Informasi Pendataan Sertifikasi dan Pelatihan Dosen JTI</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png" />

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Gradient effect */
        .gradient {
                background: linear-gradient(to top, white, transparent);
            }
    </style>
</head>

<body class="">
    <nav class="grid grid-cols-3 justify-items-center px-20 py-3 border-b items-center sticky top-0 bg-white z-10">
        <div class="logo justify-self-start flex gap-2 items-center">
            <img src="logo.png" class="w-8" alt="" />
            <h1 class="tracking-wide font-bold text-[#17A2B8]">SIERTIFY</h1>
        </div>
        <ul class="flex gap-6">
            <li><a href="">Beranda</a></li>
            <li><a href="#about">Tentang Kami</a></li>
        </ul>
        <a href="{{ url('/login') }}" class="justify-self-end px-10 py-2 bg-[#17A2B8] rounded">
            <h1 class="text-white">Login</h1>
        </a>
    </nav>
    <main>
        <section class="m-6 bg-[#FBFCFF] rounded-lg flex flex-col items-center text-center p-4 pt-16 relative" id="home">
            <img src="bg-element.png" style="height: 111px; width: 173px;" alt=""
                class="absolute top-4 left-4" />
            <img src="bg-element.png" alt="" style="height: 111px; width: 173px;"
                class="absolute top-4 right-4 rotate-180" />

            <h1 class="text-[#17A2B8] text-2xl w-1/2 font-medium">
                Sistem Informasi Pendataan Sertifikasi dan Pelatihan Dosen JTI!
            </h1>
            <p class="text-[#196E85] text-base w-1/3 mb-8 font-light tracking-wide">
                Platform ini dirancang untuk memudahkan proses pendataan, pengajuan,
                dan pemantauan sertifikasi serta pelatihan dosen di Jurusan Teknologi
                Informasi.
            </p>
            <img src="hero-image.png" style="height: 409px; width:1062px;" alt="" class="w-[50%]" />
        </section>
        <section class="mt-20 px-20 gradient flex gap-16 mb-20" id="about">
            <img src="image.png" style="height: 411px; width: 572px" alt="" class="rounded-lg" />
            <div class="flex flex-col justify-center">
                <h1 class="text-4xl text-[#17A2B8] font-semibold mb-6">
                    Tentang SIERTIFY
                </h1>
                <p class="text-lg">
                    Sistem Informasi Pendataan Sertifikasi dan Pelatihan Dosen JTI
                    adalah platform terintegrasi yang dirancang khusus untuk memudahkan
                    dosen dalam mengelola data sertifikasi dan pelatihan secara efisien.
                    Dengan sistem ini, setiap proses dari pendaftaran hingga persetujuan
                    sertifikasi dapat diakses dengan mudah dan transparan, memastikan
                    pengembangan kompetensi dosen berjalan lebih terarah.
                </p>
            </div>
        </section>
    </main>
    <footer class="bg-[#17A2B8] px-20 py-14 relative">
        <img src="bg-element.png" style="height: 111px; width: 173px;" alt=""
            class="absolute top-10 right-8 rotate-180" />
        <img src="bg-element.png" style="height: 111px; width: 173px;" alt=""
            class="absolute top-40 right-40 rotate-180" />

        <div class="flex gap-16">
            <div class="">
                <img class="w-20 h-auto" src="jti_logo.png" alt="" />
            </div>
            <div class="text mb-20 text-white">
                <h4 class="text-xl font-semibold mb-8">JTI POLINEMA</h4>
                <p>
                    Jurusan Teknologi Informatika Politeknik Negeri Malang <br />
                    Jl. Soekarno-Hatta No. 9 Malang 65141 <br />
                    Po.Box 04 Malang
                </p>
                <h6>Telepon : +62 (0341) 404424 - 404425</h6>
                <h6>Faks : +62 (0341) 404420</h6>
            </div>
        </div>
    </footer>
    <div class="w-full text-center py-3 bg-[#0D313F]">
        <p class="text-[#869099]">
            Copyright © 2014-2021
            <span class="text-white font-bold">SIERTIFY</span> All rights reserved.
        </p>
    </div>
</body>

</html>


