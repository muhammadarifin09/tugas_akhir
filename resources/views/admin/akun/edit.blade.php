@extends('admin.dashboard')

@section('title', 'Edit Akun')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Akun</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('akun.update', $akun->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $akun->name) }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $akun->email) }}" required>
            </div>

            <div class="form-group">
                <label>Password (opsional)</label>
                <input type="password" name="password" class="form-control">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password (opsional)</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin" {{ $akun->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="pegawai" {{ $akun->role == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                    <option value="pengguna" {{ $akun->role == 'pengguna' ? 'selected' : '' }}>Pengguna</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('akun.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
