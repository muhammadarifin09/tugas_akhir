@extends('layouts.main')
@section('title', 'Pesanan Berhasil')

@section('content')
<div class="container py-5 mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-modern shadow-lg border-0 text-center">
                <div class="card-body py-5">
                    <!-- Success Icon -->
                    <div class="success-icon mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <!-- Success Message -->
                    <h1 class="fw-bold text-success mb-3">Pesanan Berhasil!</h1>
                    <p class="text-muted fs-5 mb-4">Terima kasih telah memesan di restoran kami</p>
                    
                    <!-- Order Details -->
                    <div class="order-summary bg-light rounded-3 p-4 mb-4 text-start">
                        <h5 class="fw-bold mb-3">Detail Pesanan</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>No. Pesanan:</strong> #{{ $pesanan->id_pesanan }}</p>
                                <p><strong>Nama:</strong> {{ $pesanan->nama_pelanggan }}</p>
                                <p><strong>No. WhatsApp:</strong> {{ $pesanan->no_wa }}</p>
                                <p><strong>Tipe Pesanan:</strong> 
                                    {{ $pesanan->tipe_pesanan == 'makan_ditempat' ? 'Makan di Tempat' : 'Dibawa Pulang' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Total:</strong> Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                                <p><strong>Metode Bayar:</strong> 
                                    {{ $pesanan->metode_pembayaran == 'cod' ? 'Bayar di Tempat' : 'Transfer Bank' }}
                                </p>
                                <p><strong>Status Pesanan:</strong> 
                                    @if($pesanan->status == 'menunggu_pembayaran')
                                        <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                                    @elseif($pesanan->status == 'proses')
                                        <span class="badge bg-info text-dark">Proses</span>
                                    @elseif($pesanan->status == 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($pesanan->status == 'batal')
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($pesanan->status) }}</span>
                                    @endif
                                </p>
                                @if($pesanan->meja)
                                    <p><strong>Meja:</strong> Meja {{ $pesanan->meja->nomor_meja }}</p>
                                @endif
                            </div>
                        </div>

                        @if($pesanan->metode_pembayaran == 'transfer')
                        <div class="mt-3 p-3 bg-warning bg-opacity-10 rounded">
                            <h6 class="fw-bold text-warning">
                                <i class="fas fa-info-circle me-2"></i>
                                Instruksi Pembayaran
                            </h6>
                            <p class="mb-2">Silakan transfer ke rekening berikut:</p>
                            <p class="mb-1"><strong>Bank:</strong> BCA</p>
                            <p class="mb-1"><strong>No. Rekening:</strong> 1234567890</p>
                            <p class="mb-1"><strong>Atas Nama:</strong> JURAGAN 96</p>
                            <p class="mb-0"><strong>Total:</strong> Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                            <p class="mb-0 mt-2 text-danger">
                                <small>
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Pesanan akan diproses setelah pembayaran dikonfirmasi
                                </small>
                            </p>
                        </div>
                        @endif
                    </div>

                    <!-- Order Items -->
                    <div class="order-items mb-4">
                        <h6 class="fw-bold mb-3">Item Pesanan</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Harga</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pesanan->detailPesanan as $item)
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
                                                    <small class="text-muted">{{ $item->produk->deskripsi ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->jumlah }}</td>
                                        <td class="text-end">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total:</td>
                                        <td class="text-end fw-bold text-success">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('menu-meja') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-plus me-2"></i>
                            Pesan Lagi
                        </a>
                        <a href="{{ route('pelanggan.pesanan') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-list me-2"></i>
                            Lihat Pesanan Saya
                        </a>
                        <a href="{{ route('keranjang') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-home me-2"></i>
                            Kembali ke Home
                        </a>
                    </div>

                    <!-- Additional Info -->
                    <div class="mt-4">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            @if($pesanan->metode_pembayaran == 'cod')
                                Pesanan Anda sedang diproses. Kami akan mengirimkan notifikasi via WhatsApp.
                            @else
                                Pesanan akan diproses setelah pembayaran dikonfirmasi.
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-modern {
        background: #fff;
        border-radius: 15px;
        border: none;
    }

    .success-icon {
        animation: bounce 1s ease-in-out;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-10px);
        }
        60% {
            transform: translateY(-5px);
        }
    }

    .order-summary {
        border-left: 4px solid #28a745;
    }

    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }
</style>
@endsection