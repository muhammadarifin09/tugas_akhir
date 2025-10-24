@extends('layouts.main')

@section('title', 'Beranda')

@section('content')
<!-- Hero -->
<section id="hero"
  style="height: 90vh; background-size: cover; background-position: center; transition: background-image 1s ease;">
  <div class="text-center text-white d-flex align-items-center justify-content-center h-100"
       style="background-color: rgba(0, 0, 0, 0.5);">
    <div data-aos="fade-up">
      <h1 class="fw-bold display-4 mb-3">Selamat Datang di Restoran Kami</h1>
      <p class="lead mb-4">Nikmati makanan favorit Anda dengan mudah secara online!</p>
      <a href="#menu" class="btn btn-warning btn-lg fw-semibold shadow">🍽️ Lihat Menu</a>
    </div>
  </div>
</section>

<!-- Tentang Kami -->
<section class="py-5 bg-dark text-white" id="about">
  <div class="container">
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="fw-bold mb-3 text-warning">Tentang Kami</h2>
      <p class="text-light mx-auto" style="max-width: 700px;">
        Kami adalah restoran modern yang menggabungkan cita rasa tradisional dengan teknologi masa kini.
        Dengan layanan pemesanan online, Anda dapat menikmati berbagai menu lezat tanpa perlu antre.
      </p>
    </div>

    <div class="row g-4 text-center">
      <!-- Cita Rasa Autentik -->
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card bg-transparent border-0 text-white">
          <div class="card-body">
            <div class="icon-circle mb-3">
              <i class="fa-solid fa-utensils fa-2x"></i>
            </div>
            <h5 class="fw-bold mb-2">Cita Rasa Autentik</h5>
            <p>Kami hanya menggunakan bahan-bahan segar dan resep pilihan untuk menjaga cita rasa khas setiap hidangan.</p>
          </div>
        </div>
      </div>

      <!-- Pelayanan Cepat -->
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card bg-transparent border-0 text-white">
          <div class="card-body">
            <div class="icon-circle mb-3">
             <i class="fa-solid fa-bolt fa-2x"></i>
            </div>
            <h5 class="fw-bold mb-2">Pelayanan Cepat</h5>
            <p>Pemesanan dan pengantaran dilakukan dengan cepat agar Anda dapat menikmati makanan dalam kondisi terbaik.</p>
          </div>
        </div>
      </div>

      <!-- Kenyamanan Pelanggan -->
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="card bg-transparent border-0 text-white">
          <div class="card-body">
            <div class="icon-circle mb-3">
             <i class="fa-solid fa-heart fa-2x"></i>
            </div>
            <h5 class="fw-bold mb-2">Kenyamanan Pelanggan</h5>
            <p>Kepuasan Anda adalah prioritas kami — mulai dari rasa, pelayanan, hingga kemudahan transaksi.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Script Background Slideshow -->
<script>
  const hero = document.getElementById("hero");
  const images = [
    "{{ asset('img/resto2.jpg') }}",
    "{{ asset('img/ayam-lodho.jpg') }}",
    "{{ asset('img/nasgor.jpg') }}",
    "{{ asset('img/ayamgeprek.png') }}"
  ];
  let index = 0;

  function changeBackground() {
    hero.style.backgroundImage = `url('${images[index]}')`;
    index = (index + 1) % images.length;
  }
  changeBackground();
  setInterval(changeBackground, 5000);
</script>

<!-- Animasi AOS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 800, once: true });</script>

<style>
  .icon-circle {
    width: 80px;
    height: 80px;
    background-color: #ffc107;
    color: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin: 0 auto;
    transition: all 0.3s ease;
  }

  .icon-circle:hover {
    transform: scale(1.1);
    background-color: #ffca2c;
    color: #222;
  }

  .card {
    transition: all 0.3s ease;
    border-radius: 15px;
  }

  .card:hover {
    transform: translateY(-5px);
  }

  .btn-warning:hover {
    background-color: #e6a500 !important;
    color: #fff !important;
  }
</style>
@endsection
