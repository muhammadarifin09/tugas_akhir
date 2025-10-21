<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Sidebar toggle button-->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
      </li>
    </ul>

    <!-- Right navbar -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-danger btn-sm">
            <i class="fas fa-sign-out-alt"></i> Logout
          </button>
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand -->
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar Menu -->
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item">
  <a href="{{ route('admin.dashboard') }}" 
     class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>Dashboard</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('akun.index') }}" 
     class="nav-link {{ request()->routeIs('akun.*') ? 'active' : '' }}">
    <i class="nav-icon fas fa-users"></i>
    <p>Manajemen Akun</p>
  </a>
</li>

        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <h1>@yield('title', 'Dashboard Admin')</h1>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>
  </div>

  <!-- Footer -->
  <footer class="main-footer text-center">
    <strong>&copy; {{ date('Y') }} Sistem Admin.</strong> All rights reserved.
  </footer>

</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@yield('scripts')
</body>
</html>
