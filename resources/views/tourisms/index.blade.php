@extends('layouts.app')

@section('title', 'Wisata')

@section('content')
<div class="container py-5">
  <h1 class="mb-4">Destinasi Wisata Tanjungpinang</h1>
  
  <div class="row mb-4">
    <div class="col-md-8">
      <form method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari wisata..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Cari</button>
      </form>
    </div>
  </div>

  <div class="row">
    @forelse($tourisms as $tourism)
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <img src="{{ $tourism->image ?? 'https://via.placeholder.com/300x200' }}" class="card-img-top" alt="{{ $tourism->name }}" style="height: 250px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">{{ $tourism->name }}</h5>
            <p class="card-text text-muted small">{{ Str::limit($tourism->short_description, 100) }}</p>
            <p class="card-text small"><i class="fas fa-map-marker-alt"></i> {{ $tourism->location }}</p>
            @if($tourism->ticket_price > 0)
              <p class="card-text"><small class="text-success">Tiket: Rp {{ number_format($tourism->ticket_price, 0, ',', '.') }}</small></p>
            @endif
            <a href="{{ route('tourisms.detail', $tourism->slug) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12"><p class="alert alert-info">Tidak ada wisata ditemukan</p></div>
    @endforelse
  </div>

  <div class="d-flex justify-content-center">
    {{ $tourisms->links() }}
  </div>
</div>
@endsection
