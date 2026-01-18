@extends('layouts.main')

@section('title', 'Menu & Meja')

@section('content')

<!-- Main Navigation Tabs -->
<section class="py-4 bg-white shadow-sm sticky-top" style="top: 56px; z-index: 1020;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <ul class="nav nav-pills nav-justified" id="mainTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="makanan-tab" data-bs-toggle="tab" data-bs-target="#makanan" type="button" role="tab">
              <i class="fas fa-utensils me-2"></i>List Makanan
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="minuman-tab" data-bs-toggle="tab" data-bs-target="#minuman" type="button" role="tab">
              <i class="fas fa-coffee me-2"></i>List Minuman
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="meja-tab" data-bs-toggle="tab" data-bs-target="#meja" type="button" role="tab">
              <i class="fas fa-chair me-2"></i>List Meja
            </button>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Tab Content -->
<div class="tab-content" id="mainTabContent">
  
  <!-- Tab: Makanan -->
  <div class="tab-pane fade show active" id="makanan" role="tabpanel" aria-labelledby="makanan-tab">
    <section class="py-5 bg-light text-dark">
      <div class="container">
        <h2 class="fw-bold text-center mb-5">Daftar Menu Makanan</h2>
        
        <!-- Search Section -->
        <div class="row mb-4 justify-content-center">
          <div class="col-md-6">
            <div class="input-group mx-auto" style="max-width: 500px;">
              <span class="input-group-text bg-warning text-white">
                <i class="fas fa-search"></i>
              </span>
              <input type="text" id="searchMakanan" class="form-control" placeholder="Cari makanan...">
            </div>
          </div>
        </div>

        <div class="row justify-content-center g-4" id="makananContainer">
          @foreach ($produks->where('jenis', 'makanan') as $produk)
            <!-- NOTE: col-6 untuk xs agar 2 produk per baris di handphone -->
            <div class="col-6 col-md-4 col-lg-3 menu-item makanan-item" 
                 data-name="{{ strtolower($produk->nama_produk) }}"
                 data-category="{{ strtolower($produk->jenis ?? 'utama') }}">
              <div class="card shadow-sm border-0 h-100 d-flex flex-column product-card">
                <img src="{{ asset('storage/' . $produk->gambar) }}"
                     class="card-img-top"
                     alt="{{ $produk->nama_produk }}"
                     style="height: 180px; object-fit: cover;"
                     onerror="this.src='https://via.placeholder.com/300x180?text=No+Image'">

                <div class="card-body text-center d-flex flex-column p-3">
                  <h6 class="fw-bold text-truncate mb-2" title="{{ $produk->nama_produk }}">{{ $produk->nama_produk }}</h6>
                  <p class="text-muted small mb-2 flex-grow-1" style="min-height: 40px;">
                    {{ $produk->deskripsi ? Str::limit($produk->deskripsi, 60) : 'Tidak ada deskripsi' }}
                  </p>
                  <p class="fw-bold text-danger mb-3">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>

                  <!-- Tombol Tambah ke Keranjang -->
                  @auth
                    @if($produk->stok > 0)
                      <button class="btn btn-success btn-sm add-to-cart w-100" 
                              data-product-id="{{ $produk->id_produk }}"
                              data-product-name="{{ $produk->nama_produk }}"
                              data-product-price="{{ $produk->harga }}"
                              data-product-stock="{{ $produk->stok }}">
                        <i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang
                      </button>
                    @else
                      <button class="btn btn-secondary btn-sm w-100" disabled>
                        <i class="fas fa-times me-1"></i> Stok Habis
                      </button>
                    @endif
                  @else
                    <button class="btn btn-success btn-sm w-100" data-bs-toggle="modal" data-bs-target="#loginWarningModal">
                      <i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang
                    </button>
                  @endauth
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- No Results Message -->
        <div id="noResultsMakanan" class="text-center mt-5" style="display: none;">
          <i class="fas fa-search fa-3x text-muted mb-3"></i>
          <h4 class="text-muted">Makanan tidak ditemukan</h4>
          <p class="text-muted">Coba kata kunci lain atau filter yang berbeda</p>
        </div>
      </div>
    </section>
  </div>

  <!-- Tab: Minuman -->
  <div class="tab-pane fade" id="minuman" role="tabpanel" aria-labelledby="minuman-tab">
    <section class="py-5 bg-light text-dark">
      <div class="container">
        <h2 class="fw-bold text-center mb-5">Daftar Menu Minuman</h2>
        
        <!-- Search Section -->
        <div class="row mb-4 justify-content-center">
          <div class="col-md-6">
            <div class="input-group mx-auto" style="max-width: 500px;">
              <span class="input-group-text bg-warning text-white">
                <i class="fas fa-search"></i>
              </span>
              <input type="text" id="searchMinuman" class="form-control" placeholder="Cari minuman...">
            </div>
          </div>
        </div>

        <div class="row justify-content-center g-4" id="minumanContainer">
          @foreach ($produks->where('jenis', 'minuman') as $produk)
            <!-- NOTE: col-6 untuk xs agar 2 produk per baris di handphone -->
            <div class="col-6 col-md-4 col-lg-3 menu-item minuman-item" 
                 data-name="{{ strtolower($produk->nama_produk) }}"
                 data-category="{{ strtolower($produk->jenis ?? 'minuman') }}">
              <div class="card shadow-sm border-0 h-100 d-flex flex-column product-card">
                <img src="{{ asset('storage/' . $produk->gambar) }}"
                     class="card-img-top"
                     alt="{{ $produk->nama_produk }}"
                     style="height: 180px; object-fit: cover;"
                     onerror="this.src='https://via.placeholder.com/300x180?text=No+Image'">

                <div class="card-body text-center d-flex flex-column p-3">
                  <h6 class="fw-bold text-truncate mb-2" title="{{ $produk->nama_produk }}">{{ $produk->nama_produk }}</h6>
                  <p class="text-muted small mb-2 flex-grow-1" style="min-height: 40px;">
                    {{ $produk->deskripsi ? Str::limit($produk->deskripsi, 60) : 'Tidak ada deskripsi' }}
                  </p>
                  <p class="fw-bold text-danger mb-3">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>

                  <!-- Tombol Tambah ke Keranjang -->
                  @auth
                    @if($produk->stok > 0)
                      <button class="btn btn-success btn-sm add-to-cart w-100" 
                              data-product-id="{{ $produk->id_produk }}"
                              data-product-name="{{ $produk->nama_produk }}"
                              data-product-price="{{ $produk->harga }}"
                              data-product-stock="{{ $produk->stok }}">
                        <i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang
                      </button>
                    @else
                      <button class="btn btn-secondary btn-sm w-100" disabled>
                        <i class="fas fa-times me-1"></i> Stok Habis
                      </button>
                    @endif
                  @else
                    <button class="btn btn-success btn-sm w-100" data-bs-toggle="modal" data-bs-target="#loginWarningModal">
                      <i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang
                    </button>
                  @endauth
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- No Results Message -->
        <div id="noResultsMinuman" class="text-center mt-5" style="display: none;">
          <i class="fas fa-search fa-3x text-muted mb-3"></i>
          <h4 class="text-muted">Minuman tidak ditemukan</h4>
          <p class="text-muted">Coba kata kunci lain atau filter yang berbeda</p>
        </div>
      </div>
    </section>
  </div>

  <!-- Tab: Meja -->
  <div class="tab-pane fade" id="meja" role="tabpanel" aria-labelledby="meja-tab">
    <section class="py-5 bg-dark text-white">
      <div class="container">
        <h2 class="fw-bold text-center mb-5">Daftar Meja Tersedia</h2>
        
        <div class="row justify-content-center g-4">
          @foreach ($mejas as $meja)
            <div class="col-lg-2 col-md-3 col-sm-4 col-6">
              <div class="card text-center p-3 shadow-sm h-100 {{ $meja->status == 'tersedia' ? 'border-success' : 'border-danger' }}">
                <div class="card-body p-2">
                  <div class="meja-icon mb-2">
                    <i class="fas fa-chair fa-2x {{ $meja->status == 'tersedia' ? 'text-success' : 'text-danger' }}"></i>
                  </div>

                  <h5 class="fw-bold {{ $meja->status == 'tersedia' ? 'text-success' : 'text-danger' }}">
                    Meja {{ $meja->nomor_meja }}
                  </h5>

                  @if ($meja->status == 'tersedia')
                    <span class="badge bg-success">
                      <i class="fas fa-check me-1"></i> Tersedia
                    </span>
                    <small class="text-muted d-block mt-1">
                      Kapasitas: {{ $meja->kapasitas ?? 4 }} orang
                    </small>
                  @else
                    <span class="badge bg-danger">
                      <i class="fas fa-times me-1"></i> Terpakai
                    </span>
                    <small class="text-muted d-block mt-1">Sedang digunakan</small>
                  @endif

                  <!-- 🔍 TOMBOL DETAIL MEJA -->
                  <button class="btn btn-sm btn-outline-info mt-2"
                          data-bs-toggle="modal"
                          data-bs-target="#detailMejaModal{{ $meja->id_meja }}">
                    <i class="fas fa-info-circle"></i> Detail
                  </button>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Meja Info -->
        <div class="text-center mt-4">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Info Meja:</strong> Pilih "Makan di Tempat" saat checkout untuk reservasi meja. Status meja update secara real-time.
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

{{-- ================= MODAL DETAIL MEJA ================= --}}
@foreach ($mejas as $meja)
<div class="modal fade" id="detailMejaModal{{ $meja->id_meja }}" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">

      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">
          <i class="fas fa-chair me-2"></i>
          Detail Meja {{ $meja->nomor_meja }}
        </h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">

        <img src="{{ $meja->gambar 
            ? asset('storage/'.$meja->gambar) 
            : asset('images/meja-default.png') }}"
             class="img-fluid rounded mb-3"
             style="max-height: 200px; object-fit: cover;">

        <table class="table table-bordered text-start">
          <tr>
            <th width="40%">Nomor Meja</th>
            <td>Meja {{ $meja->nomor_meja }}</td>
          </tr>
          <tr>
            <th>Status</th>
            <td>
              <span class="badge {{ $meja->status == 'tersedia' ? 'bg-success' : 'bg-danger' }}">
                {{ ucfirst($meja->status) }}
              </span>
            </td>
          </tr>
          <tr>
            <th>Kapasitas</th>
            <td>{{ $meja->kapasitas ?? 4 }} orang</td>
          </tr>
          <tr>
            <th>Deskripsi</th>
            <td>{{ $meja->deskripsi ?? 'Tidak ada deskripsi meja.' }}</td>
          </tr>
        </table>

      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times me-1"></i> Tutup
        </button>
      </div>

    </div>
  </div>
</div>
@endforeach
{{-- ================= END MODAL DETAIL MEJA ================= --}}


<!-- Fixed Bottom Cart Section -->
@auth
  <div class="fixed-bottom bg-white border-top shadow-lg" style="z-index: 1040;">
    <div class="container">
      <div class="row align-items-center py-3">
        <div class="col-md-8">
          <div class="d-flex align-items-center">
            <div class="me-4">
              <h6 class="fw-bold text-dark mb-1">Total</h6>
              <h4 class="fw-bold text-success mb-0">Rp {{ number_format($totalHarga ?? 0, 0, ',', '.') }}</h4>
            </div>
            <div>
              <small class="text-muted">
                @if($cartCount > 0)
                  <i class="fas fa-check-circle text-success me-1"></i>
                  {{ $cartCount }} item di keranjang
                @else
                  <i class="fas fa-shopping-cart text-muted me-1"></i>
                  Keranjang kosong
                @endif
              </small>
            </div>
          </div>
        </div>
        <div class="col-md-4 text-end">
          <a href="{{ route('keranjang') }}" class="btn btn-success btn-lg px-5">
            <i class="fas fa-shopping-cart me-2"></i>
            Lihat Keranjang
          </a>
        </div>
      </div>
    </div>
  </div>
@else
  <div class="fixed-bottom bg-white border-top shadow-lg" style="z-index: 1040;">
    <div class="container">
      <div class="row align-items-center py-3">
        <div class="col-md-8">
          <h6 class="fw-bold text-dark mb-0">
            <i class="fas fa-info-circle text-primary me-2"></i>
            Login untuk mulai berbelanja dan memesan menu favorit Anda
          </h6>
        </div>
     <div class="col-md-4 text-end">
        <div class="d-flex gap-2 justify-content-end">

          <!-- Tombol Login (Biru) -->
          <a href="{{ route('login') }}" class="btn" style="background-color: #0d6efd; color: white;">
            <i class="fas fa-sign-in-alt me-1"></i> Login
          </a>

          <!-- Tombol Daftar (Kuning) -->
          <a href="{{ route('register') }}" class="btn" style="background-color: #ffc107; color: black;">
            <i class="fas fa-user-plus me-1"></i> Daftar
          </a>

        </div>
      </div>
      </div>
    </div>
  </div>
@endauth

<!-- Modal: Quick Add to Cart -->
<div class="modal fade" id="quickCartModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">
          <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
        </h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="quickCartForm" method="POST">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="id_produk" id="modalProductId">
          <div class="mb-3">
            <label class="form-label fw-semibold">Produk</label>
            <input type="text" class="form-control" id="modalProductName" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Harga Satuan</label>
            <input type="text" class="form-control" id="modalProductPrice" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Jumlah <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="jumlah" value="1" min="1" max="10" required id="quantityInput">
            <small class="text-muted" id="stockInfo">Stok tersedia: <span id="availableStock">0</span></small>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Subtotal</label>
            <input type="text" class="form-control fw-bold text-success" id="modalSubtotal" value="Rp 0" readonly>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Batal
          </button>
          <button type="submit" class="btn btn-success">
            <i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal: login warning -->
<div class="modal fade" id="loginWarningModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title text-dark">
          <i class="fas fa-exclamation-triangle me-2"></i>Peringatan!
        </h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-dark text-center">
        <i class="fas fa-shopping-cart fa-2x text-warning mb-3"></i>
        <p class="mb-3">Silahkan login terlebih dahulu untuk menambahkan item ke keranjang.</p>
      </div>
      <div class="modal-footer justify-content-center">
      <a href="{{ route('login') }}" class="btn" style="background-color: #0d6efd; color: white;">
    <i class="fas fa-sign-in-alt me-1"></i> Login
      </a>

      <a href="{{ route('register') }}" class="btn" style="background-color: #ffc107; color: black;">
          <i class="fas fa-user-plus me-1"></i> Daftar
      </a>
      </div>
    </div>
  </div>
</div>

<style>
  .nav-pills .nav-link {
    color: #495057;
    font-weight: 500;
    padding: 12px 20px;
    border-radius: 10px;
    margin: 0 5px;
    transition: all 0.3s ease;
  }

  .nav-pills .nav-link.active {
    background: linear-gradient(135deg, #ff5405ff 0%, #ffcc00ac 100%);
    color: white;
    box-shadow: 0 1px 9px rgba(38, 13, 1, 1);
  }

  .nav-pills .nav-link:hover:not(.active) {
    background-color: #e9ecef;
    color: #495057;
  }

  .sticky-top {
    backdrop-filter: blur(10px);
    background-color: rgba(255, 255, 255, 0.95);
  }

  .card:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
  }

  .product-card {
    border-radius: 12px;
    overflow: hidden;
  }

  .card-body {
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .btn-success {
    background-color: #28a745;
    border-color: #28a745;
    font-weight: 500;
    padding: 8px 12px;
    font-size: 0.875rem;
  }

  .btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
    transform: translateY(-1px);
  }

  .meja-icon {
    opacity: 0.8;
  }

  .menu-item.hidden {
    display: none;
  }

  .card-img-top {
    border-radius: 12px 12px 0 0;
  }

  .text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .add-to-cart {
    margin-top: auto !important;
    opacity: 1 !important;
    visibility: visible !important;
  }

  /* Padding untuk menghindari konten tertutup fixed bottom */
  .tab-pane {
    padding-bottom: 100px !important;
  }

  .fixed-bottom {
    box-shadow: 0 -2px 20px rgba(0,0,0,0.1);
    border-top: 2px solid #e9ecef;
  }

  /* Smooth transition for tab content */
  .tab-content > .tab-pane {
    transition: opacity 0.3s ease-in-out;
  }

  /* Search bar styling */
  .input-group {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 8px;
  }

  .input-group-text {
    border-radius: 8px 0 0 8px !important;
  }

  .form-control {
    border-radius: 0 8px 8px 0 !important;
  }

  /* Small screen tweaks */
  @media (max-width: 575.98px) {
    .card-img-top { height: 150px !important; }
    .product-card { border-radius: 10px; }
    .card-body { padding: 12px !important; }
    .fw-bold.text-danger { font-size: 0.95rem; }
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Quick Add to Cart Modal
  const addToCartButtons = document.querySelectorAll('.add-to-cart');
  const quickCartModal = new bootstrap.Modal(document.getElementById('quickCartModal'));
  const quickCartForm = document.getElementById('quickCartForm');
  const quantityInput = document.getElementById('quantityInput');
  const stockInfo = document.getElementById('stockInfo');
  const availableStock = document.getElementById('availableStock');
  const modalSubtotal = document.getElementById('modalSubtotal');
  
  let currentProductPrice = 0;
  let currentProductId = 0;

  addToCartButtons.forEach(button => {
    button.addEventListener('click', function() {
      const productId = this.getAttribute('data-product-id');
      const productName = this.getAttribute('data-product-name');
      const productPrice = this.getAttribute('data-product-price');
      const productStock = this.getAttribute('data-product-stock');
      
      document.getElementById('modalProductId').value = productId;
      document.getElementById('modalProductName').value = productName;
      document.getElementById('modalProductPrice').value = 'Rp ' + parseInt(productPrice).toLocaleString('id-ID');
      
      currentProductPrice = parseInt(productPrice);
      currentProductId = productId;
      availableStock.textContent = productStock;
      
      // Set max quantity based on stock
      quantityInput.max = Math.min(10, productStock);
      quantityInput.value = 1;
      
      // Update subtotal
      updateSubtotal();
      
      quickCartModal.show();
    });
  });

  // Update subtotal when quantity changes
  quantityInput.addEventListener('input', updateSubtotal);

  function updateSubtotal() {
    const quantity = parseInt(quantityInput.value) || 0;
    const subtotal = quantity * currentProductPrice;
    modalSubtotal.value = 'Rp ' + subtotal.toLocaleString('id-ID');
  }

  // Handle form submission
  quickCartForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('{{ route("tambah.keranjang") }}', {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        quickCartModal.hide();
        
        // Show success message
        showAlert('success', data.message);
        
        // Update cart count display secara realtime
        updateCartDisplayRealtime(data.cartCount, data.totalHarga);
        
      } else {
        showAlert('danger', data.message || 'Terjadi kesalahan');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showAlert('danger', 'Terjadi kesalahan saat menambahkan ke keranjang');
    });
  });

  // Function untuk update display keranjang secara realtime
  function updateCartDisplayRealtime(cartCount, totalHarga) {
    // Update total harga
    const totalElement = document.querySelector('.fixed-bottom .fw-bold.text-success');
    if (totalElement) {
      totalElement.textContent = 'Rp ' + parseInt(totalHarga).toLocaleString('id-ID');
    }
    
    // Update item count dan text
    const itemCountElement = document.querySelector('.fixed-bottom .text-muted');
    if (itemCountElement) {
      if (cartCount > 0) {
        itemCountElement.innerHTML = `<i class="fas fa-check-circle text-success me-1"></i>${cartCount} item di keranjang`;
      } else {
        itemCountElement.innerHTML = `<i class="fas fa-shopping-cart text-muted me-1"></i>Keranjang kosong`;
      }
    }
  }

  // Filter functionality for Makanan
  const searchMakanan = document.getElementById('searchMakanan');
  const makananItems = document.querySelectorAll('.makanan-item');
  const noResultsMakanan = document.getElementById('noResultsMakanan');

  function filterMakananItems() {
    const searchTerm = searchMakanan.value.toLowerCase();
    
    let visibleCount = 0;

    makananItems.forEach(item => {
      const productName = item.getAttribute('data-name');
      
      const matchesSearch = productName.includes(searchTerm);
      
      if (matchesSearch) {
        item.style.display = 'block';
        visibleCount++;
      } else {
        item.style.display = 'none';
      }
    });

    // Show/hide no results message
    if (visibleCount === 0) {
      noResultsMakanan.style.display = 'block';
    } else {
      noResultsMakanan.style.display = 'none';
    }
  }

  searchMakanan.addEventListener('input', filterMakananItems);

  // Filter functionality for Minuman
  const searchMinuman = document.getElementById('searchMinuman');
  const minumanItems = document.querySelectorAll('.minuman-item');
  const noResultsMinuman = document.getElementById('noResultsMinuman');

  function filterMinumanItems() {
    const searchTerm = searchMinuman.value.toLowerCase();
    
    let visibleCount = 0;

    minumanItems.forEach(item => {
      const productName = item.getAttribute('data-name');
      
      const matchesSearch = productName.includes(searchTerm);
      
      if (matchesSearch) {
        item.style.display = 'block';
        visibleCount++;
      } else {
        item.style.display = 'none';
      }
    });

    // Show/hide no results message
    if (visibleCount === 0) {
      noResultsMinuman.style.display = 'block';
    } else {
      noResultsMinuman.style.display = 'none';
    }
  }

  searchMinuman.addEventListener('input', filterMinumanItems);

  // Utility functions
  function showAlert(type, message) {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert.position-fixed');
    existingAlerts.forEach(alert => alert.remove());

    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
    alertDiv.style.zIndex = '9999';
    alertDiv.innerHTML = `
      <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);

    setTimeout(() => {
      if (alertDiv.parentNode) {
        alertDiv.remove();
      }
    }, 4000);
  }

  // Remember active tab on page reload
  const mainTab = document.getElementById('mainTab');
  if (mainTab) {
    mainTab.addEventListener('shown.bs.tab', function (event) {
      const activeTab = event.target.getAttribute('id');
      localStorage.setItem('activeMainTab', activeTab);
    });

    // Set active tab from localStorage
    const activeTab = localStorage.getItem('activeMainTab');
    if (activeTab) {
      const tabElement = document.querySelector(`#${activeTab}`);
      if (tabElement) {
        new bootstrap.Tab(tabElement).show();
      }
    }
  }
});
</script>

@endsection
