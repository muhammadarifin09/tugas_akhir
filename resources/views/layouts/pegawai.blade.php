<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard Pegawai')</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  @include('partials.navbar-pegawai')

  <!-- Sidebar -->
  @include('partials.sidebar-pegawai')

  <!-- Content -->
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <h1>@yield('title', 'Dashboard Pegawai')</h1>
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
    <strong>&copy; {{ date('Y') }} Sistem Pegawai Juragan 96 Resto.</strong> All rights reserved.
  </footer>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
