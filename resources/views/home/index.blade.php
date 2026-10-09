@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="hero">
  <div class="container">
    <h1>Platform Digital Budaya Tanjungpinang</h1>
    <p>Media Informasi, Promosi, dan Penghubung Transaksi Produk Budaya dan UMKM Lokal</p>
    <a href="{{ route('cultures') }}" class="btn btn-light btn-lg me-2"><i class="fas fa-tree"></i> Jelajahi Budaya</a>
    <a href="{{ route('marketplace') }}" class="btn btn-warning btn-lg"><i class="fas fa-shopping-cart"></i> Jelajahi Marketplace</a>
  </div>
</div>

<div class="container py-5">
  <h2 class="section-title text-center">Budaya Tanjungpinang</h2>
  <div class="row">
    @foreach($featured_cultures as $culture)
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="{{ $culture->image ?? 'https://via.placeholder.com/300x200' }}" class="card-img-top" alt="{{ $culture->name }}">
          <div class="card-body">
            <h5 class="card-title">{{ $culture->name }}</h5>
            <p class="card-text text-muted small">{{ Str::limit($culture->short_description, 100) }}</p>
            <a href="{{ route('cultures.detail', $culture->slug) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="text-center"><a href="{{ route('cultures') }}" class="btn btn-primary">Lihat Semua Budaya</a></div>
</div>

<div class="container py-5">
  <h2 class="section-title text-center">Destinasi Wisata</h2>
  <div class="row">
    @foreach($featured_tourisms as $tourism)
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="{{ $tourism->image ?? 'https://via.placeholder.com/300x200' }}" class="card-img-top" alt="{{ $tourism->name }}">
          <div class="card-body">
            <h5 class="card-title">{{ $tourism->name }}</h5>
            <p class="card-text text-muted small"><i class="fas fa-map-marker-alt"></i> {{ $tourism->location }}</p>
            <a href="{{ route('tourisms.detail', $tourism->slug) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="text-center"><a href="{{ route('tourisms') }}" class="btn btn-primary">Lihat Semua Wisata</a></div>
</div>

<div class="container py-5">
  <h2 class="section-title text-center">Event & Budaya</h2>
  <div class="row">
    @foreach($featured_events as $event)
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="{{ $event->image ?? 'https://via.placeholder.com/300x200' }}" class="card-img-top" alt="{{ $event->name }}">
          <div class="card-body">
            <h5 class="card-title">{{ $event->name }}</h5>
            <p class="card-text text-muted small"><i class="fas fa-calendar"></i> {{ $event->start_date->format('d M Y') }}</p>
            <a href="{{ route('events.detail', $event->slug) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="text-center"><a href="{{ route('events') }}" class="btn btn-primary">Lihat Semua Event</a></div>
</div>

<div class="container py-5">
  <h2 class="section-title text-center">Produk UMKM Unggulan</h2>
  <div class="row">
    @foreach($featured_products as $product)
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="{{ $product->image ?? 'https://via.placeholder.com/300x200' }}" class="card-img-top" alt="{{ $product->name }}">
          <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text text-success fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <div class="rating mb-2">
              <i class="fas fa-star"></i> {{ number_format($product->avgRating(), 1) }} ({{ $product->reviewCount() }} review)
            </div>
            <a href="{{ route('products.detail', $product->slug) }}" class="btn btn-sm btn-primary">Lihat Detail</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <div class="text-center"><a href="{{ route('marketplace') }}" class="btn btn-primary">Lihat Semua Produk</a></div>
</div>

<div class="container py-5">
  <h2 class="section-title text-center">UMKM Lokal</h2>
  <div class="row">
    @foreach($umkms as $umkm)
      <div class="col-md-6 mb-4">
        <div class="card">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="{{ $umkm->logo ?? 'https://via.placeholder.com/150x150' }}" class="img-fluid" alt="{{ $umkm->name }}" style="object-fit: cover; height: 150px;">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">{{ $umkm->name }}</h5>
                <p class="card-text text-muted small">{{ Str::limit($umkm->description, 80) }}</p>
                <p class="card-text small"><i class="fas fa-map-marker-alt"></i> {{ $umkm->address }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<div class="bg-light py-5">
  <div class="container">
    <h2 class="section-title text-center">Peta Lokasi</h2>
    <p class="text-center text-muted mb-4">Jelajahi lokasi wisata, budaya, dan UMKM di Tanjungpinang</p>
    <a href="{{ route('map') }}" class="btn btn-primary d-block mx-auto" style="width: fit-content;">Buka Peta Interaktif</a>
  </div>
</div>
@endsection
