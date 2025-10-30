<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard Pegawai') - Juragan 96 Resto</title>
  
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <style>
    :root {
      --primary: #4361ee;
      --secondary: #6c757d;
      --success: #28a745;
      --info: #17a2b8;
      --warning: #ffc107;
      --danger: #dc3545;
      --light: #f8f9fa;
      --dark: #343a40;
      --sidebar-bg: #1a1f36;
      --sidebar-hover: #2d3748;
      --header-bg: #ffffff;
      --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      --transition: all 0.3s ease;
    }

    * {
      font-family: 'Inter', sans-serif;
    }

    body {
      background-color: #f5f7fb;
      overflow-x: hidden;
    }

    /* Sidebar Modern */
    .sidebar-modern {
      background: linear-gradient(180deg, var(--sidebar-bg) 0%, #0f141f 100%);
      min-height: 100vh;
      box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
      transition: var(--transition);
    }

    .sidebar-brand {
      padding: 1.5rem 1rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      text-align: center;
    }

    .sidebar-brand .brand-text {
      color: white;
      font-size: 1.5rem;
      font-weight: 700;
      text-decoration: none;
    }

    .sidebar-menu {
      padding: 1rem 0;
    }

    .nav-item {
      margin: 0.3rem 0.8rem;
      border-radius: 8px;
      overflow: hidden;
    }

    .nav-link {
      color: rgba(255, 255, 255, 0.8);
      padding: 0.8rem 1rem;
      border-radius: 8px;
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .nav-link:hover {
      background: var(--sidebar-hover);
      color: white;
      transform: translateX(5px);
    }

    .nav-link.active {
      background: linear-gradient(135deg, var(--primary), #6941ee);
      color: white;
      box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
    }

    .nav-link i {
      width: 20px;
      text-align: center;
    }

    /* Main Content */
    .main-content {
      margin-left: 0;
      transition: var(--transition);
    }

    @media (min-width: 768px) {
      .main-content {
        margin-left: 280px;
      }
    }

    /* Header */
    .main-header {
      background: var(--header-bg);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
      backdrop-filter: blur(10px);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .header-content {
      padding: 1rem 0;
    }

    .user-dropdown .dropdown-toggle {
      border: none;
      background: transparent;
      color: var(--dark);
    }

    .user-dropdown .dropdown-menu {
      border: none;
      box-shadow: var(--card-shadow);
      border-radius: 12px;
    }

    /* Cards Modern */
    .card-modern {
      border: none;
      border-radius: 16px;
      box-shadow: var(--card-shadow);
      transition: var(--transition);
      background: white;
      overflow: hidden;
    }

    .card-modern:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .card-header-modern {
      background: linear-gradient(135deg, var(--primary), #6941ee);
      color: white;
      border: none;
      padding: 1.25rem 1.5rem;
      font-weight: 600;
    }

    .stat-card {
      text-align: center;
      padding: 1.5rem;
    }

    .stat-icon {
      width: 60px;
      height: 60px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
      font-size: 1.5rem;
    }

    .stat-icon.primary { background: rgba(67, 97, 238, 0.1); color: var(--primary); }
    .stat-icon.success { background: rgba(40, 167, 69, 0.1); color: var(--success); }
    .stat-icon.warning { background: rgba(255, 193, 7, 0.1); color: var(--warning); }
    .stat-icon.danger { background: rgba(220, 53, 69, 0.1); color: var(--danger); }

    .stat-number {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 0.25rem;
    }

    .stat-label {
      color: var(--secondary);
      font-size: 0.875rem;
      font-weight: 500;
    }

    /* Footer */
    .main-footer {
      background: var(--header-bg);
      border-top: 1px solid rgba(0, 0, 0, 0.05);
      padding: 1.5rem;
      margin-top: 2rem;
    }

    /* Responsive */
    @media (max-width: 767.98px) {
      .sidebar-modern {
        position: fixed;
        z-index: 1000;
        transform: translateX(-100%);
      }
      
      .sidebar-modern.show {
        transform: translateX(0);
      }
      
      .main-content {
        margin-left: 0 !important;
      }
    }

    /* Animation */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in-up {
      animation: fadeInUp 0.6s ease-out;
    }
  </style>
</head>
<body>

<!-- Mobile Menu Button -->
<div class="d-md-none position-fixed top-0 start-0 m-3 z-1000">
  <button class="btn btn-primary" type="button" id="sidebarToggle">
    <i class="fas fa-bars"></i>
  </button>
</div>

<div class="d-flex">
  <!-- Modern Sidebar -->
  <nav class="sidebar-modern position-fixed d-none d-md-block" style="width: 280px;">
    <div class="sidebar-brand">
      <a href="{{ route('pegawai.dashboard') }}" class="brand-text">
        <i class="fas fa-utensils me-2"></i>Juragan 96 Resto
      </a>
    </div>
    
    <div class="sidebar-menu">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a href="{{ route('pegawai.dashboard') }}" class="nav-link {{ request()->routeIs('pegawai.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('pegawai.pesanan.index') }}" class="nav-link {{ request()->routeIs('pegawai.pesanan.*') ? 'active' : '' }}">
            <i class="fas fa-clipboard-list"></i>
            <span>Pesanan</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('pegawai.produk.index') }}" class="nav-link {{ request()->routeIs('pegawai.menu.*') ? 'active' : '' }}">
            <i class="fas fa-utensils"></i>
            <span>Menu</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('pegawai.meja.index') }}" class="nav-link {{ request()->routeIs('pegawai.meja.*') ? 'active' : '' }}">
            <i class="fas fa-chair"></i>
            <span>Meja</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('pegawai.produk.index') }}" class="nav-link {{ request()->routeIs('pegawai.laporan.*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i>
            <span>Laporan</span>
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="main-content flex-grow-1">
    <!-- Header -->
    <header class="main-header">
      <div class="container-fluid">
        <div class="header-content d-flex justify-content-between align-items-center">
          <div>
            <h4 class="mb-0 fw-bold text-dark">@yield('title', 'Dashboard Pegawai')</h4>
            <small class="text-muted">Selamat datang di sistem manajemen restoran</small>
          </div>
          
          <div class="d-flex align-items-center gap-3">
            <!-- Notifications -->
            <div class="dropdown">
              <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-bell"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  3
                </span>
              </button>
              <div class="dropdown-menu dropdown-menu-end">
                <h6 class="dropdown-header">Notifikasi</h6>
                <a class="dropdown-item" href="#">Pesanan baru #123</a>
                <a class="dropdown-item" href="#">Pembayaran berhasil</a>
                <a class="dropdown-item" href="#">Meja tersedia</a>
              </div>
            </div>

            <!-- User Menu -->
            <div class="dropdown user-dropdown">
              <button class="btn dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                <div class="me-2">
                  <div class="fw-semibold">{{ Auth::user()->name ?? 'User' }}</div>
                  <small class="text-muted">Pegawai</small>
                </div>
                <i class="fas fa-user-circle fa-2x text-primary"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user me-2"></i>Profil
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cog me-2"></i>Pengaturan
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="#">
                  <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
              </div>
            </div>
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
      <div class="container-fluid">
        <strong>&copy; {{ date('Y') }} Juragan 96 Resto.</strong> 
        <span class="text-muted">All rights reserved.</span>
      </div>
    </footer>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Mobile sidebar toggle
  document.getElementById('sidebarToggle')?.addEventListener('click', function() {
    document.querySelector('.sidebar-modern').classList.toggle('show');
  });

  // Auto-hide mobile sidebar when clicking outside
  document.addEventListener('click', function(event) {
    const sidebar = document.querySelector('.sidebar-modern');
    const toggleBtn = document.getElementById('sidebarToggle');
    
    if (window.innerWidth < 768 && 
        !sidebar.contains(event.target) && 
        !toggleBtn.contains(event.target)) {
      sidebar.classList.remove('show');
    }
  });

  // Add fade-in animation to cards
  document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card-modern');
    cards.forEach((card, index) => {
      card.style.animationDelay = `${index * 0.1}s`;
      card.classList.add('fade-in-up');
    });
  });

  // Theme switcher (optional)
  function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-bs-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-bs-theme', newTheme);
  }
</script>

@stack('scripts')
</body>
</html>