@extends('layouts.app')

@section('title', 'Review - ' . $product->name)

@section('content')
<div class="container py-5">
  <div class="row">
    <div class="col-md-8">
      <h2 class="mb-4">Review - {{ $product->name }}</h2>
      
      <div class="mb-4">
        <h5 class="mb-2">Rating Rata-rata</h5>
        <div class="d-flex align-items-center gap-3">
          <span class="display-6 text-success">{{ number_format($product->avgRating(), 1) }}</span>
          <div class="rating fs-5">
            @for($i = 1; $i <= 5; $i++)
              <i class="fas fa-star {{ $i <= $product->avgRating() ? 'text-warning' : 'text-secondary' }}"></i>
            @endfor
          </div>
          <span class="text-muted">dari {{ $product->reviewCount() }} review</span>
        </div>
      </div>

      @if($reviews->isEmpty())
        <div class="alert alert-info text-center py-4">
          <i class="fas fa-comment-dots" style="font-size: 2rem; color: #ccc; margin-bottom: 10px;"></i>
          <h5>Belum ada review</h5>
        </div>
      @else
        @foreach($reviews as $review)
          <div class="card mb-3">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <div>
                  <h6 class="mb-1">{{ $review->user->name }}</h6>
                  <div class="rating small">
                    @for($i = 1; $i <= 5; $i++)
                      <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}"></i>
                    @endfor
                  </div>
                </div>
                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
              </div>
              @if($review->comment)
                <p class="card-text mt-2">{{ $review->comment }}</p>
              @endif
            </div>
          </div>
        @endforeach
        
        <div class="d-flex justify-content-center mt-4">
          {{ $reviews->links() }}
        </div>
      @endif
    </div>

    <div class="col-md-4">
      <div class="card sticky-top" style="top: 80px;">
        <div class="card-body">
          <h5 class="card-title">Produk</h5>
          <p>{{ $product->name }}</p>
          <p class="text-success fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
          <p class="text-muted">UMKM: {{ $product->umkm->name }}</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
