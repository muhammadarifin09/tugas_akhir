@extends('layouts.pegawai')

@section('title', 'Dashboard Pegawai')

@section('content')
<div class="container-fluid">

    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-section">
                <h1 class="display-6 fw-bold text-dark mb-2">Dashboard Pegawai</h1>
                <p class="text-muted mb-0">Selamat datang di sistem manajemen restoran Juragan 96</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-5">
        <!-- Data Meja Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-modern border-0 h-100">
                <div class="card-body stat-card">
                    <div class="stat-icon primary">
                        <i class="fas fa-chair"></i>
                    </div>
                    <div class="stat-number text-primary">{{ $jumlahMeja ?? 0 }}</div>
                    <div class="stat-label">Data Meja</div>
                    <div class="mt-3">
                        <a href="{{ route('pegawai.meja.index') }}" class="btn btn-sm btn-outline-primary">
                            Kelola Meja <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pesanan Aktif Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-modern border-0 h-100">
                <div class="card-body stat-card">
                    <div class="stat-icon success">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="stat-number text-success">{{ $jumlahPesanan ?? 0 }}</div>
                    <div class="stat-label">Pesanan Aktif</div>
                    <div class="mt-3">
                        <a href="{{ route('pegawai.pesanan.index') }}" class="btn btn-sm btn-outline-success">
                            Lihat Pesanan <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meja Digunakan Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-modern border-0 h-100">
                <div class="card-body stat-card">
                    <div class="stat-icon warning">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number text-warning">{{ $mejaDigunakan ?? 0 }}</div>
                    <div class="stat-label">Meja Digunakan</div>
                    <div class="mt-3">
                        <a href="{{ route('pegawai.meja.index') }}" class="btn btn-sm btn-outline-warning">
                            Status Meja <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-modern border-0 h-100">
                <div class="card-body stat-card">
                    <div class="stat-icon danger">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <div class="stat-number text-danger">Keluar</div>
                    <div class="stat-label">Logout Akun</div>
                    <div class="mt-3">
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                           class="btn btn-sm btn-outline-danger">
                            Logout <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Additional Info Section -->
    <div class="row g-4">
        <!-- Recent Orders -->
        <div class="col-xl-8">
            <div class="card card-modern border-0 h-100">
                <div class="card-header-modern">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Pesanan Terbaru</h5>
                </div>
                <div class="card-body">
                    @if(isset($recentOrders) && $recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Pesanan</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td class="fw-semibold">#{{ $order->id_pesanan }}</td>
                                    <td>{{ $order->customer_name ?? 'Guest' }}</td>
                                    <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($order->status == 'selesai') bg-success
                                            @elseif($order->status == 'proses') bg-primary
                                            @elseif($order->status == 'pending') bg-warning
                                            @else bg-secondary @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">{{ $order->created_at->diffForHumans() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada pesanan terbaru</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-xl-4">
            <div class="card card-modern border-0 h-100">
                <div class="card-header-modern">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Statistik Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded-3">
                                <div class="text-primary mb-2">
                                    <i class="fas fa-utensils fa-2x"></i>
                                </div>
                                <div class="fw-bold fs-5">{{ $totalMenu ?? 0 }}</div>
                                <small class="text-muted">Total Menu</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded-3">
                                <div class="text-success mb-2">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div class="fw-bold fs-5">{{ $pesananSelesai ?? 0 }}</div>
                                <small class="text-muted">Pesanan Selesai</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded-3">
                                <div class="text-warning mb-2">
                                    <i class="fas fa-clock fa-2x"></i>
                                </div>
                                <div class="fw-bold fs-5">{{ $pesananPending ?? 0 }}</div>
                                <small class="text-muted">Menunggu</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded-3">
                                <div class="text-info mb-2">
                                    <i class="fas fa-money-bill-wave fa-2x"></i>
                                </div>
                                <div class="fw-bold fs-5">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</div>
                                <small class="text-muted">Pendapatan Hari Ini</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Features Row -->
    <div class="row g-4 mt-2">
        <!-- Quick Actions -->
        <!-- <div class="col-12">
            <div class="card card-modern border-0">
                <div class="card-header-modern">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <a href="{{ route('pegawai.pesanan.create') }}" class="btn btn-outline-primary w-100 h-100 py-3">
                                <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                <div class="fw-semibold">Buat Pesanan</div>
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('pegawai.produk.index') }}" class="btn btn-outline-success w-100 h-100 py-3">
                                <i class="fas fa-utensils fa-2x mb-2"></i>
                                <div class="fw-semibold">Kelola Menu</div>
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('pegawai.produk.index') }}" class="btn btn-outline-info w-100 h-100 py-3">
                                <i class="fas fa-chart-bar fa-2x mb-2"></i>
                                <div class="fw-semibold">Lihat Laporan</div>
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('pegawai.meja.index') }}" class="btn btn-outline-warning w-100 h-100 py-3">
                                <i class="fas fa-chair fa-2x mb-2"></i>
                                <div class="fw-semibold">Atur Meja</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>

</div>

<style>
    .welcome-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2rem;
        border-radius: 16px;
        color: white;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .welcome-section h1 {
        color: white !important;
    }

    .welcome-section .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
    }

    .stat-card {
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, var(--primary), #6941ee);
    }

    .stat-card.success::before { background: linear-gradient(135deg, var(--success), #20c997); }
    .stat-card.warning::before { background: linear-gradient(135deg, var(--warning), #fd7e14); }
    .stat-card.danger::before { background: linear-gradient(135deg, var(--danger), #e83e8c); }

    .table-hover tbody tr:hover {
        background-color: rgba(67, 97, 238, 0.05);
        transform: translateX(5px);
        transition: all 0.3s ease;
    }

    .btn-outline-primary, .btn-outline-success, .btn-outline-warning, .btn-outline-danger, .btn-outline-info {
        border-width: 2px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover { transform: translateY(-2px); }
    .btn-outline-success:hover { transform: translateY(-2px); }
    .btn-outline-warning:hover { transform: translateY(-2px); }
    .btn-outline-danger:hover { transform: translateY(-2px); }
    .btn-outline-info:hover { transform: translateY(-2px); }
</style>
@endsection