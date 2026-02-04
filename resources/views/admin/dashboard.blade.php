@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">

    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-section">
                <h1 class="display-6 fw-bold mb-2">Dashboard Admin</h1>
                <p class="mb-0">Selamat datang di panel administrasi Juragan 96 Resto</p>
            </div>
        </div>
    </div>

    <!-- Statistik Utama -->
    <div class="row g-4 mb-5">
        <!-- Total Akun -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-modern border-0 h-100">
                <div class="card-body stat-card">
                    <div class="stat-icon primary">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number text-primary">{{ $totalAkun ?? 0 }}</div>
                    <div class="stat-label">Total Akun</div>
                    <div class="mt-3">
                        <a href="{{ route('akun.index') }}" class="btn btn-sm btn-outline-primary">
                            Kelola Akun <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Produk -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-modern border-0 h-100">
                <div class="card-body stat-card">
                    <div class="stat-icon success">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div class="stat-number text-success">{{ $totalProduk ?? 0 }}</div>
                    <div class="stat-label">Total Produk</div>
                    <div class="mt-3">
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-sm btn-outline-success">
                            Lihat Menu <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pesanan -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-modern border-0 h-100">
                <div class="card-body stat-card">
                    <div class="stat-icon warning">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-number text-warning">{{ $totalPesanan ?? 0 }}</div>
                    <div class="stat-label">Total Pesanan</div>
                    <div class="mt-3">
                        <a href="#" class="btn btn-sm btn-outline-warning">
                            Monitoring <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logout -->
         <div class="col-xl-3 col-md-6">
            <div class="card card-modern border-0 h-100">
                <div class="card-body stat-card">
                    <div class="stat-icon warning">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number text-warning">{{ $mejaDigunakan ?? 0 }}</div>
                    <div class="stat-label">Meja Digunakan</div>
                    <div class="mt-3">
                        <a href="{{ route('admin.meja.index') }}" class="btn btn-sm btn-outline-warning">
                            Status Meja <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monitoring & Info -->
    <div class="row g-4">
        <!-- Produk Terbaru -->
        <div class="col-xl-8">
            <div class="card card-modern border-0 h-100">
                <div class="card-header-modern">
                    <h5 class="mb-0"><i class="fas fa-box me-2"></i>Produk Terbaru</h5>
                </div>
                <div class="card-body">
                    @if(isset($produkTerbaru) && $produkTerbaru->count())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Jenis</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produkTerbaru as $produk)
                                        <tr>
                                            <td class="fw-semibold">{{ $produk->nama_produk }}</td>
                                            <td>{{ ucfirst($produk->jenis) }}</td>
                                            <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge {{ $produk->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $produk->stok > 0 ? 'Tersedia' : 'Habis' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-box-open fa-3x mb-3"></i>
                            <p>Belum ada data produk</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Ringkasan Cepat -->
        <div class="col-xl-4">
            <div class="card card-modern border-0 h-100">
                <div class="card-header-modern">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Ringkasan Sistem</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded-3">
                                <i class="fas fa-user-shield fa-2x text-primary mb-2"></i>
                                <div class="fw-bold fs-5">{{ $jumlahAdmin ?? 0 }}</div>
                                <small class="text-muted">Admin</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded-3">
                                <i class="fas fa-user fa-2x text-success mb-2"></i>
                                <div class="fw-bold fs-5">{{ $jumlahPegawai ?? 0 }}</div>
                                <small class="text-muted">Pegawai</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded-3">
                                <i class="fas fa-utensils fa-2x text-warning mb-2"></i>
                                <div class="fw-bold fs-5">{{ $menuHabis ?? 0 }}</div>
                                <small class="text-muted">Menu Habis</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded-3">
                                <i class="fas fa-database fa-2x text-info mb-2"></i>
                                <div class="fw-bold fs-5">{{ $totalPesanan ?? 0 }}</div>
                                <small class="text-muted">Total Data</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .welcome-section {
        background: linear-gradient(135deg, #667eea, #764ba2);
        padding: 2rem;
        border-radius: 16px;
        color: #fff;
        box-shadow: 0 10px 25px rgba(0,0,0,.1);
    }
</style>
@endsection
