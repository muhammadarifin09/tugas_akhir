@extends('layouts.main')

@section('title', 'Beranda')

@section('content')
<!-- Hero -->
<section id="hero" 
  style="height: 90vh; background-size: cover; background-position: center; transition: background-image 1s ease;">
  <div class="text-center text-white d-flex align-items-center justify-content-center h-100" 
       style="background-color: rgba(0, 0, 0, 0.5);">
    <div>
      <h1 class="fw-bold">Selamat Datang di Restoran Kami</h1>
      <p>Nikmati makanan favorit Anda dengan mudah secara online!</p>
      <a href="#menu" class="btn btn-custom btn-lg mt-3">Lihat Menu</a>
    </div>
  </div>
</section>

<!-- Tentang Kami -->
<section class="py-5 bg-dark text-white" id="about">
  <div class="container text-center">
    <h2 class="fw-bold mb-4">Tentang Kami</h2>
    <p>Kami menghadirkan berbagai pilihan makanan lezat dengan cita rasa khas, 
      cocok dinikmati bersama keluarga maupun teman.</p>
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

<style>
  .card {
    transition: all 0.3s ease;
    border-radius: 15px;
  }
  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
  }
  .btn-warning:hover {
    background-color: #e68900 !important;
  }
</style>
@endsection
