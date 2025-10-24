<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'JURAGAN 96 RESTO')</title>

  <!-- ✅ Font Awesome aktif dan stabil -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/all.min.css"
  />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { margin: 0; padding: 0; color: white; }
    .btn-custom { background-color: #ff9900; color: white; }
    .btn-custom:hover { background-color: #cc7a00; color: white; }

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
  </style>
</head>

<body>

  <!-- Navbar -->
  <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">JURAGAN 96 RESTO</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">

          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}"
               href="{{ route('beranda') }}">Beranda</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="#about">Tentang</a>
          </li>

          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('pesan') ? 'active' : '' }}"
              href="{{ route('pesan') }}">Pesan</a>
          </li>


          <!-- ✅ Merge Menu + Meja -->
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('menu-meja') ? 'active' : '' }}"
               href="{{ route('menu-meja') }}">Menu & Meja</a>
          </li>

          @auth
            @if(Auth::user()->role == 'pelanggan')
              <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pelanggan.pesanan') ? 'active' : '' }}"
                   href="{{ route('pelanggan.pesanan') }}">Riwayat Pesanan</a>
              </li>
            @endif
          @endauth
        </ul>

        {{-- Kondisi Auth --}}
        @auth
            <span class="navbar-text text-white ms-3">
                Halo, {{ Auth::user()->name }}!
            </span>
            <form action="{{ route('logout') }}" method="POST" class="ms-3">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-custom ms-3">Login</a>
            <a href="{{ route('register') }}" class="btn btn-outline-light ms-2">Register</a>
        @endauth
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
  
  </script>
  
</body>
</html>


