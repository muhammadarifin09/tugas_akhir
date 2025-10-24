@extends('layouts.main')
@section('title', 'Pesan Makanan & Meja')

@section('content')
<div class="container py-5">
  <h2 class="fw-bold text-center mb-5">Form Pemesanan</h2>

  {{-- Notifikasi sukses --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card shadow p-4">
    <form action="{{ route('pesan.store') }}" method="POST" id="formPesan">
      @csrf

      <!-- Container Produk -->
      <div id="produkContainer">
        <div class="produk-item border p-3 rounded mb-3">
          <div class="row g-3 align-items-center">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Pilih Menu</label>
              <select class="form-select id_produk" name="id_produk[]" required>
                <option value="">-- Pilih Menu --</option>
                @foreach($produks as $produk)
                  <option value="{{ $produk->id_produk }}" data-harga="{{ $produk->harga }}">
                    {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga,0,',','.') }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-semibold">Jumlah</label>
              <input type="number" name="jumlah[]" class="form-control jumlah" min="1" value="1" required>
            </div>
            <div class="col-md-3 text-end">
              <button type="button" class="btn btn-danger btn-sm hapusProduk mt-4">Hapus</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Tombol Tambah Produk -->
      <div class="mb-3 text-end">
        <button type="button" class="btn btn-success btn-sm" id="tambahProduk">+ Tambah Produk</button>
      </div>

      <!-- Tipe Pesanan -->
      <div class="mb-3">
        <label class="form-label fw-semibold">Tipe Pesanan</label>
        <select class="form-select" name="tipe_pesanan" id="tipe_pesanan" required>
          <option value="makan_ditempat">Makan di Tempat</option>
          <option value="dibawa_pulang">Dibawa Pulang</option>
        </select>
      </div>

      <!-- Pilih Meja -->
      <div class="mb-3" id="pilihanMeja">
        <label class="form-label fw-semibold">Pilih Meja</label>
        <select class="form-select" name="id_meja">
          <option value="">-- Pilih Meja --</option>
          @foreach($mejas as $meja)
            <option value="{{ $meja->id_meja }}" {{ $meja->status == 'tersedia' ? '' : 'disabled' }}>
              Meja {{ $meja->nomor_meja }} {{ $meja->status == 'tersedia' ? '' : '(Sedang Dipakai)' }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Total Harga -->
      <div class="mb-4 text-end">
        <h5 class="fw-bold">Total: <span id="totalHarga">Rp 0</span></h5>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-warning text-white px-5">Kirim Pesanan</button>
      </div>
    </form>
  </div>
</div>

<script>
  function updateTotal() {
    let total = 0;
    document.querySelectorAll('.produk-item').forEach(item => {
      const select = item.querySelector('.id_produk');
      const jumlah = item.querySelector('.jumlah');
      const harga = select.options[select.selectedIndex]?.getAttribute('data-harga');
      if (harga && jumlah.value) {
        total += parseInt(harga) * parseInt(jumlah.value);
      }
    });
    document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
  }

  // Event listener global untuk semua perubahan
  document.addEventListener('change', function(e) {
    if (e.target.classList.contains('id_produk') || e.target.classList.contains('jumlah')) {
      updateTotal();
    }
  });

  // Tombol tambah produk
  document.getElementById('tambahProduk').addEventListener('click', function() {
    const container = document.getElementById('produkContainer');
    const itemBaru = container.firstElementChild.cloneNode(true);
    itemBaru.querySelector('.id_produk').value = '';
    itemBaru.querySelector('.jumlah').value = 1;
    container.appendChild(itemBaru);
    updateTotal();
  });

  // Tombol hapus produk
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('hapusProduk')) {
      const item = e.target.closest('.produk-item');
      item.remove();
      updateTotal();
    }
  });

  // Sembunyikan pilihan meja jika dibawa pulang
  const tipePesanan = document.getElementById('tipe_pesanan');
  const pilihanMeja = document.getElementById('pilihanMeja');
  tipePesanan.addEventListener('change', function() {
    pilihanMeja.style.display = (tipePesanan.value === 'dibawa_pulang') ? 'none' : 'block';
  });

  window.onload = updateTotal;
</script>

<style>
  .card { background: #fff; border-radius: 15px; }
</style>
@endsection
