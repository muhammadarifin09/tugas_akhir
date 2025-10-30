@extends('layouts.main')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="container py-5 mt-4">
  <!-- Header Section -->
  <div class="text-center mb-5">
    <h1 class="fw-bold gradient-text mb-3">📋 Riwayat Pesanan Saya</h1>
    <p class="text-muted fs-5">Lihat semua pesanan yang pernah Anda buat di Juragan 96</p>
  </div>

  @if ($pesanan->isEmpty())
    <!-- Empty State -->
    <div class="empty-state text-center py-5">
      <div class="empty-icon mb-4">
        <i class="fas fa-receipt fa-4x text-muted"></i>
      </div>
      <h4 class="text-muted mb-3">Belum Ada Pesanan</h4>
      <p class="text-muted mb-4">Anda belum melakukan pemesanan apapun. Yuk pesan makanan favorit Anda!</p>
      <a href="{{ route('pesan') }}" class="btn btn-warning-modern">
        <i class="fas fa-utensils me-2"></i>
        Pesan Sekarang
      </a>
    </div>
  @else
    <!-- Pesanan Cards -->
    <div class="row g-4">
      @foreach ($pesanan as $index => $p)
        <div class="col-12">
          <div class="card pesanan-card shadow-sm border-0">
            <div class="card-header pesanan-header">
              <div class="row align-items-center">
                <div class="col-md-6">
                  <div class="d-flex align-items-center">
                    <div class="pesanan-badge me-3">
                      <i class="fas fa-receipt"></i>
                    </div>
                    <div>
                      <h5 class="mb-1">Pesanan #{{ ($pesanan->currentPage() - 1) * $pesanan->perPage() + $index + 1 }}</h5>
                      <small class="text-muted">
                        <i class="fas fa-clock me-1"></i>
                        {{ $p->created_at->format('d M Y, H:i') }}
                      </small>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 text-md-end">
                  <div class="status-badge">
                    @switch($p->status)
                      @case('pending')
                        <span class="badge status-pending">
                          <i class="fas fa-clock me-1"></i>
                          Menunggu Konfirmasi
                        </span>
                        @break
                      @case('proses')
                        <span class="badge status-proses">
                          <i class="fas fa-spinner me-1"></i>
                          Sedang Diproses
                        </span>
                        @break
                      @case('selesai')
                        <span class="badge status-selesai">
                          <i class="fas fa-check-circle me-1"></i>
                          Selesai
                        </span>
                        @break
                      @case('batal')
                        <span class="badge status-batal">
                          <i class="fas fa-times-circle me-1"></i>
                          Dibatalkan
                        </span>
                        @break
                      @default
                        <span class="badge status-default">
                          <i class="fas fa-question-circle me-1"></i>
                          Tidak Diketahui
                        </span>
                    @endswitch
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body">
              <!-- Detail Items -->
              <div class="table-responsive">
                <table class="table table-borderless mb-0">
                  <thead>
                    <tr>
                      <th class="text-start">Menu</th>
                      <th class="text-center">Jumlah</th>
                      <th class="text-end">Harga Satuan</th>
                      <th class="text-end">Subtotal</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($p->detailPesanan as $detail)
                      <tr class="detail-item">
                        <td class="text-start">
                          <div class="d-flex align-items-center">
                            <div class="menu-icon me-3">
                              <i class="fas fa-utensil-spoon text-warning"></i>
                            </div>
                            <div>
                              <h6 class="mb-0">{{ $detail->produk->nama_produk ?? 'Menu Tidak Tersedia' }}</h6>
                              @if($detail->produk)
                                
                              @endif
                            </div>
                          </div>
                        </td>
                        <td class="text-center">
                          <span class="quantity-badge">{{ $detail->jumlah }}</span>
                        </td>
                        <td class="text-end">
                          <span class="price-text">Rp {{ number_format($detail->produk->harga ?? 0, 0, ',', '.') }}</span>
                        </td>
                        <td class="text-end">
                          <strong class="subtotal-text">
                            Rp {{ number_format(($detail->produk->harga ?? 0) * $detail->jumlah, 0, ',', '.') }}
                          </strong>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <!-- Footer dengan Total -->
              <div class="pesanan-footer mt-4 pt-3 border-top">
                <div class="row align-items-center">
                  <div class="col-md-6">
                    <small class="text-muted">
                      <i class="fas fa-info-circle me-1"></i>
                      Tipe: {{ $p->tipe_pesanan == 'makan_ditempat' ? 'Makan di Tempat' : 'Dibawa Pulang' }}
                      @if($p->meja && $p->tipe_pesanan == 'makan_ditempat')
                        • Meja {{ $p->meja->nomor_meja }}
                      @endif
                    </small>
                  </div>
                  <div class="col-md-6 text-md-end">
                    <div class="total-section">
                      <span class="total-label">Total Pembayaran:</span>
                      <h4 class="total-amount mb-0">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
      <nav aria-label="Page navigation">
        {{ $pesanan->links('pagination::bootstrap-5') }}
      </nav>
    </div>
  @endif
</div>

<style>
  :root {
    --primary: #ffd700;
    --primary-dark: #b39700;
    --secondary: #000000;
    --dark: #1a1a1a;
    --light: #f8f9fa;
  }

  .gradient-text {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .empty-state {
    background: #f8f9fa;
    border-radius: 20px;
    padding: 4rem 2rem !important;
  }

  .empty-icon {
    opacity: 0.5;
  }

  .pesanan-card {
    border-radius: 15px;
    transition: all 0.3s ease;
    overflow: hidden;
  }

  .pesanan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
  }

  .pesanan-header {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-bottom: 2px solid var(--primary);
    padding: 1.5rem;
  }

  .pesanan-badge {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
  }

  /* Status Badges */
  .badge {
    padding: 0.6rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.85rem;
  }

  .status-pending {
    background: linear-gradient(135deg, #fff3cd, #ffc107);
    color: #856404;
    border: 1px solid #ffeaa7;
  }

  .status-proses {
    background: linear-gradient(135deg, #cce7ff, #007bff);
    color: #004085;
    border: 1px solid #b3d7ff;
  }

  .status-selesai {
    background: linear-gradient(135deg, #d4edda, #28a745);
    color: #155724;
    border: 1px solid #c3e6cb;
  }

  .status-batal {
    background: linear-gradient(135deg, #f8d7da, #dc3545);
    color: #721c24;
    border: 1px solid #f5c6cb;
  }

  .status-default {
    background: linear-gradient(135deg, #e2e3e5, #6c757d);
    color: #383d41;
    border: 1px solid #d6d8db;
  }

  /* Detail Items Styling */
  .detail-item {
    border-bottom: 1px solid #f8f9fa;
    transition: background-color 0.2s ease;
  }

  .detail-item:hover {
    background-color: #f8f9fa;
  }

  .detail-item:last-child {
    border-bottom: none;
  }

  .menu-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 215, 0, 0.1);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .quantity-badge {
    background: var(--primary);
    color: var(--secondary);
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
  }

  .price-text {
    color: #6c757d;
    font-weight: 500;
  }

  .subtotal-text {
    color: var(--dark);
    font-size: 1rem;
  }

  .pesanan-footer {
    background: #f8f9fa;
    margin: -1.5rem;
    margin-top: 1.5rem;
    padding: 1.5rem;
  }

  .total-section {
    text-align: right;
  }

  .total-label {
    color: #6c757d;
    font-size: 0.9rem;
    display: block;
    margin-bottom: 0.5rem;
  }

  .total-amount {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
  }

  .btn-warning-modern {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border: none;
    border-radius: 10px;
    color: var(--secondary);
    font-weight: 600;
    padding: 0.75rem 2rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
  }

  .btn-warning-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.5);
    color: var(--secondary);
  }

  /* Pagination Styling */
  .pagination .page-link {
    border: none;
    color: var(--dark);
    border-radius: 8px;
    margin: 0 0.2rem;
    transition: all 0.3s ease;
  }

  .pagination .page-item.active .page-link {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-color: var(--primary);
    color: var(--secondary);
    font-weight: 600;
  }

  .pagination .page-link:hover {
    background: rgba(255, 215, 0, 0.1);
    color: var(--dark);
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .container.py-5 {
      padding-top: 2rem !important;
      padding-bottom: 2rem !important;
    }

    .pesanan-header .row > div {
      text-align: left !important;
      margin-bottom: 1rem;
    }

    .pesanan-header .row > div:last-child {
      margin-bottom: 0;
    }

    .total-section {
      text-align: left !important;
      margin-top: 1rem;
    }

    .table-responsive {
      font-size: 0.9rem;
    }

    .detail-item td {
      padding: 0.75rem 0.5rem;
    }

    .menu-icon {
      width: 35px;
      height: 35px;
      font-size: 0.9rem;
    }

    .quantity-badge {
      padding: 0.2rem 0.6rem;
      font-size: 0.8rem;
    }

    .badge {
      padding: 0.5rem 0.8rem;
      font-size: 0.8rem;
    }
  }

  @media (max-width: 576px) {
    .pesanan-card .card-body {
      padding: 1rem;
    }

    .table thead {
      display: none;
    }

    .table tbody tr {
      display: block;
      margin-bottom: 1rem;
      border: 1px solid #dee2e6;
      border-radius: 10px;
      padding: 1rem;
    }

    .table tbody td {
      display: flex;
      justify-content: space-between;
      align-items: center;
      border: none;
      padding: 0.5rem 0;
    }

    .table tbody td::before {
      content: attr(data-label);
      font-weight: 600;
      color: var(--dark);
      margin-right: 1rem;
    }

    .table tbody td[data-label] {
      text-align: right !important;
    }

    /* Add data labels for mobile */
    .table tbody td:nth-child(1) { data-label: "Menu"; }
    .table tbody td:nth-child(2) { data-label: "Jumlah"; }
    .table tbody td:nth-child(3) { data-label: "Harga Satuan"; }
    .table tbody td:nth-child(4) { data-label: "Subtotal"; }
  }
</style>

<script>
  // Add data labels for mobile responsive table
  document.addEventListener('DOMContentLoaded', function() {
    if (window.innerWidth <= 576) {
      const tableCells = document.querySelectorAll('.detail-item td');
      const labels = ['Menu', 'Jumlah', 'Harga Satuan', 'Subtotal'];
      
      tableCells.forEach((cell, index) => {
        cell.setAttribute('data-label', labels[index % 4]);
      });
    }
  });

  // Re-run on window resize
  window.addEventListener('resize', function() {
    if (window.innerWidth <= 576) {
      const tableCells = document.querySelectorAll('.detail-item td');
      const labels = ['Menu', 'Jumlah', 'Harga Satuan', 'Subtotal'];
      
      tableCells.forEach((cell, index) => {
        cell.setAttribute('data-label', labels[index % 4]);
      });
    } else {
      // Remove data labels on larger screens
      document.querySelectorAll('.detail-item td[data-label]').forEach(cell => {
        cell.removeAttribute('data-label');
      });
    }
  });
</script>
@endsection