@extends('layouts.main')

@section('title', 'Beranda - Juragan 96 Resto')

@section('content')
<!-- Hero Section -->
<section class="hero-section position-relative overflow-hidden">
  <div class="hero-slides">
    @foreach(['resto2.jpg', 'ayam-lodho.jpg', 'nasgor.jpg', 'ayamgeprek.png'] as $image)
    <div class="hero-slide" 
         style="background-image: url('{{ asset("img/$image") }}');"></div>
    @endforeach
  </div>
  
  <div class="hero-overlay"></div>
  
  <div class="container position-relative">
    <div class="row min-vh-100 align-items-center">
      <div class="col-lg-8 col-md-10 mx-auto text-center text-white" data-aos="fade-up" data-aos-duration="1000">
        <h1 class="hero-title fw-bold mb-4">
          Selamat Datang di 
          <span class="text-warning">Juragan 96</span>
        </h1>
        <p class="hero-subtitle lead mb-5">
          Nikmati pengalaman kuliner terbaik dengan cita rasa autentik dan pelayanan modern. 
          Pesan makanan favorit Anda dengan mudah dari mana saja.
        </p>
        <div class="hero-buttons d-flex flex-wrap gap-3 justify-content-center">
          <a href="#menu" class="btn btn-warning btn-lg fw-semibold px-4 py-3 shadow-lg">
            <i class="fas fa-utensils me-2"></i>Lihat Menu
          </a>
          <a href="#reservation" class="btn btn-outline-light btn-lg fw-semibold px-4 py-3">
            <i class="fas fa-calendar-check me-2"></i>Pesan Menu dan Meja
          </a>
        </div>
        
        <!-- Quick Stats -->
        <div class="row mt-5 pt-4">
          <div class="col-md-3 col-6">
            <div class="stat-item">
              <div class="stat-number text-warning fw-bold display-6">50+</div>
              <div class="stat-label">Menu Variatif</div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="stat-item">
              <div class="stat-number text-warning fw-bold display-6">5K+</div>
              <div class="stat-label">Pelanggan</div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="stat-item">
              <div class="stat-number text-warning fw-bold display-6">98%</div>
              <div class="stat-label">Kepuasan</div>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="stat-item">
              <div class="stat-number text-warning fw-bold display-6">24/7</div>
              <div class="stat-label">Layanan</div>
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

<!-- About Section -->
<section class="section-py bg-dark text-white position-relative" id="about">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
        <div class="about-content">
          <span class="section-badge">Tentang Kami</span>
          <h2 class="section-title mb-4">
            Menghadirkan Pengalaman 
            <span class="text-warning">Kuliner Terbaik</span>
          </h2>
          <p class="lead mb-4">
            Juragan 96 Resto adalah destinasi kuliner premium yang menggabungkan cita rasa tradisional 
            dengan sentuhan modern. Setiap hidangan dibuat dengan bahan-bahan pilihan dan resep warisan 
            turun-temurun.
          </p>
          
          <div class="about-features">
            <div class="feature-item d-flex align-items-center mb-3">
              <div class="feature-icon me-3">
                <i class="fas fa-check-circle text-warning"></i>
              </div>
              <span>Bahan-bahan segar dan berkualitas tinggi</span>
            </div>
            <div class="feature-item d-flex align-items-center mb-3">
              <div class="feature-icon me-3">
                <i class="fas fa-check-circle text-warning"></i>
              </div>
              <span>Chef profesional dengan pengalaman bertahun-tahun</span>
            </div>
            <div class="feature-item d-flex align-items-center mb-3">
              <div class="feature-icon me-3">
                <i class="fas fa-check-circle text-warning"></i>
              </div>
              <span>Layanan pemesanan online 24/7</span>
            </div>
          </div>
          
          <a href="#contact" class="btn btn-outline-warning btn-lg mt-3">
            Hubungi Kami
          </a>
        </div>
      </div>
      
      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
        <div class="about-gallery">
          <div class="gallery-grid">
            <div class="gallery-item main-item">
              <img src="{{ asset('img/resto2.jpg') }}" alt="Restaurant Interior" class="img-fluid rounded-3">
            </div>
            <div class="gallery-item">
              <img src="{{ asset('img/ayam-lodho.jpg') }}" alt="Signature Dish" class="img-fluid rounded-3">
            </div>
            <div class="gallery-item">
              <img src="{{ asset('img/nasgor.jpg') }}" alt="Popular Menu" class="img-fluid rounded-3">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="section-py bg-light" id="features">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <span class="section-badge">Keunggulan Kami</span>
      <h2 class="section-title" style="color: black;">Mengapa Memilih Juragan 96?</h2>
      <p class="section-subtitle">Kami berkomitmen memberikan pengalaman terbaik untuk setiap pelanggan</p>
    </div>

    <div class="row g-4">
      <!-- Cita Rasa Autentik -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="feature-card text-center h-100">
          <div class="feature-icon-wrapper mb-4">
            <i class="fas fa-utensils"></i>
          </div>
          <h4 class="fw-bold mb-3">Cita Rasa Autentik</h4>
          <p class="text-muted">
            Setiap hidangan dibuat dengan resep rahasia keluarga yang telah diwariskan turun-temurun, 
            menjamin cita rasa yang konsisten dan autentik.
          </p>
        </div>
      </div>

      <!-- Pelayanan Cepat -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="feature-card text-center h-100">
          <div class="feature-icon-wrapper mb-4">
            <i class="fas fa-bolt"></i>
          </div>
          <h4 class="fw-bold mb-3">Pelayanan Express</h4>
          <p class="text-muted">
            Sistem pemesanan cerdas kami memastikan makanan sampai di meja Anda dalam waktu kurang dari 30 menit.
          </p>
        </div>
      </div>

      <!-- Kenyamanan Pelanggan -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="feature-card text-center h-100">
          <div class="feature-icon-wrapper mb-4">
            <i class="fas fa-heart"></i>
          </div>
          <h4 class="fw-bold mb-3">Kenyamanan Total</h4>
          <p class="text-muted">
            Dari pemesanan online yang mudah hingga suasana restoran yang nyaman, 
            kami memastikan setiap kunjangan istimewa.
          </p>
        </div>
      </div>

      <!-- Additional Features -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
        <div class="feature-card text-center h-100">
          <div class="feature-icon-wrapper mb-4">
            <i class="fas fa-shield-alt"></i>
          </div>
          <h4 class="fw-bold mb-3">Higenis Terjamin</h4>
          <p class="text-muted">
            Standar kebersihan dan keamanan pangan yang ketat untuk memastikan setiap hidangan aman dikonsumsi.
          </p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
        <div class="feature-card text-center h-100">
          <div class="feature-icon-wrapper mb-4">
            <i class="fas fa-truck"></i>
          </div>
          <h4 class="fw-bold mb-3">Gratis Pengantaran</h4>
          <p class="text-muted">
            Gratis biaya pengantaran untuk pesanan di atas Rp 100.000 dalam radius 5 km dari restoran.
          </p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
        <div class="feature-card text-center h-100">
          <div class="feature-icon-wrapper mb-4">
            <i class="fas fa-mobile-alt"></i>
          </div>
          <h4 class="fw-bold mb-3">Teknologi Modern</h4>
          <p class="text-muted">
            Sistem pemesanan berbasis web yang user-friendly dengan notifikasi real-time melalui WhatsApp.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5 bg-warning">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8 mb-4 mb-lg-0">
        <h3 class="fw-bold text-dark mb-2">Siap Menikmati Hidangan Lezat?</h3>
        <p class="text-dark mb-0">Pesan sekarang dan dapatkan promo spesial untuk pembelian pertama!</p>
      </div>
      <div class="col-lg-4 text-lg-end">
        <a href="#menu" class="btn btn-dark btn-lg px-4 py-3 fw-semibold">
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
    --primary: #4361ee;
    --warning: #ffc107;
    --dark: #343a40;
    --light: #f8f9fa;
  }

  /* Hero Section */
  .hero-section {
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
    background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 100%);
  }

  .hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    line-height: 1.2;
  }

  .hero-subtitle {
    font-size: 1.3rem;
    opacity: 0.9;
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
    border-right: 3px solid white;
    border-bottom: 3px solid white;
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

  .section-badge {
    display: inline-block;
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 1rem;
  }

  .section-title {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1.2;
  }

  .section-subtitle {
    font-size: 1.1rem;
    color: #6c757d;
    max-width: 600px;
    margin: 0 auto;
  }

  /* About Section */
  .about-gallery {
    position: relative;
  }

  .gallery-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
  }

  .gallery-item.main-item {
    grid-column: 1 / -1;
  }

  .gallery-item img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .gallery-item.main-item img {
    height: 300px;
  }

  .gallery-item:hover img {
    transform: scale(1.05);
  }

  .feature-icon {
    width: 24px;
    height: 24px;
  }

  /* Feature Cards */
  .feature-card {
    background: white;
    padding: 2.5rem 1.5rem;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
  }

  .feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  }

  .feature-icon-wrapper {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #ffc107, #ffca2c);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 1.8rem;
  }

  /* CTA Section */
  .cta-section {
    background: linear-gradient(135deg, #ffc107, #ffca2c) !important;
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
    
    .gallery-grid {
      grid-template-columns: 1fr;
    }
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
  });
</script>
@endsection