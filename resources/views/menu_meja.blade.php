@extends('layouts.main')

@section('title', 'Menu & Meja')

@section('content')

<!-- Section: Menu -->
<section class="py-5 bg-light text-dark" id="menu">
  <div class="container">
    <h2 class="fw-bold text-center mb-5">Daftar Menu</h2>
    <div class="row justify-content-center g-4">

      @foreach ($produks as $produk)
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="card shadow-sm border-0 h-100 d-flex flex-column">
            <img src="{{ asset('storage/' . $produk->gambar) }}"
                 class="card-img-top"
                 alt="{{ $produk->nama_produk }}"
                 style="height: 180px; object-fit: cover;">

            <div class="card-body text-center d-flex flex-column">
              <h5 class="fw-semibold">{{ $produk->nama_produk }}</h5>
              <p class="text-muted small">{{ $produk->deskripsi ?? '-' }}</p>
              <p class="fw-bold text-danger">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>

              
            </div>
          </div>
        </div>

        <!-- Modal Pesan -->
        <div class="modal fade" id="pesanModal{{ $produk->id_produk }}"
             tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title">Pesan {{ $produk->nama_produk }}</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
              </div>

              <form action="{{ route('pesan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                <div class="modal-body">

                  <label class="form-label">Jumlah Pesanan</label>
                  <input type="number" class="form-control" name="jumlah" min="1" required>

                  <label class="form-label mt-3">Tipe Pesanan</label>
                  <select class="form-select" name="tipe_pesanan" required>
                    <option value="makan_ditempat">Makan di Tempat</option>
                    <option value="dibawa_pulang">Dibawa Pulang</option>
                  </select>

                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                  <button class="btn btn-success">Kirim Pesanan</button>
                </div>
              </form>
            </div>
          </div>
        </div>

      @endforeach

    </div>
  </div>
</section>

<!-- Section: Meja -->
<section class="py-5 bg-dark text-white" id="meja">
  <div class="container">
    <h2 class="fw-bold text-center mb-5">Daftar Meja</h2>
    
    <div class="row justify-content-center g-4">
      @foreach ($mejas as $meja)
        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="card text-center p-3 shadow-sm">
            <h4 class="fw-bold text-dark">Meja {{ $meja->nomor_meja }}</h4>

            @if ($meja->status == 'tersedia')
              <span class="badge bg-success">Tersedia</span>
            @else
              <span class="badge bg-danger">Sedang Dipakai</span>
            @endif

          </div>
        </div>
      @endforeach
    </div>

  </div>
</section>

<!-- Modal: login warning -->
<div class="modal fade" id="loginWarningModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title text-dark">Peringatan!</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-dark text-center">
        Silahkan login terlebih dahulu untuk memesan.
      </div>
      <div class="modal-footer justify-content-center">
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-outline-secondary">Daftar</a>
      </div>
    </div>
  </div>
</div>

<style>
  .card:hover {
    transform: translateY(-6px);
    transition: .3s;
    box-shadow: 0px 10px 20px rgba(0,0,0,.15);
  }
</style>

@endsection
