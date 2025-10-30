<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'JURAGAN 96 RESTO')</title>

  <!-- ✅ Font Awesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
    :root {
      --primary: #ffd700; /* Kuning emas */
      --primary-dark: #b39700; /* Kuning tua */
      --secondary: #000000; /* Hitam */
      --dark: #1a1a1a; /* Hitam gelap */
      --light: #f8f9fa;
      --transition: all 0.3s ease;
    }

    body { 
      margin: 0; 
      padding: 0; 
      color: white;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding-top: 70px; /* Space for fixed navbar */
    }

    /* Modern Navbar - Kuning & Hitam */
    .navbar-modern {
      background: linear-gradient(135deg, var(--secondary) 0%, var(--dark) 100%);
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
      padding: 0.8rem 0;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      border-bottom: 3px solid var(--primary);
      transition: var(--transition);
    }

    .navbar-scrolled {
      background: linear-gradient(135deg, rgba(0, 0, 0, 0.98) 0%, rgba(26, 26, 26, 0.98) 100%) !important;
      backdrop-filter: blur(20px);
      padding: 0.5rem 0;
    }

    .navbar-brand-modern {
      font-size: 1.5rem;
      font-weight: 800;
      background: linear-gradient(135deg, var(--primary), #ffed4e);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
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

    /* PERBAIKAN: Hamburger Menu HANYA tampil di mobile */
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
      /* PERBAIKAN: Sembunyikan di desktop */
      display: none !important;
    }

    /* PERBAIKAN: Tampilkan HANYA di mobile */
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
      /* PERBAIKAN: Hilangkan garis bawah default */
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
      /* PERBAIKAN: Pastikan tidak ada garis bawah saat hover */
      text-decoration: none !important;
    }

    .nav-link-modern.active {
      color: var(--secondary) !important;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
      /* PERBAIKAN: Pastikan tidak ada garis bawah saat active */
      text-decoration: none !important;
    }

    /* PERBAIKAN: HAPUS pseudo-element ::after yang membuat garis bawah */
    /*
    .nav-link-modern::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      width: 0;
      height: 2px;
      background: var(--primary);
      transition: var(--transition);
      transform: translateX(-50%);
    }

    .nav-link-modern:hover::after,
    .nav-link-modern.active::after {
      width: 80%;
    }
    */

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

    .user-greeting {
      color: rgba(255, 255, 255, 0.9);
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      text-align: center;
      /* PERBAIKAN: Hilangkan garis bawah */
      text-decoration: none !important;
    }

    @media (min-width: 992px) {
      .user-greeting {
        text-align: left;
      }
    }

    .user-greeting i {
      color: var(--primary);
    }

    /* Buttons - Kuning & Hitam */
    .btn-primary-modern {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      border: none;
      border-radius: 8px;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      transition: var(--transition);
      box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
      color: var(--secondary);
      width: 100%;
      text-align: center;
      /* PERBAIKAN: Hilangkan garis bawah */
      text-decoration: none !important;
    }

    @media (min-width: 992px) {
      .btn-primary-modern {
        width: auto;
      }
    }

    .btn-primary-modern:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 215, 0, 0.5);
      background: linear-gradient(135deg, var(--primary-dark), var(--primary));
      color: var(--secondary);
      text-decoration: none !important;
    }

    .btn-outline-modern {
      border: 2px solid var(--primary);
      color: var(--primary);
      background: transparent;
      border-radius: 8px;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      transition: var(--transition);
      width: 100%;
      text-align: center;
      /* PERBAIKAN: Hilangkan garis bawah */
      text-decoration: none !important;
    }

    @media (min-width: 992px) {
      .btn-outline-modern {
        width: auto;
      }
    }

    .btn-outline-modern:hover {
      background: var(--primary);
      color: var(--secondary);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
      text-decoration: none !important;
    }

    .btn-danger-modern {
      background: linear-gradient(135deg, #d4af37, #b39700);
      border: none;
      border-radius: 8px;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      transition: var(--transition);
      box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
      color: var(--secondary);
      width: 100%;
      text-align: center;
      /* PERBAIKAN: Hilangkan garis bawah */
      text-decoration: none !important;
    }

    @media (min-width: 992px) {
      .btn-danger-modern {
        width: auto;
      }
    }

    .btn-danger-modern:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(212, 175, 55, 0.5);
      background: linear-gradient(135deg, #b39700, #d4af37);
      color: var(--secondary);
      text-decoration: none !important;
    }

    /* Mobile Menu */
    .navbar-collapse-modern {
      background: linear-gradient(135deg, var(--secondary) 0%, var(--dark) 100%);
      border-radius: 12px;
      margin-top: 1rem;
      padding: 1rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
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

    /* PERBAIKAN: Mobile Backdrop HANYA di mobile */
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
      /* PERBAIKAN: Sembunyikan di desktop */
      display: none;
    }

    /* PERBAIKAN: Tampilkan backdrop HANYA di mobile */
    @media (max-width: 991.98px) {
      .navbar-backdrop {
        display: block;
      }
    }

    .navbar-backdrop.show {
      opacity: 1;
      visibility: visible;
    }

    /* Hero Section (Existing) */
    .hero {
      height: 100vh;
      background-image: url('{{ asset('images/bg-hero.jpg') }}');
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-align: center;
    }

    .hero-content h1 {
      font-weight: 700;
      text-shadow: 2px 2px 8px rgba(0,0,0,0.6);
    }

    .about {
      background-color: #222;
      padding: 60px 0;
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

      /* PERBAIKAN: Pastikan hamburger tetap terlihat di mobile kecil */
      .navbar-toggler-modern {
        width: 40px !important;
        height: 40px !important;
        padding: 0.4rem 0.6rem !important;
      }
      
      .navbar-toggler-icon-modern {
        width: 20px !important;
        height: 20px !important;
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

    /* PERBAIKAN: Hapus force show di desktop - hanya di mobile */
    @media (max-width: 991.98px) {
      .navbar-toggler {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
      }
    }
  </style>
</head>

<body>

  <!-- PERBAIKAN: Mobile Backdrop HANYA aktif di mobile -->
  <div class="navbar-backdrop" id="navbarBackdrop"></div>

  <!-- Modern Navbar - Kuning & Hitam -->
  <nav class="navbar navbar-expand-lg navbar-modern" id="mainNavbar">
    <div class="container">
      <!-- Brand -->
      <a class="navbar-brand-modern" href="{{ route('beranda') }}">
        <i class="fas fa-crown gold-accent"></i>
        <span>JURAGAN 96</span>
      </a>

      <!-- PERBAIKAN: Hamburger Menu HANYA tampil di mobile -->
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
            <a class="nav-link-modern {{ request()->routeIs('pesan') ? 'active' : '' }}"
              href="{{ route('pesan') }}">
              <i class="fas fa-shopping-cart"></i>
              <span>Pesan</span>
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
            <div class="user-greeting">
              <i class="fas fa-user-circle gold-accent"></i>
              <span>Halo, <span class="gold-accent">{{ Auth::user()->name }}</span>!</span>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
              @csrf
              <button type="submit" class="btn btn-danger-modern">
                <i class="fas fa-sign-out-alt me-1"></i>
                <span>Logout</span>
              </button>
            </form>
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

      // PERBAIKAN: Handle mobile features HANYA di mobile
      function handleMobileFeatures() {
        if (window.innerWidth < 992) {
          // Backdrop functionality hanya di mobile
          navbarBackdrop.addEventListener('click', function() {
            navbarToggler.click();
          });

          // Auto-close menu ketika link diklik hanya di mobile
          document.querySelectorAll('.nav-link-modern').forEach(link => {
            link.addEventListener('click', function() {
              if (window.innerWidth < 992) {
                navbarToggler.click();
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
          // Jika sudah di halaman beranda, scroll ke section about
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
              
              // Tutup mobile menu setelah klik (hanya di mobile)
              if (window.innerWidth < 992) {
                navbarToggler.click();
              }
            }
          }
        });
      }

      // Handle resize events
      window.addEventListener('resize', function() {
        // Reset backdrop dan overflow ketika resize ke desktop
        if (window.innerWidth >= 992) {
          navbarBackdrop.classList.remove('show');
          document.body.style.overflow = '';
        }
      });

      // Initialize functions
      handleMobileFeatures();
      handleScroll();
      window.addEventListener('scroll', handleScroll);

      // Smooth scrolling untuk anchor links di halaman yang sama
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          const href = this.getAttribute('href');
          // Hanya handle anchor links di halaman yang sama
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
    });
  </script>
  
</body>
</html>