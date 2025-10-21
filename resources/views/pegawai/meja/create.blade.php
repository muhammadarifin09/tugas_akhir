@extends('layouts.pegawai')

@section('content')
<div class="container">
    <h2>Tambah Meja</h2>
    <form action="{{ route('pegawai.meja.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Nomor Meja</label>
            <input type="text" name="nomor_meja" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="tersedia">Tersedia</option>
                <option value="dipesan">Dipesan</option>
                <option value="sedang digunakan">Sedang Digunakan</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Waktu Tersedia</label>
            <input type="datetime-local" name="waktu_tersedia" class="form-control">
        </div>
        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pegawai.meja.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
