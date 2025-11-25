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