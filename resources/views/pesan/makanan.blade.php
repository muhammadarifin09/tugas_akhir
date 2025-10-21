@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Form Pesan Makanan</h2>
    <form action="{{ route('pesan.makanan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="mb-3">
            <label for="menu" class="form-label">Menu</label>
            <input type="text" class="form-control" id="menu" name="menu" required>
        </div>
        <button type="submit" class="btn btn-primary">Pesan</button>
    </form>
</div>
@endsection
