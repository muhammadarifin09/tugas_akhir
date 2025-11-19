@extends('layouts.main')

@section('content')

<div class="container py-4">
    <h3 class="mb-3 fw-bold">Profil Pelanggan</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <p><strong>Nama:</strong> {{ $user->name }}</p>

            @if(!$profil || (!$profil->nomor_hp && !$profil->alamat))
                <p><em>Profil belum lengkap.</em></p>
            @else
                <p><strong>No HP:</strong> {{ $profil->nomor_hp ?? '-' }}</p>
                <p><strong>Alamat:</strong> {{ $profil->alamat ?? '-' }}</p>
            @endif

            <!-- Tombol Edit Profil dengan style modern -->
            <a href="{{ route('pelanggan.profil.edit') }}" class="btn btn-primary-modern mt-3">
                <i class="fas fa-edit me-2"></i>
                Edit Profil
            </a>

        </div>
    </div>

</div>

<style>
    /* Style untuk tombol Edit Profil */
    .btn-primary-modern {
        background: linear-gradient(135deg, var(--orange), var(--orange-dark)) !important;
        border: none !important;
        border-radius: 8px;
        padding: 0.6rem 1.5rem;
        font-weight: 600;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(255, 107, 0, 0.3) !important;
        color: white;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 107, 0, 0.5) !important;
        background: linear-gradient(135deg, var(--orange-dark), var(--orange)) !important;
        color: white;
        text-decoration: none !important;
    }

    /* Variabel warna untuk konsistensi */
    :root {
        --primary: #ffd700;
        --primary-dark: #b39700;
        --orange: #ff6b00;
        --orange-dark: #e55a00;
        --transition: all 0.3s ease;
    }

    /* Style untuk card profil */
    .card {
        border: none;
        border-radius: 12px;
    }

    .card-body {
        padding: 2rem;
    }

    .card-body p {
        font-size: 1.1rem;
        margin-bottom: 1rem;
        color: #333;
    }

    .card-body strong {
        color: #000;
    }
</style>

@endsection