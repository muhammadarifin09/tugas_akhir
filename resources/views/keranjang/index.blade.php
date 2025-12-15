@extends('layouts.main')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-5 mt-4">
  <!-- Header Section -->
  <div class="text-center mb-5">
    <h1 class="fw-bold gradient-text mb-3">Keranjang Belanja</h1>
    <p class="text-muted fs-5">Lengkapi data pesanan Anda sebelum checkout</p>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
      <div class="d-flex align-items-center">
        <i class="fas fa-check-circle me-3 fs-4"></i>
        <div>
          <h5 class="alert-heading mb-1">Berhasil!</h5>
          <p class="mb-0">{{ session('success') }}</p>
        </div>
      </div>
      <button type="button" class="btn-close btn-close-modern" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
      <div class="d-flex align-items-center">
        <i class="fas fa-exclamation-circle me-3 fs-4"></i>
        <div>
          <h5 class="alert-heading mb-1">Error!</h5>
          <p class="mb-0">{{ session('error') }}</p>
        </div>
      </div>
      <button type="button" class="btn-close btn-close-modern" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if(!$keranjang || $items->isEmpty())
    <!-- Empty Cart State -->
    <div class="card card-modern shadow-lg border-0 text-center py-5">
      <div class="card-body">
        <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
        <h3 class="text-muted mb-3">Keranjang Anda Kosong</h3>
        <p class="text-muted mb-4">Silakan tambahkan beberapa item menu terlebih dahulu</p>
        <a href="{{ route('menu-meja') }}" class="btn btn-success btn-lg">
          <i class="fas fa-utensils me-2"></i>
          Pesan Sekarang
        </a>
      </div>
    </div>
  @else
    <form action="{{ route('keranjang.checkout') }}" method="POST" id="checkoutForm">
      @csrf
      <div class="row">
        <!-- Items List & Customer Form -->
        <div class="col-lg-8 mb-4">
          <!-- Customer Information Form -->
          <div class="card card-modern shadow-lg border-0 mb-4">
            <div class="card-header card-header-modern">
              <h3 class="card-title mb-0">
                <i class="fas fa-user me-2"></i>
                Data Pelanggan
              </h3>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <!-- Nama Pelanggan -->
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Nama Pelanggan <span class="text-danger">*</span></label>
                  <input type="text" name="nama_pelanggan" class="form-control" 
                         value="{{ $keranjang->nama_pelanggan }}" 
                         placeholder="Masukkan nama lengkap" required>
                </div>

                <!-- Nomor WhatsApp -->
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Nomor WhatsApp <span class="text-danger">*</span></label>
                  <input type="text" name="no_wa" class="form-control" 
                         value="{{ $keranjang->no_wa }}" 
                         placeholder="Contoh: 081234567890" required>
                  <small class="text-muted">Digunakan untuk konfirmasi pesanan</small>
                </div>

                <!-- Tipe Pesanan -->
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Tipe Pesanan <span class="text-danger">*</span></label>
                  <select name="tipe_pesanan" class="form-select" id="tipePesanan" required>
                    <option value="makan_ditempat" {{ $keranjang->tipe_pesanan == 'makan_ditempat' ? 'selected' : '' }}>Makan di Tempat</option>
                    <option value="dibawa_pulang" {{ $keranjang->tipe_pesanan == 'dibawa_pulang' ? 'selected' : '' }}>Dibawa Pulang</option>
                  </select>
                </div>

                <!-- Meja Selection (Hanya tampil jika makan di tempat) -->
                <div class="col-md-6" id="mejaSelection" style="{{ $keranjang->tipe_pesanan == 'dibawa_pulang' ? 'display: none;' : '' }}">
                  <label class="form-label fw-semibold">Pilih Meja <span class="text-danger">*</span></label>
                  <select name="id_meja" class="form-select">
                    <option value="">-- Pilih Meja --</option>
                    @foreach($mejas as $meja)
                      <option value="{{ $meja->id_meja }}" 
                              {{ $keranjang->id_meja == $meja->id_meja ? 'selected' : '' }}
                              {{ $meja->status != 'tersedia' && $keranjang->id_meja != $meja->id_meja ? 'disabled' : '' }}>
                        Meja {{ $meja->nomor_meja }} 
                        @if($meja->status == 'tersedia')
                          <span class="text-success">• Tersedia</span>
                        @else
                          <span class="text-danger">• Terpakai</span>
                        @endif
                      </option>
                    @endforeach
                  </select>
                </div>

                <!-- Alamat (Hanya tampil jika dibawa pulang) -->
                <div class="col-12" id="alamatSelection" style="{{ $keranjang->tipe_pesanan == 'makan_ditempat' ? 'display: none;' : '' }}">
                  <label class="form-label fw-semibold">Alamat Pengiriman <span class="text-danger">*</span></label>
                  <textarea name="alamat" class="form-control" rows="3" 
                            placeholder="Masukkan alamat lengkap untuk pengiriman">{{ $keranjang->alamat }}</textarea>
                  <small class="text-muted">Wajib diisi untuk pesanan dibawa pulang</small>
                </div>
              </div>
            </div>
          </div>

          <!-- Items List -->
          <div class="card card-modern shadow-lg border-0">
            <div class="card-header card-header-modern">
              <h3 class="card-title mb-0">
                <i class="fas fa-list me-2"></i>
                Item Pesanan
              </h3>
            </div>
            <div class="card-body p-0">
              @foreach($items as $item)
                <div class="cart-item p-4 border-bottom">
                  <div class="row align-items-center">
                    <div class="col-md-2">
                      <img src="{{ asset('storage/' . $item->produk->gambar) }}" 
                           alt="{{ $item->produk->nama_produk }}"
                           class="img-fluid rounded"
                           style="height: 60px; object-fit: cover;"
                           onerror="this.src='https://via.placeholder.com/60x60?text=No+Image'">
                    </div>
                    <div class="col-md-4">
                      <h6 class="fw-bold mb-1">{{ $item->produk->nama_produk }}</h6>
                      <p class="text-muted mb-0 small">Rp {{ number_format($item->harga_saat_dipesan, 0, ',', '.') }} / item</p>
                    </div>
                    <div class="col-md-3">
                      <div class="d-flex align-items-center">
                        <button class="btn btn-outline-secondary btn-sm quantity-btn" 
                                type="button"
                                data-action="decrease" 
                                data-item-id="{{ $item->id_item }}">
                          <i class="fas fa-minus"></i>
                        </button>
                        <span class="mx-3 fw-semibold">{{ $item->qty }}</span>
                        <button class="btn btn-outline-secondary btn-sm quantity-btn" 
                                type="button"
                                data-action="increase" 
                                data-item-id="{{ $item->id_item }}">
                          <i class="fas fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="col-md-2 text-end">
                      <h6 class="fw-bold text-primary">Rp {{ number_format($item->qty * $item->harga_saat_dipesan, 0, ',', '.') }}</h6>
                    </div>
                    <div class="col-md-1 text-end">
                      <button type="button" class="btn btn-sm btn-outline-danger" 
                              onclick="confirmDelete('{{ $item->id_item }}', '{{ $item->produk->nama_produk }}')">
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="d-flex gap-2 mt-3">
            <a href="{{ route('menu-meja') }}" class="btn btn-outline-primary btn-lg flex-fill">
              <i class="fas fa-plus me-2"></i>
              Tambah Item Lain
            </a>
            <button type="button" class="btn btn-outline-danger btn-lg flex-fill" 
                    onclick="confirmClearCart()">
              <i class="fas fa-trash-alt me-2"></i>
              Kosongkan Keranjang
            </button>
          </div>
        </div>

        <!-- Order Summary & Checkout -->
        <div class="col-lg-4">
          <div class="card card-modern shadow-lg border-0 sticky-top" style="top: 100px;">
            <div class="card-header card-header-modern">
              <h3 class="card-title mb-0">
                <i class="fas fa-receipt me-2"></i>
                Ringkasan Pesanan
              </h3>
            </div>
            <div class="card-body">

             <!-- Payment Method -->
              <!-- Payment Method -->
            <div class="mb-4">
                <h6 class="fw-bold mb-3">Metode Pembayaran <span class="text-danger">*</span></h6>
                <div class="payment-options">
                    <div class="form-check card-option mb-3">
                        <input class="form-check-input" type="radio" name="metode_pembayaran" 
                              value="cod" id="cod" {{ $keranjang->metode_pembayaran == 'cod' ? 'checked' : '' }} required>
                        <label class="form-check-label w-100" for="cod">
                            <div class="option-content">
                                <div class="d-flex align-items-start">
                                    <div class="me-3">
                                        <i class="fas fa-money-bill-wave text-success option-icon" 
                                          style="font-size: 1.5rem; width: 40px; height: 40px; 
                                                  display: flex; align-items: center; justify-content: center;
                                                  border-radius: 10px; background: rgba(40, 167, 69, 0.1);"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0">Bayar di Tempat</h6>
                                            
                                        </div>
                                        <p class="text-muted mb-2">Bayar saat pesanan diterima</p>
                                        <div class="alert alert-danger alert-sm mb-0 py-2">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <small class="fw-medium">Jika bayar di tempat maka pesanan akan dimasak setelah melakukan pembayaran</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="form-check card-option">
                        <input class="form-check-input" type="radio" name="metode_pembayaran" 
                              value="transfer" id="transfer" {{ $keranjang->metode_pembayaran == 'transfer' ? 'checked' : '' }}>
                        <label class="form-check-label w-100" for="transfer">
                            <div class="option-content">
                                <div class="d-flex align-items-start">
                                    <div class="me-3">
                                        <i class="fas fa-university text-primary option-icon" 
                                          style="font-size: 1.5rem; width: 40px; height: 40px; 
                                                  display: flex; align-items: center; justify-content: center;
                                                  border-radius: 10px; background: rgba(13, 110, 253, 0.1);"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <h6 class="mb-0">Transfer Bank</h6>
                                            <span class="badge bg-primary">Online</span>
                                        </div>
                                        <p class="text-muted mb-0">Bayar melalui transfer bank sebelum pesanan diproses</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

              <hr>

              <!-- Total -->
              @php
                $total = 0;
                foreach($items as $item) {
                  $total += $item->qty * $item->harga_saat_dipesan;
                }
              @endphp
              
              <div class="total-section mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="fw-semibold">Subtotal:</span>
                  <span class="fw-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <span class="fw-bold fs-5">Total:</span>
                  <span class="fw-bold fs-5 text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
              </div>

              <!-- Checkout Button -->
              <button type="submit" class="btn btn-success btn-lg w-100 py-3" style="background-color: #28a745; border-color: #28a745;">
                  <i class="fas fa-credit-card me-2"></i>
                  Proses Checkout
              </button>

              <div class="text-center mt-3">
                <small class="text-muted">
                  <i class="fas fa-lock me-1"></i>
                  Transaksi Anda aman dan terenkripsi
                </small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>

    <!-- Delete Form (Hidden) -->
    <form id="deleteItemForm" action="" method="POST" style="display: none;">
      @csrf
      @method('DELETE')
    </form>

    <!-- Clear Cart Form (Hidden) -->
    <form id="clearCartForm" action="{{ route('keranjang.kosongkan') }}" method="POST" style="display: none;">
      @csrf
      @method('DELETE')
    </form>
  @endif
</div>

<style>
  .gradient-text {
    background: linear-gradient(135deg, #28a745, #20c997);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .card-modern {
    background: #fff;
    border-radius: 15px;
    border: none;
    overflow: hidden;
  }

  .card-header-modern {
    background: linear-gradient(135deg, #2c3e50, #34495e);
    color: white;
    border-bottom: 3px solid #28a745;
    padding: 1.25rem 1.5rem;
  }

  .card-header-modern .card-title {
    font-size: 1.25rem;
    font-weight: 600;
  }

  .cart-item {
    transition: background-color 0.3s ease;
  }

  .cart-item:hover {
    background-color: #f8f9fa;
  }

  .quantity-btn {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
  }

  .sticky-top {
    position: sticky;
    z-index: 10;
  }

  .btn-success {
    background: linear-gradient(135deg, #28a745, #20c997);
    border: none;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
  }

  .btn-success:hover {
    background: linear-gradient(135deg, #218838, #1ba87e);
    transform: translateY(-2px);
  }

  .total-section {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1rem;
  }

  .card-option {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .card-option:hover {
    border-color: #28a745;
    background: rgba(40, 167, 69, 0.05);
  }

  .card-option .form-check-input:checked {
    background-color: #28a745;
    border-color: #28a745;
  }

  .option-content {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .option-icon {
    font-size: 1.5rem;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
  }

  .form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #dee2e6;
  }

  .form-control:focus, .form-select:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Toggle meja/alamat berdasarkan tipe pesanan
  const tipePesanan = document.getElementById('tipePesanan');
  const mejaSelection = document.getElementById('mejaSelection');
  const alamatSelection = document.getElementById('alamatSelection');

  tipePesanan.addEventListener('change', function() {
    if (this.value === 'makan_ditempat') {
      mejaSelection.style.display = 'block';
      alamatSelection.style.display = 'none';
    } else {
      mejaSelection.style.display = 'none';
      alamatSelection.style.display = 'block';
    }
  });

  // Update quantity
  const quantityButtons = document.querySelectorAll('.quantity-btn');
  quantityButtons.forEach(button => {
    button.addEventListener('click', function() {
      const action = this.getAttribute('data-action');
      const itemId = this.getAttribute('data-item-id');
      updateQuantity(itemId, action);
    });
  });

  function updateQuantity(itemId, action) {
    fetch('{{ route("keranjang.update") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        item_id: itemId,
        action: action
      })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        location.reload();
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Terjadi kesalahan saat update quantity');
    });
  }
});

// Confirm delete function
function confirmDelete(itemId, productName) {
  if (confirm(`Hapus ${productName} dari keranjang?`)) {
    const form = document.getElementById('deleteItemForm');
    form.action = `{{ url('keranjang/hapus-item') }}/${itemId}`;
    form.submit();
  }
}

// Confirm clear cart function
function confirmClearCart() {
  if (confirm('Kosongkan seluruh keranjang?')) {
    document.getElementById('clearCartForm').submit();
  }
}
</script>
@endsection