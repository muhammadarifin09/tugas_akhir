<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'JURAGAN 96 RESTO')</title>

  <!-- ✅ Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Cache Control -->
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  
  <style>
    :root {
      --primary: #d4af37; /* Kuning emas lebih soft */
      --primary-dark: #b39700; /* Kuning tua */
      --secondary: #1a1a1a; /* Hitam gelap */
      --dark: #2d2d2d; /* Hitam lebih terang */
      --light: #f8f9fa;
      --transition: all 0.3s ease;
      --red: #c41e3a; /* MERAH dari gambar */
      --red-dark: #a0152e; /* Merah tua */
      --red-light: #d94747; /* Merah muda */
      --cream: #fffaf0; /* Warna cream untuk background */
      --beige: #f5f5dc; /* Warna beige */
      --gold-light: #f0e6d2; /* Emas muda */
      --orange: #ff6b00; /* Oranye untuk aksen */
    }

    body { 
      margin: 0; 
      padding: 0; 
      color: #333;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding-top: 70px;
      background: var(--cream) !important;
    }

    /* Modern Navbar - Skema Cream & Gold dengan aksen merah */
    .navbar-modern {
      background: linear-gradient(135deg, var(--cream) 0%, var(--beige) 100%) !important;
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      padding: 0.8rem 0;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      border-bottom: 2px solid var(--red) !important; /* UBAH: Border merah */
      transition: var(--transition);
    }

    .navbar-scrolled {
      background: linear-gradient(135deg, rgba(255, 250, 240, 0.98) 0%, rgba(245, 245, 220, 0.98) 100%) !important;
      backdrop-filter: blur(20px);
      padding: 0.5rem 0;
      border-bottom: 2px solid var(--red-dark) !important;
    }

    /* Logo dengan kombinasi gold dan merah */
    .navbar-brand-modern {
      font-size: 1.5rem;
      font-weight: 800;
      background: linear-gradient(135deg, var(--red), var(--primary)) !important; /* KOMBINASI: Merah ke Gold */
      -webkit-background-clip: text !important;
      -webkit-text-fill-color: transparent !important;
      background-clip: text !important;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      transition: var(--transition);
    }

    .navbar-brand-modern:hover {
      background: linear-gradient(135deg, var(--red-dark), var(--primary-dark)) !important;
      -webkit-background-clip: text !important;
      -webkit-text-fill-color: transparent !important;
    }

    @media (min-width: 992px) {
      .navbar-brand-modern {
        font-size: 1.8rem;
      }
    }

    /* Hamburger Menu dengan warna merah */
    .navbar-toggler-modern {
      border: 2px solid var(--red) !important; /* UBAH: Border merah */
      padding: 0.5rem 0.7rem !important;
      border-radius: 8px !important;
      background: rgba(196, 30, 58, 0.1) !important; /* Background merah transparan */
      transition: var(--transition);
      align-items: center !important;
      justify-content: center !important;
      width: 44px !important;
      height: 44px !important;
      display: none !important;
    }

    @media (max-width: 991.98px) {
      .navbar-toggler-modern {
        display: flex !important;
        visibility: visible !important;
        opacity: 1 !important;
        border: 2px solid var(--red) !important;
        background: rgba(196, 30, 58, 0.15) !important;
      }
    }

    .navbar-toggler-modern:hover {
      background: rgba(196, 30, 58, 0.2) !important;
      transform: scale(1.05);
    }

    .navbar-toggler-modern:focus {
      box-shadow: 0 0 0 3px rgba(196, 30, 58, 0.3) !important;
      outline: none !important;
    }

    .navbar-toggler-modern:not(.collapsed) {
      background: rgba(196, 30, 58, 0.3) !important;
    }

    /* Icon toggler warna merah */
    .navbar-toggler-icon-modern {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(196, 30, 58, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='3' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
      width: 24px !important;
      height: 24px !important;
      transition: var(--transition);
    }

    /* Nav Links dengan warna gelap dan hover merah */
    .nav-link-modern {
      color: var(--secondary) !important;
      font-weight: 500;
      padding: 0.7rem 1.2rem !important;
      border-radius: 8px;
      margin: 0.2rem 0;
      transition: var(--transition);
      position: relative;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      text-align: center;
      text-decoration: none !important;
    }

    @media (min-width: 992px) {
      .nav-link-modern {
        margin: 0 0.2rem;
        text-align: left;
      }
    }

    .nav-link-modern:hover {
      color: var(--red) !important; /* UBAH: Hover merah */
      background: rgba(196, 30, 58, 0.1); /* Background merah transparan */
      transform: translateY(-2px);
      text-decoration: none !important;
    }

    /* Active Link - Red Gradient */
    .nav-link-modern.active {
      color: white !important;
      background: linear-gradient(135deg, var(--red), var(--red-dark)) !important; /* UBAH: Gradient merah */
      box-shadow: 0 4px 12px rgba(196, 30, 58, 0.4) !important;
      text-decoration: none !important;
      border: none !important;
    }

    .nav-link-modern.active:hover {
      background: linear-gradient(135deg, var(--red-dark), var(--red)) !important;
      color: white !important;
      transform: translateY(-2px);
    }

    /* User Section */
    .user-section {
      display: flex;
      align-items: center;
      gap: 1rem;
      flex-direction: column;
      width: 100%;
      padding: 1rem 0;
      border-top: 1px solid rgba(196, 30, 58, 0.2); /* UBAH: Border merah */
    }

    @media (min-width: 992px) {
      .user-section {
        flex-direction: row;
        width: auto;
        padding: 0;
        border-top: none;
      }
    }

    /* Profile Dropdown Styles */
    .profile-dropdown {
      position: relative;
    }

    .profile-icon {
      width: 40px;
      height: 40px;
      border-radius: 90%;
      background: transparent;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: var(--transition);
      border: 2.8px solid var(--red); /* UBAH: Border merah */
    }

    .profile-icon:hover {
      transform: scale(1.1);
      border-color: var(--red-dark);
      box-shadow: 0 0 15px rgba(196, 30, 58, 0.5);
      background: rgba(196, 30, 58, 0.1);
    }

    .profile-icon-simple {
      width: 24px;
      height: 24px;
      color: var(--red); /* UBAH: Warna merah */
      opacity: 0.9;
      transition: var(--transition);
    }

    .profile-icon:hover .profile-icon-simple {
      opacity: 1;
      color: var(--red-dark);
    }

    .dropdown-menu-profile {
      position: absolute;
      top: 100%;
      right: 0;
      background: linear-gradient(135deg, var(--cream) 0%, var(--beige) 100%);
      border: 1px solid rgba(196, 30, 58, 0.3); /* UBAH: Border merah */
      border-radius: 8px;
      padding: 0.5rem 0;
      min-width: 180px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      z-index: 1001;
      margin-top: 0.5rem;
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: var(--transition);
    }

    .dropdown-menu-profile.show {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    .dropdown-item-profile {
      color: var(--secondary);
      padding: 0.7rem 1.2rem;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      transition: var(--transition);
      border: none;
      background: none;
      width: 100%;
      text-align: left;
    }

    .dropdown-item-profile:hover {
      background: rgba(196, 30, 58, 0.1); /* UBAH: Background merah transparan */
      color: var(--red);
    }

    .dropdown-divider-profile {
      height: 1px;
      background: rgba(196, 30, 58, 0.2); /* UBAH: Divider merah */
      margin: 0.3rem 0;
    }

    /* Buttons dengan Red Theme - Sesuai gambar */
    .btn-primary-modern {
      background: linear-gradient(135deg, var(--red), var(--red-dark)) !important; /* UBAH: Gradient merah */
      border: none !important;
      border-radius: 8px;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      transition: var(--transition);
      box-shadow: 0 4px 12px rgba(196, 30, 58, 0.3) !important;
      color: white !important;
      width: 100%;
      text-align: center;
      text-decoration: none !important;
    }

    @media (min-width: 992px) {
      .btn-primary-modern {
        width: auto;
      }
    }

    .btn-primary-modern:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(196, 30, 58, 0.5) !important;
      background: linear-gradient(135deg, var(--red-dark), var(--red)) !important;
      color: white !important;
      text-decoration: none !important;
    }

    /* Button Outline dengan Red */
    .btn-outline-modern {
      border: 2px solid var(--red) !important; /* UBAH: Border merah */
      color: var(--red) !important; /* UBAH: Warna merah */
      background: transparent !important;
      border-radius: 8px;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      transition: var(--transition);
      width: 100%;
      text-align: center;
      text-decoration: none !important;
    }

    @media (min-width: 992px) {
      .btn-outline-modern {
        width: auto;
      }
    }

    .btn-outline-modern:hover {
      background: var(--red) !important; /* UBAH: Background merah */
      color: white !important;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(196, 30, 58, 0.3) !important;
      text-decoration: none !important;
    }

    /* Mobile Menu */
    .navbar-collapse-modern {
      background: linear-gradient(135deg, var(--cream) 0%, var(--beige) 100%);
      border-radius: 12px;
      margin-top: 1rem;
      padding: 1rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      border: 1px solid rgba(196, 30, 58, 0.2); /* UBAH: Border merah */
    }

    @media (min-width: 992px) {
      .navbar-collapse-modern {
        background: transparent;
        border-radius: 0;
        margin-top: 0;
        padding: 0;
        box-shadow: none;
        border: none;
      }
    }

    /* Navigation Items */
    .navbar-nav-modern {
      gap: 0.5rem;
    }

    @media (min-width: 992px) {
      .navbar-nav-modern {
        gap: 0;
      }
    }

    /* Red Accents */
    .red-accent {
      color: var(--red) !important;
    }

    .red-border {
      border-color: var(--red) !important;
    }

    .bg-red {
      background-color: var(--red) !important;
    }

    /* Mobile Backdrop */
    .navbar-backdrop {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 999;
      opacity: 0;
      visibility: hidden;
      transition: var(--transition);
      display: none;
      pointer-events: none;
    }

    @media (max-width: 991.98px) {
      .navbar-backdrop {
        display: block;
      }
    }

    .navbar-backdrop.show {
      opacity: 1;
      visibility: visible;
      pointer-events: auto;
    }

    /* Hero Section - Skema Cream dengan aksen merah */
    .hero {
      height: 100vh;
      background: linear-gradient(135deg, var(--cream), var(--gold-light));
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--secondary);
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(255, 250, 240, 0.9), rgba(240, 230, 210, 0.9));
    }

    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 800px;
      padding: 2rem;
    }

    .hero-content h1 {
      font-weight: 700;
      font-size: 3.5rem;
      margin-bottom: 1rem;
      text-shadow: 2px 2px 8px rgba(0,0,0,0.1);
      background: linear-gradient(135deg, var(--red), var(--primary)) !important; /* KOMBINASI: Merah ke Gold */
      -webkit-background-clip: text !important;
      -webkit-text-fill-color: transparent !important;
      background-clip: text !important;
    }

    .hero-content p {
      font-size: 1.2rem;
      margin-bottom: 2rem;
      opacity: 0.8;
      color: #666;
    }

    .hero-buttons {
      display: flex;
      gap: 1rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn-hero {
      padding: 0.8rem 2rem;
      font-size: 1.1rem;
      font-weight: 600;
      border-radius: 8px;
      transition: var(--transition);
      text-decoration: none;
    }

    /* Tombol Hero dengan warna merah */
    .btn-hero-primary {
      background: linear-gradient(135deg, var(--red), var(--red-dark)) !important;
      color: white !important;
      border: none;
      box-shadow: 0 4px 15px rgba(196, 30, 58, 0.4) !important;
    }

    .btn-hero-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(196, 30, 58, 0.6) !important;
      color: white !important;
      background: linear-gradient(135deg, var(--red-dark), var(--red)) !important;
    }

    .btn-hero-secondary {
      background: transparent;
      color: var(--red);
      border: 2px solid var(--red);
    }

    .btn-hero-secondary:hover {
      background: var(--red);
      color: white;
      transform: translateY(-3px);
    }

    /* Main Content Area */
    main {
      background: var(--cream) !important;
      min-height: calc(100vh - 70px);
    }

    /* Card dengan aksen merah */
    .card-red {
      border: 1px solid rgba(196, 30, 58, 0.3);
      border-radius: 12px;
      background: white;
    }

    .card-red-header {
      background: linear-gradient(135deg, var(--red), var(--red-dark));
      color: white;
      padding: 1rem;
      border-radius: 12px 12px 0 0;
    }

    /* Badge merah */
    .badge-red {
      background: linear-gradient(135deg, var(--red), var(--red-dark));
      color: white;
      padding: 0.35rem 0.75rem;
      border-radius: 50rem;
      font-weight: 600;
    }

    /* Footer dengan skema yang sama */
    footer {
      background: linear-gradient(135deg, var(--dark), var(--secondary)) !important;
      color: var(--light);
    }

    footer hr {
      border-color: rgba(196, 30, 58, 0.3);
    }

    /* Responsive Utilities */
    @media (max-width: 575.98px) {
      body {
        padding-top: 60px;
      }
      
      .navbar-brand-modern {
        font-size: 1.3rem;
      }
      
      .nav-link-modern {
        padding: 0.6rem 1rem !important;
        font-size: 0.9rem;
      }
      
      .btn-primary-modern,
      .btn-outline-modern {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
      }

      .navbar-toggler-modern {
        width: 40px !important;
        height: 40px !important;
        padding: 0.4rem 0.6rem !important;
      }
      
      .navbar-toggler-icon-modern {
        width: 20px !important;
        height: 20px !important;
      }

      .hero-content h1 {
        font-size: 2.5rem;
      }

      .hero-content p {
        font-size: 1rem;
      }

      .hero-buttons {
        flex-direction: column;
        align-items: center;
      }

      .btn-hero {
        width: 100%;
        max-width: 250px;
      }

      .profile-icon {
        width: 35px;
        height: 35px;
      }

      .profile-icon-simple {
        width: 20px;
        height: 20px;
      }

      .dropdown-menu-profile {
        min-width: 160px;
        right: -50%;
      }
    }

    /* Animation for mobile menu */
    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .navbar-collapse-modern.show {
      animation: slideDown 0.3s ease-out;
    }

    @media (max-width: 991.98px) {
      .navbar-toggler {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
      }
    }

    /* Force override untuk konsistensi */
    .bg-primary, .btn-primary {
      background: linear-gradient(135deg, var(--red), var(--red-dark)) !important;
      border-color: var(--red) !important;
    }

    .btn-outline-primary {
      border-color: var(--red) !important;
      color: var(--red) !important;
      background: transparent !important;
    }

    .btn-outline-primary:hover {
      background: var(--red) !important;
      color: white !important;
      border-color: var(--red) !important;
    }

    /* Fix untuk backdrop */
    .navbar-modern {
      z-index: 9999 !important;
    }

    .hero::before {
      z-index: 0 !important;
    }

    iframe {
      pointer-events: none !important;
    }

    /* Tambahan untuk skema merah */
    .text-red {
      color: var(--red) !important;
    }

    .bg-red-light {
      background-color: rgba(196, 30, 58, 0.1) !important;
    }

    .border-red {
      border-color: var(--red) !important;
    }

    /* Highlight dengan warna merah */
    .highlight-red {
      position: relative;
    }

    .highlight-red::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 100%;
      height: 3px;
      background: linear-gradient(135deg, var(--red), var(--red-dark));
      border-radius: 2px;
    }

  </style>
</head>

<body>

  <!-- Mobile Backdrop -->
  <div class="navbar-backdrop" id="navbarBackdrop"></div>

  <!-- Modern Navbar - Skema Cream dengan aksen Merah -->
  <nav class="navbar navbar-expand-lg navbar-modern" id="mainNavbar">
    <div class="container">
      <!-- Beranda -->
      <a class="navbar-brand-modern" href="{{ route('beranda') }}">
        <i class="fas fa-crown red-accent"></i> <!-- UBAH: Icon merah -->
        <span>JURAGAN 96</span>
      </a>

      <!-- Hamburger Menu -->
      <button class="navbar-toggler navbar-toggler-modern" type="button" 
              data-bs-toggle="collapse" data-bs-target="#navbarModern"
              aria-controls="navbarModern" aria-expanded="false" 
              aria-label="Toggle navigation">
        <span class="navbar-toggler-icon navbar-toggler-icon-modern"></span>
      </button>

      <!-- Navbar Content -->
      <div class="collapse navbar-collapse navbar-collapse-modern" id="navbarModern">
        <!-- Navigation Links -->
        <ul class="navbar-nav navbar-nav-modern ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link-modern {{ request()->routeIs('beranda') ? 'active' : '' }}"
              href="{{ route('beranda') }}">
              <i class="fas fa-home"></i>
              <span>Beranda</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link-modern tentang-link"
              href="{{ route('beranda') }}#about">
              <i class="fas fa-info-circle"></i>
              <span>Tentang</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link-modern {{ request()->routeIs('keranjang') ? 'active' : '' }}"
              href="{{ route('keranjang') }}">
              <i class="fas fa-shopping-cart"></i>
              <span>Keranjang</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link-modern {{ request()->routeIs('menu-meja') ? 'active' : '' }}"
              href="{{ route('menu-meja') }}">
              <i class="fas fa-list-alt"></i>
              <span>Menu & Meja</span>
            </a>
          </li>

          @auth
            @if(Auth::user()->role == 'pelanggan')
              <li class="nav-item">
                <a class="nav-link-modern {{ request()->routeIs('pelanggan.pesanan') ? 'active' : '' }}"
                  href="{{ route('pelanggan.pesanan') }}">
                  <i class="fas fa-history"></i>
                  <span>Riwayat Pesanan</span>
                </a>
              </li>
            @endif
          @endauth
        </ul>

        <!-- User Section -->
        <div class="user-section">
          @auth
            <!-- Profile Dropdown -->
            <div class="profile-dropdown">
              <div class="profile-icon" id="profileDropdown">
                <!-- Red Profile Icon -->
                <svg class="profile-icon-simple" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 12C14.2091 12 16 10.2091 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8C8 10.2091 9.79086 12 12 12Z" fill="currentColor"/>
                  <path d="M12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z" fill="currentColor"/>
                </svg>
              </div>
              <div class="dropdown-menu-profile" id="dropdownMenu">
                <div class="dropdown-item-profile">
                  <i class="fas fa-user-circle me-2 red-accent"></i>
                  <span>{{ Auth::user()->name }}</span>
                </div>
                <div class="dropdown-divider-profile"></div>
                <a href="{{ route('pelanggan.profil.index') }}" class="dropdown-item-profile">
                  <i class="fas fa-user-edit me-2"></i>
                  <span>Profil</span>
                </a>
                <div class="dropdown-divider-profile"></div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                  @csrf
                  <button type="submit" class="dropdown-item-profile">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    <span>Logout</span>
                  </button>
                </form>
              </div>
            </div>
          @else
            <a href="{{ route('login') }}" class="btn btn-primary-modern">
              <i class="fas fa-sign-in-alt me-1"></i>
              <span>Login</span>
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline-modern">
              <i class="fas fa-user-plus me-1"></i>
              <span>Register</span>
            </a>
          @endauth
        </div>
      </div>
    </div>
  </nav>

  <!-- Konten halaman -->
  <main>
      @yield('content')
  </main>

  <!-- Footer -->
  <footer id="contact" class="bg-dark text-white pt-5 mt-5">
    <div class="container">
      <hr class="border-light">
      <div class="text-center pb-3">
        <p>&copy; {{ date('Y') }} JURAGAN 96 RESTO. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const navbar = document.getElementById('mainNavbar');
      const navbarBackdrop = document.getElementById('navbarBackdrop');
      const navbarToggler = document.querySelector('.navbar-toggler-modern');
      const navbarCollapse = document.getElementById('navbarModern');
      
      // Profile Dropdown Functionality
      const profileDropdown = document.getElementById('profileDropdown');
      const dropdownMenu = document.getElementById('dropdownMenu');
      
      if (profileDropdown && dropdownMenu) {
        // Toggle dropdown when profile icon is clicked
        profileDropdown.addEventListener('click', function(e) {
          e.stopPropagation();
          dropdownMenu.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
          if (!profileDropdown.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.remove('show');
          }
        });
        
        // Close dropdown when clicking on a dropdown item
        dropdownMenu.querySelectorAll('.dropdown-item-profile').forEach(item => {
          item.addEventListener('click', function() {
            dropdownMenu.classList.remove('show');
          });
        });
      }

      // Handle mobile features
      function handleMobileFeatures() {
        if (window.innerWidth < 992) {
          navbarBackdrop.addEventListener('click', function() {
            navbarToggler.click();
            // Also close profile dropdown on mobile backdrop click
            if (dropdownMenu) {
              dropdownMenu.classList.remove('show');
            }
          });

          document.querySelectorAll('.nav-link-modern').forEach(link => {
            link.addEventListener('click', function() {
              if (window.innerWidth < 992) {
                navbarToggler.click();
                // Close profile dropdown on mobile nav link click
                if (dropdownMenu) {
                  dropdownMenu.classList.remove('show');
                }
              }
            });
          });
        }
      }

      // Scroll effect untuk navbar
      function handleScroll() {
        if (window.scrollY > 100) {
          navbar.classList.add('navbar-scrolled');
        } else {
          navbar.classList.remove('navbar-scrolled');
        }
      }

      // Toggle backdrop berdasarkan state navbar
      if (navbarCollapse) {
        navbarCollapse.addEventListener('show.bs.collapse', function() {
          if (window.innerWidth < 992) {
            navbarBackdrop.classList.add('show');
            document.body.style.overflow = 'hidden';
          }
        });

        navbarCollapse.addEventListener('hide.bs.collapse', function() {
          if (window.innerWidth < 992) {
            navbarBackdrop.classList.remove('show');
            document.body.style.overflow = '';
          }
        });
      }

      // Handle Tentang link click
      const tentangLink = document.querySelector('.tentang-link');
      if (tentangLink) {
        tentangLink.addEventListener('click', function(e) {
          if (window.location.pathname === '{{ route('beranda') }}' || 
              window.location.pathname === '/' || 
              window.location.pathname === '') {
            e.preventDefault();
            const aboutSection = document.getElementById('about');
            if (aboutSection) {
              aboutSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
              });
              
              if (window.innerWidth < 992) {
                navbarToggler.click();
              }
            }
          }
        });
      }

      // Handle resize events
      window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
          navbarBackdrop.classList.remove('show');
          document.body.style.overflow = '';
          // Close dropdown on resize to desktop
          if (dropdownMenu) {
            dropdownMenu.classList.remove('show');
          }
        }
        handleMobileFeatures();
      });

      // Initialize functions
      handleMobileFeatures();
      handleScroll();
      window.addEventListener('scroll', handleScroll);

      // Smooth scrolling untuk anchor links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          const href = this.getAttribute('href');
          if (href.includes('#') && !href.includes('{{ route('beranda') }}')) {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
              target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
              });
            }
          }
        });
      });

      // Apply red theme consistency
      function applyRedTheme() {
        // Force red theme on all elements
        document.querySelectorAll('.btn-primary-modern').forEach(btn => {
          btn.style.background = 'linear-gradient(135deg, #c41e3a, #a0152e) !important';
        });
        
        document.querySelectorAll('.nav-link-modern.active').forEach(link => {
          link.style.background = 'linear-gradient(135deg, #c41e3a, #a0152e) !important';
        });
        
        // Apply red accent to crown icon
        const crownIcon = document.querySelector('.fa-crown');
        if (crownIcon) {
          crownIcon.style.color = '#c41e3a !important';
        }
      }

      // Apply on load and resize
      window.addEventListener('load', applyRedTheme);
      window.addEventListener('resize', applyRedTheme);
      
      // Apply theme after a short delay to ensure DOM is ready
      setTimeout(applyRedTheme, 100);
    });

    // Additional style untuk skema merah/cream
    const themeStyle = document.createElement('style');
    themeStyle.textContent = `
      /* Pastikan skema merah/cream konsisten */
      body, main, .navbar-modern, .navbar-collapse-modern {
        background-color: #fffaf0 !important;
      }
      
      .nav-link-modern {
        color: #1a1a1a !important;
      }
      
      .nav-link-modern.active {
        background: linear-gradient(135deg, #c41e3a, #a0152e) !important;
        color: white !important;
      }
      
      .btn-primary-modern, .btn-hero-primary {
        background: linear-gradient(135deg, #c41e3a, #a0152e) !important;
        color: white !important;
      }
      
      .btn-outline-modern, .btn-hero-secondary {
        border-color: #c41e3a !important;
        color: #c41e3a !important;
      }
      
      .btn-outline-modern:hover, .btn-hero-secondary:hover {
        background: #c41e3a !important;
        color: white !important;
      }
      
      .navbar-brand-modern {
        background: linear-gradient(135deg, #c41e3a, #d4af37) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
      }
      
      .fa-crown {
        color: #c41e3a !important;
      }
      
      /* Profile dropdown responsive */
      @media (max-width: 991.98px) {
        .profile-dropdown {
          width: 100%;
          display: flex;
          justify-content: center;
        }
        
        .dropdown-menu-profile {
          position: fixed;
          top: auto;
          left: 50%;
          transform: translateX(-50%) translateY(-10px);
          width: 90%;
          max-width: 280px;
          background: linear-gradient(135deg, #fffaf0, #f5f5dc) !important;
          border: 1px solid rgba(196, 30, 58, 0.3) !important;
        }
        
        .dropdown-menu-profile.show {
          transform: translateX(-50%) translateY(0);
        }
      }
      
      /* Hero section gradient */
      .hero {
        background: linear-gradient(135deg, #fffaf0, #f0e6d2) !important;
      }
      
      .hero-content h1 {
        background: linear-gradient(135deg, #c41e3a, #d4af37) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
      }
      
      /* Active state for nav links */
      .nav-link-modern.active i {
        color: white !important;
      }
    `;
    document.head.appendChild(themeStyle);
  </script>
  
</body>
</html>