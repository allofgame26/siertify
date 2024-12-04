<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIERTIFY - Sistem Informasi Pendataan Sertifikasi dan Pelatihan Dosen JTI</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet"> --}}
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Sweet Alert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="mt-14 pt-1 mx-20 px-2.5 flex items-center">
        <a href="{{ url('/') }}">
            <img class="w-10" src="{{ asset('logo.png') }}" alt="Logo SIERTIFY" />
        </a>
        <h1 class="ml-2 text-2xl font-extrabold text-[#17A2B8]">SIERTIFY</h1>
    </header>

    <!-- Main Content -->
    <main class="mt-16 grid grid-cols-1 md:grid-cols-2 items-center px-8 lg:px-20">
        <!-- Left Section (Image) -->
        <div class="hidden md:block">
            <img src="{{ asset('login-image.png') }}" alt="Login Illustration" class="w-full max-w-sm mx-auto" />
        </div>

        <!-- Right Section (Form) -->
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full mx-auto md:mx-0">
            <h2 class="text-center text-2xl font-semibold mb-6 text-gray-700">Selamat Datang</h2>
            <p class="text-center text-sm text-gray-500 mb-10">
                Masukkan data Anda untuk Log In ke <span class="font-bold text-[#17A2B8]">SIERTIFY</span>
            </p>

            <form action="{{ url('/postlogin') }}" method="POST" id="form-login">
                @csrf
                <div class="mb-6">
                    <label for="username" class="block text-gray-700">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan Username"
                        class="mt-2 w-full p-3 border border-gray-300 rounded-lg focus:ring-[#17A2B8] focus:border-[#17A2B8]"
                        required />
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password"
                        class="mt-2 w-full p-3 border border-gray-300 rounded-lg focus:ring-[#17A2B8] focus:border-[#17A2B8]"
                        required />
                </div>

                <button type="submit"
                    class="w-full bg-[#17A2B8] text-white font-semibold py-3 rounded-lg hover:bg-[#138492] transition duration-200">
                    Log In
                </button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-12 text-center text-sm text-gray-500">
        &copy; 2024 SIERTIFY. All rights reserved.
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script>
        $(document).ready(function() {
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

            $("#form-login").validate({
                rules: {
                    username: {
                        required: true,
                        minlength: 4,
                        maxlength: 20
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 255
                    },
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Berhasil",
                                    text: response.message,
                                }).then(function() {
                                    window.location = response.redirect;
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Terjadi Kesalahan",
                                    text: response.message,
                                });
                            }
                        },
                    });
                    return false;
                },
            });
        });
    </script>
</body>

</html>
