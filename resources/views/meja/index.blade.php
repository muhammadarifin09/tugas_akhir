@extends('layouts.main')

@section('title', 'Daftar Meja - JURAGAN 96 RESTO')

@section('content')
<div class="container my-5">
  <h2 class="text-center text-dark mb-4 fw-bold">Daftar Ketersediaan Meja</h2>

  <div class="row justify-content-center">
    @foreach($meja as $item)
      <div class="col-md-3 mb-4">
        <div class="card text-center shadow-sm border-0" style="border-radius: 15px;">
          <div class="card-body">
            <h5 class="card-title fw-bold">Meja {{ $item->nomor_meja }}</h5>

            @if($item->status == 'tersedia')
              <span class="badge bg-success mb-2 text-capitalize">{{ $item->status }}</span>
            @elseif($item->status == 'dipesan')
              <span class="badge bg-warning text-dark mb-2 text-capitalize">{{ $item->status }}</span>
            @else
              <span class="badge bg-danger mb-2 text-capitalize">{{ $item->status }}</span>
            @endif

            <p class="text-muted mb-1">Waktu Tersedia:</p>
            <p class="fw-semibold">
              {{ \Carbon\Carbon::parse($item->waktu_tersedia)->format('d M Y, H:i') }}
            </p>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
