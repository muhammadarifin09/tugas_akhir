@extends('layouts.main')
@section('title', 'Proses Checkout')

@section('content')
<div class="container py-5 mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <h1 class="fw-bold gradient-text mb-3">Proses Checkout</h1>
                <p class="text-muted fs-5">Konfirmasi pesanan Anda sebelum pembayaran</p>
            </div>

            @if($keranjang)
            <!-- Checkout Steps -->
            <div class="card card-modern shadow-lg border-0 mb-4">
                <div class="card-body">
                    <div class="steps">
                        <div class="step completed">
                            <div class="step-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <span class="step-text">Keranjang</span>
                        </div>
                        <div class="step active">
                            <div class="step-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <span class="step-text">Checkout</span>
                        </div>
                        <div class="step">
                            <div class="step-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="step-text">Selesai</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="card card-modern shadow-lg border-0 mb-4">
                <div class="card-header card-header-modern">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-receipt me-2"></i>
                        Ringkasan Pesanan
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Customer Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">Info Pelanggan</h6>
                            <div class="customer-info">
                                <p><strong>Nama:</strong> {{ $keranjang->nama_pelanggan ?? 'Belum diisi' }}</p>
                                <p><strong>No. WhatsApp:</strong> {{ $keranjang->no_wa ?? 'Belum diisi' }}</p>
                                <p><strong>Tipe Pesanan:</strong> 
                                    @if($keranjang->tipe_pesanan == 'makan_ditempat')
                                        Makan di Tempat
                                    @elseif($keranjang->tipe_pesanan == 'dibawa_pulang')
                                        Dibawa Pulang
                                    @else
                                        Belum dipilih
                                    @endif
                                </p>
                                
                                @if($keranjang->tipe_pesanan == 'makan_ditempat' && $keranjang->meja)
                                    <p><strong>Meja:</strong> Meja {{ $keranjang->meja->nomor_meja }}</p>
                                @elseif($keranjang->tipe_pesanan == 'dibawa_pulang' && $keranjang->alamat)
                                    <p><strong>Alamat:</strong> {{ $keranjang->alamat }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">Metode Pembayaran</h6>
                            <div class="payment-info">
                                @if($keranjang->metode_pembayaran == 'cod')
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-money-bill-wave text-success me-2 fa-2x"></i>
                                        <div>
                                            <h6 class="mb-1">Bayar di Tempat</h6>
                                            <small class="text-muted">Bayar saat pesanan diterima</small>
                                        </div>
                                    </div>
                                @elseif($keranjang->metode_pembayaran == 'transfer')
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-university text-primary me-2 fa-2x"></i>
                                        <div>
                                            <h6 class="mb-1">Transfer Bank</h6>
                                            <small class="text-muted">Bayar melalui transfer bank</small>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Belum dipilih
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <h6 class="fw-bold mb-3">Item Pesanan</h6>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-center">Harga</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach($keranjang->items as $item)
                                    @php
                                        $subtotal = $item->qty * $item->harga_saat_dipesan;
                                        $total += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/' . $item->produk->gambar) }}" 
                                                     alt="{{ $item->produk->nama_produk }}"
                                                     class="rounded me-3"
                                                     style="width: 50px; height: 50px; object-fit: cover;"
                                                     onerror="this.src='https://via.placeholder.com/50x50?text=No+Image'">
                                                <div>
                                                    <h6 class="mb-1">{{ $item->produk->nama_produk }}</h6>
                                                    <small class="text-muted">{{ $item->produk->deskripsi ?? 'Tidak ada deskripsi' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-semibold">{{ $item->qty }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-muted">Rp {{ number_format($item->harga_saat_dipesan, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="text-end">
                                            <span class="fw-bold text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Total:</td>
                                    <td class="text-end">
                                        <h5 class="fw-bold text-success mb-0">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

          <!-- Payment Action Section -->
        <!-- Payment Action Section -->
<div class="card card-modern shadow-lg border-0">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h6 class="fw-bold mb-2">Konfirmasi Pesanan</h6>
                <p class="text-muted mb-0">
                    @if($keranjang->metode_pembayaran == 'cod')
                        Pesanan Anda akan diproses setelah konfirmasi. Silakan bayar saat pesanan diterima.
                    @else
                        Pesanan Anda akan diproses setelah pembayaran dikonfirmasi.
                    @endif
                </p>
            </div>
            <div class="col-md-4 text-end">
                <form action="{{ route('checkout.process', $keranjang->id_keranjang) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-lg fw-bold mb-3 text-white" 
                            style="padding: 12px 25px; border-radius: 12px; font-size: 1.1rem; width: 100%; max-width: 280px;">
                        <i class="fas fa-check-circle me-2"></i>
                        Konfirmasi Pesanan
                    </button>
                </form>
                <a href="{{ route('keranjang') }}" class="btn btn-outline-secondary mt-2" style="width: 100%; max-width: 280px;">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali ke Keranjang
                </a>
            </div>
        </div>
    </div>
</div>
            
            @else
            <div class="card card-modern shadow-lg border-0 text-center py-5">
                <div class="card-body">
                    <i class="fas fa-exclamation-triangle fa-4x text-warning mb-4"></i>
                    <h3 class="text-warning mb-3">Data Keranjang Tidak Ditemukan</h3>
                    <p class="text-muted mb-4">Silakan kembali ke keranjang dan lengkapi data pesanan Anda</p>
                    <a href="{{ route('keranjang') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali ke Keranjang
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
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

    .steps {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }

    .steps::before {
        content: '';
        position: absolute;
        top: 25px;
        left: 0;
        right: 0;
        height: 3px;
        background: #e9ecef;
        z-index: 1;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .step-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
        background: #e9ecef;
        color: #6c757d;
    }

    .step.completed .step-icon {
        background: #28a745;
        color: white;
    }

    .step.active .step-icon {
        background: #007bff;
        color: white;
    }

    .step-text {
        font-size: 0.875rem;
        font-weight: 500;
        color: #6c757d;
    }

    .step.completed .step-text,
    .step.active .step-text {
        color: #28a745;
        font-weight: 600;
    }

    .customer-info p {
        margin-bottom: 0.5rem;
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        border-radius: 12px;
        font-weight: 600;
        padding: 0.75rem 2rem;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #218838, #1ba87e);
        transform: translateY(-2px);
    }
</style>
@endsection