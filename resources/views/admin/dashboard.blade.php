@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3>150</h3>
        <p>Pesanan Baru</p>
      </div>
      <div class="icon">
        <i class="fas fa-shopping-cart"></i>
      </div>
      <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3>53</h3>
        <p>Produk</p>
      </div>
      <div class="icon">
        <i class="fas fa-box"></i>
      </div>
      <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>
@endsection
