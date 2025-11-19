@extends('layouts.main')

@section('content')

<div class="container py-4">
    <h3 class="fw-bold mb-3">Edit Profil</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('pelanggan.profil.update') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama (Tidak dapat diubah)</label>
                    <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                </div>

                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" name="nomor_hp"
                           class="form-control"
                           value="{{ $profil->nomor_hp }}">
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3">{{ $profil->alamat }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <a href="{{ route('pelanggan.profil.index') }}" class="btn btn-secondary">Kembali</a>
            </form>

        </div>
    </div>

</div>

@endsection
