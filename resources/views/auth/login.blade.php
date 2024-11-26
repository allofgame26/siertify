<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Sertify</title>

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

  <body>
    <header class="mt-14 pt-1 mx-20 px-2.5 flex gap-2 items-center">
      <img class="w-8" src="{{ asset('logo.png')}}" alt="" />
      <h1 class="tracking-wide font-bold text-[#17A2B8]">SERTIFY</h1>
    </header>
    <br>
    <br>
    <br>
    <br>

    <main class="grid grid-cols-2 justify-items-center">
      <div class="">
        <img src="{{ asset('login-image.png') }}" alt="" />
      </div>

      <div class="w-3/4">
        <div class="header mb-16">
          <h1 class="text-center text-2xl mb-3.5">Selamat Datang</h1>
          <p class="text-center text-sm">
            Masukkan data Anda untuk Log In ke
            <span class="font-bold text-[#17A2B8]">SIERTIFY</span>
          </p>
        </div>

        <form action="{{ url('/postlogin')}}" method="POST" class="flex flex-col" id="form-login">
            @csrf
          <div class="flex flex-col gap-6">
            <div class="">
              <label for="username" class="">Username</label>
              <input class="mt-2 w-full p-2 px-3 ring-1 ring-gray-300 rounded placeholder:opacity-50" type="text" id="username" name="username" placeholder="Enter Username" class="form-control"/>
            </div>
            <!-- <div class="">
              <label for="jenis-pengguna">Jenis Pengguna</label>
              <select name="jenis-pengguna" id="jenis-pengguna" class="mt-2 w-full p-3 px-4 ring-1 bg-white ring-gray-300 rounded">
                <option value="">Pilih Jenis Pengguna</option>
                <option value="">Super Admin</option>
                <option value="">Admin</option>
                <option value="">Pemimpin</option>
                <option value="">Dosen</option>
              </select>
            </div> -->
            <div class="">
              <label for="password">Password</label>
              <input class="mt-2 w-full p-2 px-3 ring-1 ring-gray-300 rounded placeholder:opacity-50" type="password" id="password" name="password" placeholder="Enter password" class="form-control" />
            </div>
          </div>

          <div>
            <button type="submit" class="mt-20 px-6 py-4 bg-[#17A2B8] rounded-xl">
                Log In
              </button>
          </div>
        </form>
      </div>
    </main>
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

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $("#form-login").validate({
            rules: {
                username: {required: true, minlength: 4, maxlength: 20},
                password: {required: true, minlength: 6, maxlength: 255}
            },
        submitHandler: function(form) { // ketika valid, maka bagian yg akan dijalankan
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    if(response.status){ // jika sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                        }).then(function() {
                            window.location = response.redirect;
                        });
                    }else{ // jika error
                        $('.error-text').text('');
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-'+prefix).text(val[0]);
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
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.input-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
