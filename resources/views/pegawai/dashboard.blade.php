@extends('layouts.pegawai')

@section('content')
<div class="container-fluid">
    <!-- Judul -->
    <h1 class="mb-4">Dashboard Pegawai</h1>

    <div class="row">
        <!-- Card Data Meja -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $jumlahMeja ?? 0 }}</h3>
                    <p>Data Meja</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chair"></i>
                </div>
                <a href="{{ route('pegawai.meja.index') }}" class="small-box-footer">
                    Lihat <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Card Pesanan -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $jumlahPesanan ?? 0 }}</h3>
                    <p>Pesanan Aktif</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Lihat <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Card Status Meja -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $mejaDigunakan ?? 0 }}</h3>
                    <p>Meja Digunakan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('pegawai.meja.index') }}" class="small-box-footer">
                    Lihat <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Card Logout -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>Keluar</h3>
                    <p>Logout Akun</p>
                </div>
                <div class="icon">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                   class="small-box-footer">
                    Logout <i class="fas fa-arrow-circle-right"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
