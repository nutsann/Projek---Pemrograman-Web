@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">
  <div class="row">
    <div class="col-md-6">
      <img src="{{ $product->image ?? 'https://via.placeholder.com/500x500' }}" class="img-fluid rounded mb-4" alt="{{ $product->name }}" style="height: 500px; object-fit: cover;">
    </div>
    <div class="col-md-6">
      <h1 class="mb-3">{{ $product->name }}</h1>
      <p class="text-muted mb-3">UMKM: {{ $product->umkm->name }}</p>
      <p class="text-success fw-bold" style="font-size: 1.5rem;">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
      
      <div class="rating mb-3">
        <i class="fas fa-star"></i> {{ number_format($product->avgRating(), 1) }} dari 5 ({{ $product->reviewCount() }} review)
      </div>

      <p class="mb-3"><strong>Stok:</strong> {{ $product->stock > 0 ? $product->stock . ' produk' : 'Habis' }}</p>

      <h3 class="mt-4">Deskripsi</h3>
      <p>{{ $product->description }}</p>

      @auth
        @if($product->stock > 0)
          <form method="POST" action="{{ route('cart.add', $product->id) }}" class="mt-4">
            @csrf
            <div class="input-group mb-3" style="width: 150px;">
              <button class="btn btn-outline-secondary" type="button" onclick="this.parentElement.querySelector('input').stepDown()">-</button>
              <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control text-center">
              <button class="btn btn-outline-secondary" type="button" onclick="this.parentElement.querySelector('input').stepUp()">+</button>
            </div>
            <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-shopping-cart"></i> Tambah ke Keranjang</button>
          </form>
        @else
          <button class="btn btn-secondary btn-lg" disabled>Produk Habis</button>
        @endif
      @else
        <p class="alert alert-info">Silakan <a href="{{ route('login') }}">login</a> untuk membeli produk ini</p>
      @endauth

      <h3 class="mt-5">Review Produk</h3>
      <div class="mb-3">
        <a href="{{ route('reviews.index', $product->id) }}" class="btn btn-sm btn-outline-primary">Lihat Semua Review ({{ $product->reviewCount() }})</a>
      </div>
      @if($product->reviews->count() > 0)
        @foreach($product->reviews->take(3) as $review)
          <div class="card mb-3">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <strong>{{ $review->user->name }}</strong>
                <span class="text-warning"><i class="fas fa-star"></i> {{ $review->rating }}</span>
              </div>
              <p class="card-text">{{ $review->comment }}</p>
              <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
            </div>
          </div>
        @endforeach
      @else
        <p class="text-muted">Belum ada review untuk produk ini</p>
      @endif
    </div>
  </div>
</div>
@endsection
