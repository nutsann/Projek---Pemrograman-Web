@extends('layouts.app')

@section('title', 'Buat Review')

@section('content')
<div class="container py-5">
  <h2 class="mb-4">Buat Review</h2>
  
  <form method="POST" action="{{ route('reviews.store', $order->id) }}">
    @csrf
    
    @foreach($order->items as $item)
      <div class="card mb-3">
        <div class="card-body">
          <div class="form-check mb-3">
            <input class="form-check-input" type="radio" name="product_id" value="{{ $item->product_id }}" id="product{{ $item->product_id }}" {{ $loop->first ? 'checked' : '' }}>
            <label class="form-check-label" for="product{{ $item->product_id }}">
              <h5 class="mb-1">{{ $item->product_name }}</h5>
              <small class="text-muted">UMKM: {{ $item->umkm->name }}</small>
            </label>
          </div>
          
          <div id="review-{{ $item->product_id }}" class="review-section">
            <div class="mb-3">
              <label class="form-label">Rating</label>
              <div class="d-flex gap-2">
                @for($i = 5; $i >= 1; $i--)
                  <label class="cursor-pointer">
                    <input type="radio" name="rating" value="{{ $i }}" {{ $i === 5 ? 'checked' : '' }} required> 
                    <i class="fas fa-star text-warning" style="font-size: 1.5rem;"></i>
                  </label>
                @endfor
              </div>
            </div>
            
            <div class="mb-3">
              <label class="form-label">Komentar</label>
              <textarea name="comment" class="form-control" rows="3" placeholder="Tulis ulasan produk..."></textarea>
            </div>
          </div>
        </div>
      </div>
    @endforeach
    
    <button type="submit" class="btn btn-primary">Kirim Review</button>
    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-secondary">Batal</a>
  </form>
</div>
@endsection
