<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard Admin') - Juragan 96 Resto</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary: #4361ee;
      --sidebar-bg: #1a1f36;
      --sidebar-hover: #2d3748;
      --header-bg: #ffffff;
      --card-shadow: 0 4px 6px -1px rgba(0,0,0,.1);
      --transition: all .3s ease;
    }

    * { font-family: 'Inter', sans-serif; }

    body {
      background-color: #f5f7fb;
      overflow-x: hidden;
    }

    /* Sidebar */
    .sidebar-modern {
      background: linear-gradient(180deg, var(--sidebar-bg), #0f141f);
      min-height: 100vh;
      width: 280px;
      position: fixed;
      transition: var(--transition);
    }

    .sidebar-brand {
      padding: 1.5rem;
      text-align: center;
      border-bottom: 1px solid rgba(255,255,255,.1);
    }

    .sidebar-brand a {
      color: #fff;
      font-size: 1.4rem;
      font-weight: 700;
      text-decoration: none;
    }

    .nav-item {
      margin: .3rem .8rem;
    }

    .nav-link {
      color: rgba(255,255,255,.85);
      padding: .8rem 1rem;
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: .75rem;
      transition: var(--transition);
    }

    .nav-link:hover {
      background: var(--sidebar-hover);
      color: #fff;
      transform: translateX(5px);
    }

    .nav-link.active {
      background: linear-gradient(135deg, var(--primary), #6941ee);
      color: #fff;
    }

    /* Main Content */
    .main-content {
      margin-left: 280px;
      transition: var(--transition);
    }

    @media (max-width: 767px) {
      .sidebar-modern {
        transform: translateX(-100%);
        z-index: 1000;
      }
      .sidebar-modern.show {
        transform: translateX(0);
      }
      .main-content {
        margin-left: 0;
      }
    }

    /* Header */
    .main-header {
      background: var(--header-bg);
      box-shadow: var(--card-shadow);
      position: sticky;
      top: 0;
      z-index: 999;
    }

    /* Footer */
    .main-footer {
      background: #fff;
      border-top: 1px solid rgba(0,0,0,.05);
      padding: 1rem;
      margin-top: 2rem;
    }
  </style>
</head>
<body>

<!-- Mobile Toggle -->
<div class="d-md-none position-fixed top-0 start-0 m-3 z-3">
  <button class="btn btn-primary" id="sidebarToggle">
    <i class="fas fa-bars"></i>
  </button>
</div>

<div class="d-flex">

  <!-- Sidebar -->
  <nav class="sidebar-modern d-none d-md-block">
    <div class="sidebar-brand">
      <a href="{{ route('admin.dashboard') }}">
        <i class="fas fa-user-shield me-2"></i>Admin Panel
      </a>
    </div>

   <ul class="nav flex-column mt-3">
  <li class="nav-item">
    <a href="{{ route('admin.dashboard') }}"
       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <i class="fas fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ route('akun.index') }}"
       class="nav-link {{ request()->routeIs('akun.*') ? 'active' : '' }}">
      <i class="fas fa-users"></i>
      <span>Manajemen Akun</span>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ route('admin.produk.index') }}"
       class="nav-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
      <i class="fas fa-utensils"></i>
      <span>Manajemen Menu</span>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ route('admin.pesanan.index') }}"
       class="nav-link {{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
      <i class="fas fa-clipboard-list"></i>
      <span>Manajemen Pesanan</span>
    </a>
  </li>

  <li class="nav-item">
    <a href="{{ route('admin.meja.index') }}"
       class="nav-link {{ request()->routeIs('admin.meja.*') ? 'active' : '' }}">
      <i class="fas fa-chair"></i>
      <span>Manajemen Meja</span>
    </a>
  </li>
    <li class="nav-item">
          <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i>
            <span>Laporan</span>
          </a>
        </li>
</ul>

  </nav>

  <!-- Main Content -->
  <div class="main-content flex-grow-1">

    <!-- Header -->
    <header class="main-header">
      <div class="container-fluid py-3 d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-0 fw-bold">@yield('title', 'Dashboard Admin')</h4>
          <small class="text-muted">Panel pengelolaan sistem</small>
        </div>

        <div class="dropdown">
          <button class="btn dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
            <div class="me-2 text-end">
              <div class="fw-semibold">{{ Auth::user()->name ?? 'Admin' }}</div>
              <small class="text-muted">Administrator</small>
            </div>
            <i class="fas fa-user-circle fa-2x text-primary"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-end">
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button class="dropdown-item text-danger">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
              </button>
            </form>
          </div>
        </div>
      </div>
    </header>

    <!-- Page Content -->
    <main class="container-fluid py-4">
      @yield('content')
    </main>

    <!-- Footer -->
    <footer class="main-footer text-center">
      <strong>&copy; {{ date('Y') }} Juragan 96 Resto.</strong>
      <span class="text-muted">All rights reserved.</span>
    </footer>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('sidebarToggle')?.addEventListener('click', () => {
    document.querySelector('.sidebar-modern').classList.toggle('show');
  });
</script>

@stack('scripts')
</body>
</html>
