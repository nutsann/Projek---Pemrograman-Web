@extends('layouts.app')

@section('title', 'Marketplace')

@section('content')
<div class="container py-5">
  <h1 class="mb-4">Marketplace UMKM</h1>
  
  <div class="row mb-4">
    <div class="col-md-6">
      <form method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari produk..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Cari</button>
      </form>
    </div>
    <div class="col-md-3">
      <form action="{{ route('marketplace') }}" method="GET" id="filterForm">
        @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
        <select name="category" class="form-select" onchange="this.form.submit()">
          <option value="">Semua Kategori</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
          @endforeach
        </select>
      </form>
    </div>
    <div class="col-md-3">
      <select name="sort" class="form-select" onchange="const url = new URL(window.location); url.searchParams.set('sort', this.value); window.location = url;">
        <option value="">Urutkan</option>
        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
      </select>
    </div>
  </div>

  <div class="row">
    @forelse($products as $product)
      <div class="col-md-3 mb-4">
        <div class="card h-100">
          <img src="{{ $product->image ?? 'https://via.placeholder.com/300x250' }}" class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text text-success fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <p class="card-text text-muted small">{{ $product->umkm->name }}</p>
            <div class="rating mb-2">
              <i class="fas fa-star"></i> {{ number_format($product->avgRating(), 1) }} ({{ $product->reviewCount() }})
            </div>
            <a href="{{ route('products.detail', $product->slug) }}" class="btn btn-primary btn-sm w-100">Lihat Detail</a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12"><p class="alert alert-info">Tidak ada produk ditemukan</p></div>
    @endforelse
  </div>

  <div class="d-flex justify-content-center">
    {{ $products->links() }}
  </div>
</div>
@endsection
