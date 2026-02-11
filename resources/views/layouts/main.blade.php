
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
      --primary: #ffd700; /* Kuning emas */
      --primary-dark: #b39700; /* Kuning tua */
      --secondary: #000000; /* Hitam */
      --dark: #1a1a1a; /* Hitam gelap */
      --light: #f8f9fa;
      --transition: all 0.3s ease;
      /* Variabel warna oranye */
      --orange: #ff6b00;
      --orange-dark: #e55a00;
      --orange-light: #ff8c33;
    }

    body { 
      margin: 0; 
      padding: 0; 
      color: #333; /* Ubah warna teks menjadi gelap untuk kontras dengan background putih */
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding-top: 70px;
      background: #ffffff; /* UBAH: dari #1a1a1a (hitam) menjadi #ffffff (putih) */
    }

    /* Modern Navbar - Kuning & Hitam */
    .navbar-modern {
      background: linear-gradient(135deg, var(--secondary) 0%, var(--dark) 100%) !important;
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Ubah shadow menjadi lebih soft */
      padding: 0.8rem 0;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      border-bottom: 3px solid var(--primary) !important;
      transition: var(--transition);
    }

    .navbar-scrolled {
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.98) 0%, rgba(26, 26, 26, 0.98) 100%) !important;
      backdrop-filter: blur(20px);
      padding: 0.5rem 0;
    }

    /* PERBAIKAN: Logo konsisten kuning-orange di semua halaman */
    .navbar-brand-modern {
      font-size: 1.5rem;
      font-weight: 800;
      background: linear-gradient(135deg, var(--primary), var(--orange)) !important;
      -webkit-background-clip: text !important;
      -webkit-text-fill-color: transparent !important;
      background-clip: text !important;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      transition: var(--transition);
    }

    @media (min-width: 992px) {
      .navbar-brand-modern {
        font-size: 1.8rem;
      }
    }

    /* Hamburger Menu HANYA tampil di mobile */
    .navbar-toggler-modern {
      border: 2px solid var(--primary) !important;
      padding: 0.5rem 0.7rem !important;
      border-radius: 8px !important;
      background: rgba(255, 215, 0, 0.1) !important;
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
        border: 2px solid var(--primary) !important;
        background: rgba(255, 215, 0, 0.15) !important;
      }
    }

    .navbar-toggler-modern:hover {
      background: rgba(255, 215, 0, 0.2) !important;
      transform: scale(1.05);
    }

    .navbar-toggler-modern:focus {
      box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.3) !important;
      outline: none !important;
    }

    .navbar-toggler-modern:not(.collapsed) {
      background: rgba(255, 215, 0, 0.3) !important;
    }

    .navbar-toggler-icon-modern {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 215, 0, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='3' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
      width: 24px !important;
      height: 24px !important;
      transition: var(--transition);
    }

    .nav-link-modern {
      color: rgba(255, 255, 255, 0.9) !important;
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
      color: var(--primary) !important;
      background: rgba(255, 215, 0, 0.1);
      transform: translateY(-2px);
      text-decoration: none !important;
    }

    /* PERBAIKAN UTAMA: Gradasi ORANYE-KUNING dengan !important */
    .nav-link-modern.active {
      color: white !important;
      background: linear-gradient(135deg, var(--orange), var(--primary)) !important;
      box-shadow: 0 4px 12px rgba(255, 107, 0, 0.4) !important;
      text-decoration: none !important;
      border: none !important;
    }

    .nav-link-modern.active:hover {
      background: linear-gradient(135deg, var(--orange-dark), var(--primary-dark)) !important;
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
      border-top: 1px solid rgba(255, 215, 0, 0.2);
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
      border: 2.8px solid rgba(255, 255, 255, 1);
    }

    .profile-icon:hover {
      transform: scale(1.1);
      border-color: var(--primary);
      box-shadow: 0 0 15px rgba(255, 215, 0, 0.5);
      background: rgba(255, 255, 255, 0.1);
    }

    .profile-icon-simple {
      width: 24px;
      height: 24px;
      filter: invert(1); /* Membuat icon putih */
      opacity: 0.9;
      transition: var(--transition);
    }

    .profile-icon:hover .profile-icon-simple {
      opacity: 1;
      filter: invert(1) sepia(1) saturate(5) hue-rotate(0deg); /* Membuat icon kuning saat hover */
    }

    .dropdown-menu-profile {
      position: absolute;
      top: 100%;
      right: 0;
      background: linear-gradient(135deg, var(--secondary) 0%, var(--dark) 100%);
      border: 1px solid rgba(255, 215, 0, 0.3);
      border-radius: 8px;
      padding: 0.5rem 0;
      min-width: 180px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
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
      color: rgba(255, 255, 255, 0.9);
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
      background: rgba(255, 215, 0, 0.1);
      color: var(--primary);
    }

    .dropdown-divider-profile {
      height: 1px;
      background: rgba(255, 215, 0, 0.2);
      margin: 0.3rem 0;
    }

    /* Buttons dengan Gradasi Oranye */
    .btn-primary-modern {
      background: linear-gradient(135deg, var(--orange), var(--orange-dark)) !important;
      border: none !important;
      border-radius: 8px;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      transition: var(--transition);
      box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3) !important;
      color: white;
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
      box-shadow: 0 6px 20px rgba(255, 107, 0, 0.5) !important;
      background: linear-gradient(135deg, var(--orange-dark), var(--orange)) !important;
      color: white;
      text-decoration: none !important;
    }

    /* PERBAIKAN: Tombol Register konsisten orange/kuning */
    .btn-outline-modern {
      border: 2px solid var(--primary) !important;
      color: var(--primary) !important;
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
      background: var(--primary) !important;
      color: var(--secondary) !important;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3) !important;
      text-decoration: none !important;
    }

    .btn-danger-modern {
      background: linear-gradient(135deg, var(--orange), var(--orange-dark)) !important;
      border: none;
      border-radius: 8px;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      transition: var(--transition);
      box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3) !important;
      color: white;
      width: 100%;
      text-align: center;
      text-decoration: none !important;
    }

    @media (min-width: 992px) {
      .btn-danger-modern {
        width: auto;
      }
    }

    .btn-danger-modern:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 107, 0, 0.5) !important;
      background: linear-gradient(135deg, var(--orange-dark), var(--orange)) !important;
      color: white;
      text-decoration: none !important;
    }

    /* Mobile Menu */
    .navbar-collapse-modern {
      background: linear-gradient(135deg, var(--secondary) 0%, var(--dark) 100%);
      border-radius: 12px;
      margin-top: 1rem;
      padding: 1rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* Ubah shadow menjadi lebih soft */
      border: 1px solid rgba(255, 215, 0, 0.2);
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

    /* Additional Gold Accents */
    .gold-accent {
      color: var(--primary);
    }

    .gold-border {
      border-color: var(--primary);
    }

    /* Mobile Backdrop HANYA di mobile */
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
    }

    @media (max-width: 991.98px) {
      .navbar-backdrop {
        display: block;
      }
    }

    .navbar-backdrop.show {
      opacity: 1;
      visibility: visible;
    }

    /* Hero Section */
    .hero {
      height: 100vh;
      background: linear-gradient(135deg, #ffffff, #f8f9fa); /* UBAH: Background putih untuk hero */
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #333; /* UBAH: Warna teks menjadi gelap */
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
      background: rgba(255, 255, 255, 0.8); /* UBAH: Overlay putih */
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
      text-shadow: 2px 2px 8px rgba(0,0,0,0.1); /* UBAH: Shadow lebih soft */
      background: linear-gradient(135deg, var(--primary), var(--orange)) !important;
      -webkit-background-clip: text !important;
      -webkit-text-fill-color: transparent !important;
      background-clip: text !important;
    }

    .hero-content p {
      font-size: 1.2rem;
      margin-bottom: 2rem;
      opacity: 0.8;
      color: #666; /* UBAH: Warna teks lebih gelap */
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

    .btn-hero-primary {
      background: linear-gradient(135deg, var(--orange), var(--orange-dark)) !important;
      color: white;
      border: none;
      box-shadow: 0 4px 15px rgba(255, 107, 0, 0.4) !important;
    }

    .btn-hero-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(255, 107, 0, 0.6) !important;
      color: white;
      background: linear-gradient(135deg, var(--orange-dark), var(--orange)) !important;
    }

    .btn-hero-secondary {
      background: transparent;
      color: var(--primary);
      border: 2px solid var(--primary);
    }

    .btn-hero-secondary:hover {
      background: var(--primary);
      color: var(--secondary);
      transform: translateY(-3px);
    }

    /* Main Content Area */
    main {
      background: #ffffff; /* UBAH: Pastikan background main putih */
      min-height: calc(100vh - 70px);
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
      .btn-outline-modern,
      .btn-danger-modern {
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

    /* PERBAIKAN: Force override untuk semua elemen yang mungkin masih biru */
    .bg-primary, .btn-primary {
      background: linear-gradient(135deg, var(--orange), var(--orange-dark)) !important;
      border-color: var(--orange) !important;
    }

    /* Reset semua background biru yang mungkin tersisa */
    [class*="bg-"], [class*="btn-"] {
      background-image: none !important;
    }

    /* PERBAIKAN: Override khusus untuk Bootstrap btn-outline-primary */
    .btn-outline-primary {
      border-color: var(--primary) !important;
      color: var(--primary) !important;
      background: transparent !important;
    }

    .btn-outline-primary:hover {
      background: var(--primary) !important;
      color: var(--secondary) !important;
      border-color: var(--primary) !important;
    }

        /* FIX LINK TIDAK BISA DIKLIK */
    .navbar-backdrop {
      pointer-events: none !important;
    }

    .navbar-backdrop.show {
      pointer-events: auto !important;
    }

    .navbar-modern {
      z-index: 9999 !important;
    }

    .hero::before {
      z-index: 0 !important;
    }

    iframe {
            pointer-events: none !important;
        }

  </style>
</head>

<body>

  <!-- Mobile Backdrop HANYA aktif di mobile -->
  <div class="navbar-backdrop" id="navbarBackdrop"></div>

  <!-- Modern Navbar - Kuning & Hitam -->
  <nav class="navbar navbar-expand-lg navbar-modern" id="mainNavbar">
    <div class="container">
      <!-- Beranda -->
      <a class="navbar-brand-modern" href="{{ route('beranda') }}">
        <i class="fas fa-crown gold-accent"></i>
        <span>JURAGAN 96</span>
      </a>

      <!-- Hamburger Menu HANYA tampil di mobile -->
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
                <!-- Simple White Profile Icon -->
                <svg class="profile-icon-simple" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 12C14.2091 12 16 10.2091 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8C8 10.2091 9.79086 12 12 12Z" fill="currentColor"/>
                  <path d="M12 14C9.33 14 4 15.34 4 18V20H20V18C20 15.34 14.67 14 12 14Z" fill="currentColor"/>
                </svg>
              </div>
              <div class="dropdown-menu-profile" id="dropdownMenu">
                <div class="dropdown-item-profile">
                  <i class="fas fa-user-circle me-2"></i>
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
            <!-- PERBAIKAN: Pastikan tombol Register menggunakan class btn-outline-modern -->
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

      // PERBAIKAN: Force remove any remaining blue colors dan konsistensi warna
      function ensureColorConsistency() {
        // Logo JURAGAN 96 - pastikan konsisten kuning-orange
        const logo = document.querySelector('.navbar-brand-modern');
        if (logo) {
          logo.style.background = 'linear-gradient(135deg, #ffd700, #ff6b00) !important';
          logo.style.webkitBackgroundClip = 'text !important';
          logo.style.webkitTextFillColor = 'transparent !important';
        }

        // Tombol Register - pastikan konsisten
        const registerBtn = document.querySelector('a[href*="register"]');
        if (registerBtn) {
          registerBtn.classList.add('btn-outline-modern');
          registerBtn.classList.remove('btn-outline-primary');
          registerBtn.style.borderColor = '#ffd700 !important';
          registerBtn.style.color = '#ffd700 !important';
          registerBtn.style.background = 'transparent !important';
        }

        // Remove any inline styles that might contain blue
        document.querySelectorAll('.nav-link-modern.active').forEach(link => {
          link.style.background = '';
          link.style.backgroundImage = '';
          link.style.backgroundColor = '';
        });
        
        // Force apply our orange gradient
        document.querySelectorAll('.nav-link-modern.active').forEach(link => {
          link.classList.add('force-orange');
        });
      }

      // Handle mobile features HANYA di mobile
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

      // Toggle backdrop berdasarkan state navbar (HANYA di mobile)
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
      });

      // Initialize functions
      ensureColorConsistency(); // Ganti removeBlueColors dengan ensureColorConsistency
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

      // Force apply styles after page load
      setTimeout(ensureColorConsistency, 100);
      setTimeout(ensureColorConsistency, 500);
      
      // Juga apply ketika berpindah halaman
      window.addEventListener('load', ensureColorConsistency);
    });

    // Additional style untuk force override
    const forceStyle = document.createElement('style');
    forceStyle.textContent = `
      .nav-link-modern.active.force-orange {
        background: linear-gradient(135deg, #ff6b00, #ffd700) !important;
        box-shadow: 0 4px 12px rgba(255, 107, 0, 0.4) !important;
      }
      .nav-link-modern.active {
        background: linear-gradient(135deg, #ff6b00, #ffd700) !important;
      }
      .navbar-brand-modern {
        background: linear-gradient(135deg, #ffd700, #ff6b00) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
      }
      .btn-outline-modern, 
      .btn-outline-primary {
        border-color: #ffd700 !important;
        color: #ffd700 !important;
        background: transparent !important;
      }
      .btn-outline-modern:hover,
      .btn-outline-primary:hover {
        background: #ffd700 !important;
        color: #000000 !important;
        border-color: #ffd700 !important;
      }
      
      /* Pastikan background utama putih */
      body, main {
        background-color: #ffffff !important;
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
        }
        
        .dropdown-menu-profile.show {
          transform: translateX(-50%) translateY(0);
        }
      }
    `;
    document.head.appendChild(forceStyle);
  </script>
  
</body>
</html>