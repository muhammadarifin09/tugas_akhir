@extends('admin.dashboard')

@section('title', 'Tambah Akun')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tambah Akun</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('akun.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="pegawai">Pegawai</option>
                    <option value="pengguna">Pengguna</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('akun.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
