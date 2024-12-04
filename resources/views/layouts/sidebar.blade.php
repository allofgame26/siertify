<!-- Sidebar -->
<div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-header">Profile</li>
        <li class="nav-item">
          <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard')? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('profile') }}" class="nav-link {{ $activeMenu == 'profile' ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Edit Profile</p>
            </a>
        </li>
        <!-- Fitur Pimpinan -->
        <li class="nav-header">Kelola Pelatihan Sertifikasi</li>
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Data Pelatihan & Sertifikasi Dosen</p> 
          </a> 
        </li>
        <li class="nav-item"> 
          <a href="{{ url('/pengajuan') }}" class="nav-link {{ ($activeMenu == 'pengajuan')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Pengajuan</p> 
          </a> 
        </li>
        <li class="nav-header">Statistik</li>  
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Statistik</p> 
          </a> 
        </li>
        <!-- Fitur Dosen-->
        <li class="nav-header">Kelola Pelatihan Sertifikasi</li> 
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Pendataan</p> 
          </a> 
        </li> 
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Penawaran</p> 
          </a> 
        </li> 
        <!-- Fitur Super Admin-->
        <li class="nav-header">Kelola Pengguna</li> 
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Jenis Pengguna</p> 
          </a> 
        </li> 
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Data Akun Pengguna</p> 
          </a> 
        </li>
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Data Pengguna</p> 
          </a> 
        </li>  
        <!-- Fitur Admin -->
        <li class="nav-header">Data Pengguna</li>
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Data Dosen</p> 
          </a> 
        </li>  
        <li class="nav-header">Kelola Akademik</li> 
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Periode</p> 
          </a> 
        </li>
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Mata Kuliah</p> 
          </a> 
        </li>
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Bidang Minat</p> 
          </a> 
        </li>   
        <li class="nav-header">Kelola Pelatihan Sertifikasi</li> 
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Jenis Pelatihan & Sertifikasi</p> 
          </a> 
        </li>
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Vendor</p> 
          </a>
          <ul class="nav nav-treeview">
            <!-- Submenu Pelatihan -->
            <li class="nav-item">
                <a href="{{ url('/vendor/pelatihan') }}" class="nav-link {{ ($activeMenu == 'pelatihan') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pelatihan</p>
                </a>
            </li>
            <!-- Submenu Sertifikasi -->
            <li class="nav-item">
                <a href="{{ url('/vendor/sertifikasi') }}" class="nav-link {{ ($activeMenu == 'sertifikasi') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Sertifikasi</p>
                </a>
            </li>
        </ul> 
        </li>
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Pelatihan & Sertifikasi</p> 
          </a> 
        </li>   
        <li class="nav-header">Statistik</li> 
        <li class="nav-item"> 
          <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} "> 
            <i class="nav-icon fas fa-layer-group"></i> 
            <p>Statistik</p> 
          </a> 
        </li>
        {{-- <li class="nav-item">
          <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link text-white bg-danger"><i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>
        <!-- Form untuk Logout -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>   --}}
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<style>
  .sidebar {
    background: linear-gradient(180deg, #000000 0%, #3498db 100%);
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}

.sidebar .nav-link {
    border-radius: 8px;
    margin: 5px 15px;
    transition: all 0.3s ease;
}

.sidebar .nav-link:hover {
    background-color: rgba(255,255,255,0.1);
    transform: translateX(5px);
}

.sidebar .nav-link.active {
    background: rgba(255,255,255,0.2);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.sidebar .nav-header {
    color: #ecf0f1;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 1rem 1rem 0.5rem;
}

.sidebar-search .form-control-sidebar {
    background: rgba(255,255,255,0.1);
    border: none;
    color: #fff;
}

.sidebar-search .btn-sidebar {
    background: rgba(255,255,255,0.1);
    border: none;
}

/* header.blade.php styles */
.main-header {
    background: #fff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.navbar-light .navbar-nav .nav-link {
    color: #2c3e50;
    font-weight: 500;
    padding: 0.8rem 1rem;
    transition: color 0.3s ease;
}

.navbar-light .navbar-nav .nav-link:hover {
    color: #3498db;
}

.navbar-badge {
    padding: 0.35em 0.6em;
    font-size: 0.75rem;
    border-radius: 0.5rem;
}
</style>