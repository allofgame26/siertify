
<!-- Sidebar -->
<div class="sidebar">

    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex ">
        <div class="image">
            <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block text-left text-wrap">Yolanda Ekaputri Setyawannnnnn</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="{{ url('/admin') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('profile') }}" class="nav-link {{ $activeMenu == 'profile' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-circle"></i>
                    <p>Profil</p>
                </a>
            </li>

            <!-- Fitur Pimpinan -->
            <li class="nav-header">Kelola Pelatihan Sertifikasi</li>
            <li class="nav-item">
                <a href="{{ url('/data-pelatihan-sertifikasi') }}" class="nav-link {{ $activeMenu == 'data-pelatihan-sertifikasi' ? 'active' : '' }} ">
                    <i class="nav-icon 	fas fa-archive"></i>
                    <p>Data Pelatihan & Sertifikasi Dosen</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/pengajuan') }}" class="nav-link {{ $activeMenu == 'pengajuan' ? 'active' : '' }} ">
                    <i class="nav-icon 	fas fa-user-friends"></i>
                    <p>Pengajuan</p>
                </a>
            </li>
            <li class="nav-header">Statistik</li>
            <li class="nav-item">
                <a href="{{ url('/statistik') }}" class="nav-link {{ $activeMenu == 'statistik' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <p>Statistik</p>
                </a>
            </li>


            <!-- Fitur Dosen-->
            <li class="nav-header">Kelola Pelatihan Sertifikasi</li>
            <li class="nav-item">
                <a href="{{ url('/pendataan') }}" class="nav-link {{ $activeMenu == 'pendataan' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-address-card"></i>
                    <p>Pendataan</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/penawaran') }}" class="nav-link {{ $activeMenu == 'penawaran' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-envelope-open"></i>
                    <p>Penawaran</p>
                </a>
            </li>



            <!-- Fitur Super Admin-->
            <li class="nav-header">Kelola Pengguna</li>
            <li class="nav-item">
                <a href="{{ url('/jenispengguna') }}" class="nav-link {{ $activeMenu == 'jenispengguna' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-user-alt"></i>
                    <p>Jenis Pengguna</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/dataakun') }}" class="nav-link {{ $activeMenu == 'dataakun' ? 'active' : '' }} ">
                    <i class="nav-icon 	fas fa-unlock-alt"></i>
                    <p>Data Akun Pengguna</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/datapengguna') }}" class="nav-link {{ $activeMenu == 'datapengguna' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-user-friends"></i>
                    <p>Data Pengguna</p>
                </a>
            </li>


            <!-- Fitur Admin -->
            <li class="nav-header">Data Pengguna</li>
            <li class="nav-item">
                <a href="{{ url('/data-dosen') }}" class="nav-link {{ $activeMenu == 'data-dosen' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-user-friends"></i>
                    <p>Data Dosen</p>
                </a>
            </li>
            <li class="nav-header">Kelola Akademik</li>
            <li class="nav-item">
                <a href="{{ url('/periode') }}" class="nav-link {{ $activeMenu == 'periode' ? 'active' : '' }} ">
                    <i class="nav-icon 	far fa-calendar-alt"></i>
                    <p>Periode</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/matkul') }}" class="nav-link {{ $activeMenu == 'matkul' ? 'active' : '' }} ">
                    <i class="nav-icon 	fas fa-award"></i>
                    <p>Mata Kuliah</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/minat') }}" class="nav-link {{ $activeMenu == 'minat' ? 'active' : '' }} ">
                    <i class="nav-icon 	fas fa-folder-open"></i>
                    <p>Bidang Minat</p>
                </a>
            </li>
            <li class="nav-header">Kelola Pelatihan Sertifikasi</li>
            <li class="nav-item">
                <a href="{{ url('/jenis') }}" class="nav-link {{ $activeMenu == 'jenis' ? 'active' : '' }} ">
                    <i class="nav-icon 	fas fa-clipboard"></i>
                    <p>Jenis Pelatihan & Sertifikasi</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/vendor') }}" class="nav-link {{ $activeMenu == 'vendor' ? 'active' : '' }} ">
                    <i class="nav-icon 	fas fa-landmark"></i>
                    <p>Vendor</p>
                    <i class="right fas fa-angle-left"></i>
                </a>
                <ul class="nav nav-treeview">
                    <!-- Submenu Pelatihan -->
                    <li class="nav-item">
                        <a href="{{ url('/vendor/pelatihan') }}"
                            class="nav-link {{ $activeMenu == 'pelatihan' ? 'active' : '' }}">
                            <i class="fa fa-caret-right"></i>
                            <p> Pelatihan</p>
                        </a>
                    </li>
                    <!-- Submenu Sertifikasi -->
                    <li class="nav-item">
                        <a href="{{ url('/vendor/sertifikasi') }}"
                            class="nav-link {{ $activeMenu == 'sertifikasi' ? 'active' : '' }}">
                            <i class="fa fa-caret-right"></i>
                            <p> Sertifikasi</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ url('/pelatihan-sertifikasi') }}" class="nav-link {{ $activeMenu == 'pelatihan-sertifikasi' ? 'active' : '' }} ">
                    <i class="nav-icon 	fas fa-archive"></i>
                    <p>Pelatihan & Sertifikasi</p>
                </a>
            </li>
            <li class="nav-header">Statistik</li>
            <li class="nav-item">
                <a href="{{ url('/statistik') }}" class="nav-link {{ $activeMenu == 'statistik' ? 'active' : '' }} ">
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <p>Statistik</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<style>
    .sidebar {
        background-color: #0D313F;
        /* Mengganti warna gradien menjadi warna solid */
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        padding: 8px;
        font-size: 14px;
        letter-spacing: 0.35px;
    }

    .sidebar .nav-link {
        border-radius: 8px;

        transition: all 0.3s ease;
        padding: 8px 16px;
        color: #ffffff;
    }

    .sidebar .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateX(5px);
    }

    .sidebar .nav-link.active {
        background: rgba(255, 255, 255, 0.2);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar .nav-header {
        color: #ffffff;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 1rem 1rem 0.5rem;
    }

    .nav-link.text-white.bg-danger {
        color: #fff !important;
        background-color: #e74c3c !important;
    }

    .nav-link.active {
        background-color: teal !important;
        /* Warna latar belakang teal */
        color: white !important;
        /* Warna teks putih agar kontras */
        border-radius: 4px;
        /* Opsional: Tambahkan sedikit radius */
        padding: 8px 16px;
    }
</style>
