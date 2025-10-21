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

<!-- Menu -->
<section id="menu" class="py-5 bg-light text-dark">
  <div class="container">
    <h2 class="fw-bold text-center mb-5">Menu Favorit</h2>
    <div class="row justify-content-center g-4">
      @foreach ($produks as $produk)
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="card shadow-sm border-0 h-100 d-flex flex-column">
            <img src="{{ asset('storage/' . $produk->gambar) }}" 
                 class="card-img-top" 
                 alt="{{ $produk->nama_produk }}"
                 style="height: 200px; object-fit: cover; border-radius: 10px 10px 0 0;">

            <div class="card-body d-flex flex-column text-center">
              <h5 class="card-title fw-semibold text-dark">{{ $produk->nama_produk }}</h5>
              <p class="text-muted small mb-2">{{ $produk->deskripsi ?? '-' }}</p>
              <p class="fw-bold text-danger mb-3">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>

              <div class="mt-auto">
                @auth
                  @if(Auth::user()->role == 'pelanggan')
                    <button class="btn btn-warning text-white px-4" data-bs-toggle="modal" data-bs-target="#pesanModal{{ $produk->id_produk }}">
                      Pesan
                    </button>
                  @endif
                @else
                  <button class="btn btn-warning text-white px-4" data-bs-toggle="modal" data-bs-target="#loginWarningModal">
                    Pesan
                  </button>
                @endauth
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Pesan -->
        <div class="modal fade" id="pesanModal{{ $produk->id_produk }}" tabindex="-1" aria-labelledby="pesanModalLabel{{ $produk->id_produk }}" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Pesan {{ $produk->nama_produk }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="{{ route('pesan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label">Tipe Pesanan</label>
                    <select name="tipe_pesanan" id="tipe_pesanan_{{ $produk->id_produk }}" class="form-select" required>
                      <option value="">-- Pilih Tipe Pesanan --</option>
                      <option value="makan_ditempat">Makan di Tempat</option>
                      <option value="dibawa_pulang">Dibawa Pulang</option>
                    </select>
                  </div>

                  <div class="mb-3" id="mejaField_{{ $produk->id_produk }}" style="display: none;">
                    <label class="form-label">Pilih Meja</label>
                    <select name="id_meja" class="form-select">
                      <option value="">-- Pilih Meja --</option>
                      @foreach($mejas as $m)
                        <option value="{{ $m->id_meja }}">Meja {{ $m->nomor_meja }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="form-label text-dark">Jumlah Pesanan</label>
                    <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-success">Kirim Pesanan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Modal Login -->
<div class="modal fade" id="loginWarningModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title">Peringatan!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center text-dark">
        Anda harus login terlebih dahulu untuk bisa memesan.
      </div>
      <div class="modal-footer justify-content-center">
        <a href="{{ route('login') }}" class="btn btn-primary">Login Sekarang</a>
        <a href="{{ route('register') }}" class="btn btn-outline-secondary">Daftar</a>
      </div>
    </div>
  </div>
</div>

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
