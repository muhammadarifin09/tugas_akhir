@extends('layouts.main')

@section('title', 'Beranda - Juragan 96 Resto')

@section('content')
<!-- Hero Section -->
<section class="hero position-relative overflow-hidden">
  <div class="hero-slides">
    @foreach(['ayam-lodho.jpg', 'nasgor.jpg', 'ayam-lodho.jpg'] as $image)
    <div class="hero-slide" 
         style="background-image: url('{{ asset("img/$image") }}');"></div>
    @endforeach
  </div>
  
  <div class="hero-overlay"></div>
  
  <div class="container position-relative">
    <div class="row min-vh-100 align-items-center">
      <div class="col-lg-8 col-md-10 mx-auto text-center text-dark" data-aos="fade-up" data-aos-duration="1000">
        <h1 class="hero-title fw-bold mb-4">
          Selamat Datang di 
          <span class="text-red">Juragan 96 Resto</span>
        </h1>
        <p class="hero-subtitle lead mb-5">
          Nikmati pengalaman kuliner terbaik dengan cita rasa autentik dan pelayanan modern. 
          Pesan makanan favorit Anda dengan mudah dari mana saja.
        </p>
        <div class="hero-buttons d-flex flex-wrap gap-3 justify-content-center">
          <a href="{{ url('/menu-meja') }}" class="btn btn-hero-primary btn-lg fw-semibold px-4 py-3 shadow-lg">
            <i class="fas fa-utensils me-2"></i>Lihat Menu
          </a>
          <a href="{{ url('/menu-meja') }}" class="btn btn-hero-secondary btn-lg fw-semibold px-4 py-3">
            <i class="fas fa-calendar-alt me-2"></i>BOOK A TABLE
          </a>
        </div>
        
        <!-- Quick Stats -->
        <div class="row mt-5 pt-4">
          <div class="col-md-3 col-6">
            <div class="stat-item">
              <div class="stat-number text-red fw-bold display-6">50+</div>
              <div class="stat-label text-secondary">Menu Variatif</div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="stat-item">
              <div class="stat-number text-red fw-bold display-6">5K+</div>
              <div class="stat-label text-secondary">Pelanggan</div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="stat-item">
              <div class="stat-number text-red fw-bold display-6">98%</div>
              <div class="stat-label text-secondary">Kepuasan</div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="stat-item">
              <div class="stat-number text-red fw-bold display-6">24/7</div>
              <div class="stat-label text-secondary">Layanan</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="scroll-indicator">
      <a href="#about" class="scroll-link">
        <div class="scroll-arrow"></div>
      </a>
    </div>
  </div>
</section>

<!-- WHAT'S HAPPENING Section -->
<section class="section-py" id="about">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="card-red mb-4">
          <div class="card-red-header">
            <h3 class="mb-0 fw-bold">WHAT'S HAPPENING...</h3>
          </div>
          <div class="card-body">
            <!-- Item 1 -->
            <div class="happening-item mb-4">
              <h4 class="text-red fw-bold mb-3">Curabitur eu dolor mauris.</h4>
              <p class="text-secondary mb-3">
                Suspendisse tempor sagittis urna. In ut nulla quis erat sagittis commodo a sed felis. 
                Vestibulum aliquam ultricies erat.
              </p>
              <a href="#" class="btn btn-outline-modern">
                more <i class="fas fa-arrow-right ms-2"></i>
              </a>
            </div>
            
            <!-- Item 2 -->
            <div class="happening-item mb-4">
              <h4 class="text-red fw-bold mb-3">Sed lobortis aliquam facilisis. Nulla facilisi.</h4>
              <p class="text-secondary mb-3">
                Suspendisse tempor sagittis urna. In ut nulla quis erat sagittis commodo a sed felis. 
                Vestibulum aliquam ultricies erat.
              </p>
              <a href="#" class="btn btn-outline-modern">
                more <i class="fas fa-arrow-right ms-2"></i>
              </a>
            </div>
            
            <!-- Item 3 -->
            <div class="happening-item">
              <h4 class="text-red fw-bold mb-3">Pellentesque commodo ultricies eros et pharetra.</h4>
              <p class="text-secondary mb-3">
                Suspendisse tempor sagittis urna. In ut nulla quis erat sagittis commodo a sed felis. 
                Vestibulum aliquam ultricies erat.
              </p>
              <a href="#" class="btn btn-outline-modern">
                more <i class="fas fa-arrow-right ms-2"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Featured Items Section -->
        <div class="row g-4">
          <div class="col-md-6">
            <div class="featured-item card-red h-100">
              <div class="featured-image bg-red-light d-flex align-items-center justify-content-center">
                <h4 class="text-red fw-bold mb-0">FEATURED Dish</h4>
              </div>
              <div class="card-body">
                <h5 class="card-title text-red fw-bold">LOREM IPSUM DOLOR SIT AMET</h5>
                <p class="card-text text-secondary">Experience our chef's special creation for this week.</p>
              </div>
            </div>
          </div>
          
          <div class="col-md-6">
            <div class="featured-item card-red h-100">
              <div class="featured-image bg-red-light d-flex align-items-center justify-content-center">
                <h4 class="text-red fw-bold mb-0">RECOMMENDED Drink</h4>
              </div>
              <div class="card-body">
                <h5 class="card-title text-red fw-bold">Signature Mocktail</h5>
                <p class="card-text text-secondary">Refreshing non-alcoholic beverage with tropical flavors.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Sidebar -->
      <div class="col-lg-4">
        <!-- HOURS Section -->
        <div class="card-red mb-4">
          <div class="card-red-header">
            <h3 class="mb-0 fw-bold">HOURS</h3>
          </div>
          <div class="card-body">
            <h4 class="text-red fw-bold mb-3">DAILY</h4>
            <div class="hours-list">
              <div class="d-flex justify-content-between mb-2">
                <span class="text-secondary">MON – FRI:</span>
                <span class="fw-bold text-dark">10 am - 10 pm</span>
              </div>
              <div class="d-flex justify-content-between">
                <span class="text-secondary">SAT – SUN:</span>
                <span class="fw-bold text-dark">09 am - 11 pm</span>
              </div>
            </div>
            <div class="mt-4">
              <a href="#" class="btn btn-primary-modern w-100">
                <i class="fas fa-gift me-2"></i>GET A GIFT CARD
              </a>
            </div>
          </div>
        </div>
        
        <!-- REVIEWS Section -->
        <div class="card-red mb-4">
          <div class="card-red-header">
            <h3 class="mb-0 fw-bold">REVIEWS</h3>
          </div>
          <div class="card-body">
            <!-- Review 1 -->
            <div class="review-item mb-3">
              <p class="text-secondary fst-italic">
                "Suspendisse tempor sagittis urna. In ut nulla quis erat sagittis commodo a sed felis."
              </p>
              <p class="fw-bold text-red mb-0">- John Doe</p>
            </div>
            
            <hr class="my-3">
            
            <!-- Review 2 -->
            <div class="review-item">
              <p class="text-secondary fst-italic">
                "Suspendisse tempor sagittis urna. In ut nulla quis erat sagittis commodo a sed felis."
              </p>
              <p class="fw-bold text-red mb-0">- Jane Smith</p>
            </div>
          </div>
        </div>
        
        <!-- GIFT A DINNER Section -->
        <div class="card-red border-red">
          <div class="card-body text-center">
            <h4 class="text-red fw-bold mb-3">GIFT A DINNER</h4>
            <p class="text-secondary mb-4">
              Share the gift of fine dining with your loved ones. Perfect for birthdays, anniversaries, or just because.
            </p>
            <a href="#" class="btn btn-primary-modern">
              <i class="fas fa-gift me-2"></i>PURCHASE GIFT CARD
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="section-py bg-red-light" id="features">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <span class="badge-red mb-2">Keunggulan Kami</span>
      <h2 class="section-title text-dark">Mengapa Memilih Juragan 96?</h2>
      <p class="section-subtitle text-secondary">Kami berkomitmen memberikan pengalaman terbaik untuk setiap pelanggan</p>
    </div>

    <div class="row g-4">
      <!-- Cita Rasa Autentik -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="feature-card card-red h-100">
          <div class="feature-icon-wrapper mb-4">
            <i class="fas fa-utensils text-red"></i>
          </div>
          <h4 class="fw-bold mb-3 text-dark">Cita Rasa Autentik</h4>
          <p class="text-secondary">
            Setiap hidangan dibuat dengan resep rahasia keluarga yang telah diwariskan turun-temurun, 
            menjamin cita rasa yang konsisten dan autentik.
          </p>
        </div>
      </div>

      <!-- Pelayanan Cepat -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="feature-card card-red h-100">
          <div class="feature-icon-wrapper mb-4">
            <i class="fas fa-bolt text-red"></i>
          </div>
          <h4 class="fw-bold mb-3 text-dark">Pelayanan Express</h4>
          <p class="text-secondary">
            Sistem pemesanan cerdas kami memastikan makanan sampai di meja Anda dalam waktu kurang dari 30 menit.
          </p>
        </div>
      </div>

      <!-- Kenyamanan Pelanggan -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="feature-card card-red h-100">
          <div class="feature-icon-wrapper mb-4">
            <i class="fas fa-heart text-red"></i>
          </div>
          <h4 class="fw-bold mb-3 text-dark">Kenyamanan Total</h4>
          <p class="text-secondary">
            Dari pemesanan online yang mudah hingga suasana restoran yang nyaman, 
            kami memastikan setiap kunjungan istimewa.
          </p>
        </div>
      </div>

      <!-- Additional Features -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
        <div class="feature-card card-red h-100">
          <div class="feature-icon-wrapper mb-4">
            <i class="fas fa-shield-alt text-red"></i>
          </div>
          <h4 class="fw-bold mb-3 text-dark">Higenis Terjamin</h4>
          <p class="text-secondary">
            Standar kebersihan dan keamanan pangan yang ketat untuk memastikan setiap hidangan aman dikonsumsi.
          </p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
        <div class="feature-card card-red h-100">
          <div class="feature-icon-wrapper mb-4">
            <i class="fas fa-truck text-red"></i>
          </div>
          <h4 class="fw-bold mb-3 text-dark">Gratis Pengantaran</h4>
          <p class="text-secondary">
            Gratis biaya pengantaran untuk pesanan di atas Rp 100.000 dalam radius 5 km dari restoran.
          </p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
        <div class="feature-card card-red h-100">
          <div class="feature-icon-wrapper mb-4">
            <i class="fas fa-mobile-alt text-red"></i>
          </div>
          <h4 class="fw-bold mb-3 text-dark">Teknologi Modern</h4>
          <p class="text-secondary">
            Sistem pemesanan berbasis web yang user-friendly dengan notifikasi real-time melalui WhatsApp.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-red">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8 mb-4 mb-lg-0">
        <h3 class="fw-bold text-white mb-2">Siap Menikmati Hidangan Lezat?</h3>
        <p class="text-white mb-0">Pesan sekarang dan dapatkan promo spesial untuk pembelian pertama!</p>
      </div>
      <div class="col-lg-4 text-lg-end">
        <a href="{{ url('/menu-meja') }}" class="btn btn-hero-secondary btn-lg px-4 py-3 fw-semibold">
          <i class="fas fa-shopping-cart me-2"></i>Pesan Sekarang
        </a>
      </div>
    </div>
  </div>
</section>

<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800,
    once: true,
    offset: 100
  });
</script>

<style>
  :root {
    --red: #d94747;
    --red-dark: #d94747;
    --red-light: #d94747;
    --cream: #fffaf0;
    --beige: #f5f5dc;
    --gold: #d4af37;
    --dark: #2d2d2d;
    --light: #f8f9fa;
  }

  /* Hero Section */
  .hero {
    height: 100vh;
    position: relative;
  }

  .hero-slides {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }

  .hero-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    opacity: 0;
    transition: opacity 1.5s ease-in-out;
  }

  .hero-slide:first-child {
    opacity: 1;
  }

  .hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(255, 250, 240, 0.5) 0%, rgba(240, 230, 210, 0.5) 100%);
  }

  .hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1.2;
  }

  .hero-subtitle {
    font-size: 1.3rem;
    opacity: 0.9;
    color: var(--dark);
  }

  .stat-item {
    padding: 1rem;
  }

  .stat-number {
    font-size: 2.5rem;
  }

  .stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  /* Scroll Indicator */
  .scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
  }

  .scroll-arrow {
    width: 30px;
    height: 30px;
    border-right: 3px solid var(--red);
    border-bottom: 3px solid var(--red);
    transform: rotate(45deg);
    animation: bounce 2s infinite;
  }

  @keyframes bounce {
    0%, 100% { transform: rotate(45deg) translateY(0); }
    50% { transform: rotate(45deg) translateY(-10px); }
  }

  /* Section Styling */
  .section-py {
    padding: 5rem 0;
  }

  .section-title {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 1rem;
  }

  .section-subtitle {
    font-size: 1.1rem;
    color: #6c757d;
    max-width: 600px;
    margin: 0 auto;
  }

  /* Card Styling */
  .card-red {
    background: white;
    border: 1px solid rgba(196, 30, 58, 0.3);
    border-radius: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  }

  .card-red:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    border-color: var(--red);
  }

  .card-red-header {
    background: linear-gradient(135deg, var(--red), var(--red-dark));
    color: white;
    padding: 1rem 1.5rem;
    border-radius: 12px 12px 0 0;
    font-weight: 600;
  }

  .card-body {
    padding: 1.5rem;
  }

  /* Happening Items */
  .happening-item {
    padding-bottom: 1.5rem;
    border-bottom: 1px solid rgba(196, 30, 58, 0.1);
    margin-bottom: 1.5rem;
  }

  .happening-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
    margin-bottom: 0;
  }

  /* Featured Items */
  .featured-item {
    transition: all 0.3s ease;
  }

  .featured-image {
    height: 150px;
    border-radius: 12px 12px 0 0;
    background: linear-gradient(45deg, rgba(196, 30, 58, 0.1), rgba(196, 30, 58, 0.05));
  }

  /* Feature Cards */
  .feature-card {
    text-align: center;
    padding: 2rem 1.5rem;
    height: 100%;
  }

  .feature-icon-wrapper {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, rgba(196, 30, 58, 0.1), rgba(196, 30, 58, 0.05));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 1.5rem;
  }

  /* Review Items */
  .review-item {
    position: relative;
  }

  .review-item:before {
    content: '"';
    position: absolute;
    top: -10px;
    left: -10px;
    font-size: 3rem;
    color: rgba(196, 30, 58, 0.2);
    font-family: Georgia, serif;
  }

  /* Text Colors */
  .text-red {
    color: var(--red) !important;
  }

  .bg-red-light {
    background: linear-gradient(45deg, rgba(196, 30, 58, 0.1), rgba(196, 30, 58, 0.05)) !important;
  }

  .bg-red {
    background: linear-gradient(135deg, var(--red), var(--red-dark)) !important;
  }

  /* Badge */
  .badge-red {
    display: inline-block;
    background: linear-gradient(135deg, var(--red), var(--red-dark));
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .hero-title {
      font-size: 2.5rem;
    }
    
    .hero-subtitle {
      font-size: 1.1rem;
    }
    
    .section-title {
      font-size: 2rem;
    }
    
    .hero-buttons {
      flex-direction: column;
      align-items: center;
    }
    
    .hero-buttons .btn {
      width: 100%;
      max-width: 280px;
    }
  }

  @media (max-width: 576px) {
    .hero-title {
      font-size: 2rem;
    }
    
    .stat-number {
      font-size: 2rem;
    }
  }

  /* Button Styles */
  .btn-hero-primary {
    background: linear-gradient(135deg, var(--red), var(--red-dark)) !important;
    border: none !important;
    color: white !important;
    border-radius: 8px;
    padding: 0.8rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-hero-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(196, 30, 58, 0.4) !important;
  }

  .btn-hero-secondary {
    background: transparent !important;
    border: 2px solid var(--red) !important;
    color: var(--red) !important;
    border-radius: 8px;
    padding: 0.8rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-hero-secondary:hover {
    background: var(--red) !important;
    color: white !important;
    transform: translateY(-2px);
  }
</style>

<script>
  // Hero Slideshow
  document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.hero-slide');
    let currentSlide = 0;
    
    function showSlide(n) {
      slides.forEach(slide => slide.style.opacity = '0');
      slides[n].style.opacity = '1';
    }
    
    function nextSlide() {
      currentSlide = (currentSlide + 1) % slides.length;
      showSlide(currentSlide);
    }
    
    // Start slideshow
    setInterval(nextSlide, 5000);
    
    // Smooth scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // Apply red theme to all cards
    function applyRedTheme() {
      // Add card-red class to all cards that don't have it
      document.querySelectorAll('.card').forEach(card => {
        if (!card.classList.contains('card-red') && !card.classList.contains('feature-card')) {
          card.classList.add('card-red');
        }
      });
      
      // Ensure all red-themed elements have correct colors
      document.querySelectorAll('.text-red').forEach(el => {
        el.style.color = '#c41e3a';
      });
    }

    // Apply theme on load
    window.addEventListener('load', applyRedTheme);
    setTimeout(applyRedTheme, 100);
  });
</script>
@endsection