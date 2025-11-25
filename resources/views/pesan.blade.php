@extends('layouts.main')
@section('title', 'Pesan Makanan & Meja')

@section('content')
<div class="container py-5 mt-4">
  <!-- Header Section -->
  <div class="text-center mb-5">
    <h1 class="fw-bold gradient-text mb-3">Pesan Makanan & Meja</h1>
    <p class="text-muted fs-5">Nikmati pengalaman kuliner terbaik dengan pemesanan yang mudah dan cepat</p>
  </div>

  {{-- Notifikasi sukses --}}
  @if(session('success'))
    <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
      <div class="d-flex align-items-center">
        <i class="fas fa-check-circle me-3 fs-4"></i>
        <div>
          <h5 class="alert-heading mb-1">Pesanan Berhasil!</h5>
          <p class="mb-0">{{ session('success') }}</p>
        </div>
      </div>
      <button type="button" class="btn-close btn-close-modern" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Main Card -->
  <div class="card card-modern shadow-lg border-0">
    <div class="card-header card-header-modern">
      <h3 class="card-title mb-0">
        <i class="fas fa-utensils me-2"></i>
        Form Pemesanan
      </h3>
    </div>
    <div class="card-body p-4 p-lg-5">
      <form action="{{ route('keranjang.tambah') }}" method="POST" id="formPesan">
        @csrf

        <!-- Container Produk -->
        <div class="mb-4">
          <h5 class="section-title mb-3">
            <i class="fas fa-list me-2"></i>
            Pilih Menu Makanan
          </h5>
          <div id="produkContainer">
            <div class="produk-item card card-hover border-0 shadow-sm p-3 mb-3">
              <div class="row g-3 align-items-center">
                <div class="col-md-6">
                  <label class="form-label fw-semibold text-dark">Pilih Menu</label>
                  <select class="form-select form-select-modern id_produk" name="id_produk[]" required>
                    <option value="">-- Pilih Menu --</option>
                    @foreach($produks as $produk)
                      <option value="{{ $produk->id_produk }}" data-harga="{{ $produk->harga }}">
                        {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga,0,',','.') }}
                      </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3">
                  <label class="form-label fw-semibold text-dark">Jumlah</label>
                  <input type="number" name="jumlah[]" class="form-control form-control-modern jumlah" min="1" value="1" required>
                </div>
                <div class="col-md-3 text-end">
                  <button type="button" class="btn btn-danger-custom btn-sm hapusProduk mt-4">
                    <i class="fas fa-trash me-1"></i>
                    Hapus
                  </button>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-12">
                  <small class="text-muted subtotal-text">Subtotal: Rp 0</small>
                </div>
              </div>
            </div>
          </div>

          <!-- Tombol Tambah Produk -->
          <div class="text-center">
            <button type="button" class="btn btn-success-custom btn-lg" id="tambahProduk">
              <i class="fas fa-plus-circle me-2"></i>
              Tambah Menu Lainnya
            </button>
          </div>
        </div>

        <hr class="my-4">
        
        <!-- Data Pelanggan -->
        <div class="mb-4">
          <h5 class="section-title mb-3">
            <i class="fas fa-user me-2"></i>
            Data Pelanggan
          </h5>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Nama Pelanggan</label>
              <input type="text" name="nama_pelanggan" class="form-control form-control-modern" 
                    placeholder="Masukkan nama Anda" required>
            </div>

            <div class="col-md-6">
              <label class="form-label fw-semibold">Nomor WhatsApp</label>
              <input type="text" name="no_wa" class="form-control form-control-modern" 
                    placeholder="Contoh: 6281234567890" required>
              <small class="text-muted">Digunakan untuk mengirim konfirmasi pesanan</small>
            </div>

            <div class="col-md-12" id="alamatField">
              <label class="form-label fw-semibold">Alamat Lengkap</label>
              <textarea name="alamat" class="form-control form-control-modern" rows="3" 
                        placeholder="Masukkan alamat (khusus untuk dibawa pulang)"></textarea>
            </div>
          </div>
        </div>


        <!-- Tipe Pesanan & Meja Section -->
        <div class="row">
          <div class="col-md-6 mb-4">
            <h5 class="section-title mb-3">
              <i class="fas fa-tag me-2"></i>
              Tipe Pesanan
            </h5>
            <div class="tipe-pesanan-options">
              <div class="form-check card-option">
                <input class="form-check-input" type="radio" name="tipe_pesanan" id="makan_ditempat" value="makan_ditempat" checked>
                <label class="form-check-label" for="makan_ditempat">
                  <div class="option-content">
                    <i class="fas fa-store option-icon"></i>
                    <div>
                      <h6 class="mb-1">Makan di Tempat</h6>
                      <small class="text-muted">Nikmati makanan langsung di resto</small>
                    </div>
                  </div>
                </label>
              </div>
              <div class="form-check card-option">
                <input class="form-check-input" type="radio" name="tipe_pesanan" id="dibawa_pulang" value="dibawa_pulang">
                <label class="form-check-label" for="dibawa_pulang">
                  <div class="option-content">
                    <i class="fas fa-home option-icon"></i>
                    <div>
                      <h6 class="mb-1">Dibawa Pulang</h6>
                      <small class="text-muted">Take away untuk dinikmati di rumah</small>
                    </div>
                  </div>
                </label>
              </div>
            </div>
          </div>

          <div class="col-md-6 mb-4" id="pilihanMeja">
            <h5 class="section-title mb-3">
              <i class="fas fa-chair me-2"></i>
              Pilih Meja
            </h5>
            <select class="form-select form-select-modern" name="id_meja">
              <option value="">-- Pilih Meja --</option>
              @foreach($mejas as $meja)
                <option value="{{ $meja->id_meja }}" {{ $meja->status == 'tersedia' ? '' : 'disabled' }} class="{{ $meja->status == 'tersedia' ? 'text-success' : 'text-danger' }}">
                  Meja {{ $meja->nomor_meja }} 
                  @if($meja->status == 'tersedia')
                    <span class="badge bg-success">Tersedia</span>
                  @else
                    <span class="badge bg-danger">Terpakai</span>
                  @endif
                </option>
              @endforeach
            </select>
            <small class="text-muted mt-2 d-block">
              <i class="fas fa-info-circle me-1"></i>
              Pilih meja yang tersedia untuk pengalaman makan yang nyaman
            </small>
          </div>
        </div>

        <!-- Metode Pembayaran -->
        <div class="mb-4">
          <h5 class="section-title mb-3">
            <i class="fas fa-wallet me-2"></i>
            Metode Pembayaran
          </h5>

          <div class="form-check card-option">
            <input class="form-check-input" type="radio" name="metode_pembayaran" value="cod" checked>
            <label class="form-check-label">
              <div class="option-content">
                <i class="fas fa-money-bill option-icon"></i>
                <div>
                  <h6 class="mb-1">Bayar di Tempat</h6>
                  <small class="text-muted">Bayar saat pesanan diterima</small>
                </div>
              </div>
            </label>
          </div>

          <div class="form-check card-option mt-3">
            <input class="form-check-input" type="radio" name="metode_pembayaran" value="transfer">
            <label class="form-check-label">
              <div class="option-content">
                <i class="fas fa-university option-icon"></i>
                <div>
                  <h6 class="mb-1">Transfer Bank</h6>
                  <small class="text-muted">Bayar melalui transfer</small>
                </div>
              </div>
            </label>
          </div>
        </div>


        <!-- Total Harga Section -->
        <div class="total-section card border-0 bg-gradient-primary text-white p-4 mb-4">
          <div class="row align-items-center">
            <div class="col-md-8">
              <h5 class="mb-1">Total Pembayaran</h5>
              <p class="mb-0 opacity-75">Termasuk semua menu yang dipesan</p>
            </div>
            <div class="col-md-4 text-end">
              <h2 class="mb-0 fw-bold" id="totalHarga">Rp 0</h2>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
          <button type="submit" class="btn btn-success-submit btn-lg px-5 py-3">
            <i class="fas fa-paper-plane me-2"></i>
            Tambahkan Ke Keranjang
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Sembunyikan atau tampilkan alamat sesuai tipe pesanan
function toggleAlamatField() {
  const tipe = document.querySelector('input[name="tipe_pesanan"]:checked').value;
  const alamatField = document.getElementById('alamatField');

  alamatField.style.display = (tipe === 'dibawa_pulang') ? 'block' : 'none';
}

// Event untuk perubahan tipe pesanan
document.querySelectorAll('input[name="tipe_pesanan"]').forEach(input => {
  input.addEventListener('change', toggleAlamatField);
});

// Load awal saat halaman dibuka
window.addEventListener('load', toggleAlamatField);


  function updateTotal() {
    let total = 0;
    document.querySelectorAll('.produk-item').forEach(item => {
      const select = item.querySelector('.id_produk');
      const jumlah = item.querySelector('.jumlah');
      const harga = select.options[select.selectedIndex]?.getAttribute('data-harga');
      const subtotalText = item.querySelector('.subtotal-text');
      
      if (harga && jumlah.value) {
        const subtotal = parseInt(harga) * parseInt(jumlah.value);
        total += subtotal;
        subtotalText.textContent = 'Subtotal: Rp ' + subtotal.toLocaleString('id-ID');
      } else {
        subtotalText.textContent = 'Subtotal: Rp 0';
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
    itemBaru.querySelector('.subtotal-text').textContent = 'Subtotal: Rp 0';
    container.appendChild(itemBaru);
    updateTotal();
  });

  // Tombol hapus produk
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('hapusProduk')) {
      const items = document.querySelectorAll('.produk-item');
      if (items.length > 1) {
        const item = e.target.closest('.produk-item');
        item.style.opacity = '0';
        setTimeout(() => {
          item.remove();
          updateTotal();
        }, 300);
      } else {
        // Reset form jika hanya tersisa satu item
        const item = items[0];
        item.querySelector('.id_produk').value = '';
        item.querySelector('.jumlah').value = 1;
        item.querySelector('.subtotal-text').textContent = 'Subtotal: Rp 0';
        updateTotal();
      }
    }
  });

  // Toggle pilihan meja berdasarkan tipe pesanan
  const tipePesananInputs = document.querySelectorAll('input[name="tipe_pesanan"]');
  const pilihanMeja = document.getElementById('pilihanMeja');
  
  tipePesananInputs.forEach(input => {
    input.addEventListener('change', function() {
      pilihanMeja.style.display = (this.value === 'dibawa_pulang') ? 'none' : 'block';
    });
  });

  // Animasi untuk card option
  document.querySelectorAll('.card-option').forEach(option => {
    option.addEventListener('click', function() {
      document.querySelectorAll('.card-option').forEach(opt => {
        opt.classList.remove('active');
      });
      this.classList.add('active');
    });
  });

  window.onload = updateTotal;
</script>

<style>
  :root {
    --primary: #ffd700;
    --primary-dark: #b39700;
    --secondary: #000000;
    --dark: #1a1a1a;
    --light: #f8f9fa;
    --success: #28a745;
    --danger: #dc3545;
    --success-hover: #218838;
    --danger-hover: #c82333;
  }

  .gradient-text {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .card-modern {
    background: #fff;
    border-radius: 20px;
    border: none;
    overflow: hidden;
  }

  .card-header-modern {
    background: linear-gradient(135deg, var(--secondary), var(--dark));
    color: white;
    border-bottom: 3px solid var(--primary);
    padding: 1.5rem 2rem;
  }

  .card-header-modern .card-title {
    font-size: 1.5rem;
    font-weight: 700;
  }

  .card-hover {
    transition: all 0.3s ease;
  }

  .card-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
  }

  .form-select-modern, .form-control-modern {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
  }

  .form-select-modern:focus, .form-control-modern:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
  }

  .section-title {
    color: var(--dark);
    font-weight: 600;
    font-size: 1.1rem;
    border-left: 4px solid var(--primary);
    padding-left: 1rem;
  }

  .tipe-pesanan-options {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .card-option {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 0;
  }

  .card-option:hover {
    border-color: var(--primary);
    background: rgba(255, 215, 0, 0.05);
  }

  .card-option.active {
    border-color: var(--primary);
    background: rgba(255, 215, 0, 0.1);
  }

  .card-option .form-check-input {
    margin-top: 0.3rem;
  }

  .card-option .form-check-input:checked {
    background-color: var(--primary);
    border-color: var(--primary);
  }

  .option-content {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .option-icon {
    font-size: 1.5rem;
    color: var(--primary);
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 215, 0, 0.1);
    border-radius: 10px;
  }

  .total-section {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.3);
  }

  /* TOMBOL TAMBAH PRODUK - WARNA HIJAU TETAP */
  .btn-success-custom {
    background: linear-gradient(135deg, #28a745, #20c997) !important;
    border: none !important;
    border-radius: 12px;
    color: white !important;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
  }

  .btn-success-custom:hover {
    background: linear-gradient(135deg, #218838, #1ba87e) !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    color: white !important;
  }

  .btn-success-custom:active {
    transform: translateY(0);
    box-shadow: 0 2px 10px rgba(40, 167, 69, 0.3);
  }

  /* TOMBOL KIRIM PESANAN - WARNA HIJAU */
  .btn-success-submit {
    background: linear-gradient(135deg, #28a745, #20c997) !important;
    border: none !important;
    border-radius: 12px;
    color: white !important;
    font-weight: 600;
    font-size: 1.1rem;
    padding: 1rem 2rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
  }

  .btn-success-submit:hover {
    background: linear-gradient(135deg, #218838, #1ba87e) !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.6);
    color: white !important;
  }

  .btn-success-submit:active {
    transform: translateY(0);
    box-shadow: 0 2px 10px rgba(40, 167, 69, 0.3);
  }

  /* TOMBOL HAPUS - WARNA MERAH TETAP */
  .btn-danger-custom {
    background: linear-gradient(135deg, #dc3545, #e74c3c) !important;
    border: none !important;
    border-radius: 8px;
    color: white !important;
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
  }

  .btn-danger-custom:hover {
    background: linear-gradient(135deg, #c82333, #c0392b) !important;
    color: white !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
  }

  .btn-danger-custom:active {
    transform: translateY(0);
    box-shadow: 0 1px 6px rgba(220, 53, 69, 0.3);
  }

  .alert-modern {
    border: none;
    border-radius: 15px;
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    border-left: 5px solid var(--success);
    color: #155724;
  }

  .btn-close-modern {
    opacity: 0.8;
  }

  .btn-close-modern:hover {
    opacity: 1;
  }

  .produk-item {
    transition: all 0.3s ease;
  }

  .subtotal-text {
    font-weight: 500;
    color: var(--primary-dark) !important;
  }

  .badge {
    font-size: 0.7em;
    margin-left: 0.5rem;
  }

  @media (max-width: 768px) {
    .container.py-5 {
      padding-top: 2rem !important;
      padding-bottom: 2rem !important;
    }
    
    .card-body {
      padding: 1.5rem !important;
    }
    
    .option-content {
      flex-direction: column;
      text-align: center;
      gap: 0.5rem;
    }
    
    .btn-success-submit {
      width: 100%;
      padding: 1rem;
    }
  }
</style>
@endsection