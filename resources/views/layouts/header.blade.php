<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar notif -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-notif" href="#" role="button">
          <i class="fas fa-bell"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="btn btn-sm btn-danger d-flex align-items-center justify-content-center text-white" href="{{ url('/logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
      
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->