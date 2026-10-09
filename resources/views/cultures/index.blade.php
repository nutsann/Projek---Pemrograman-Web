@extends('layouts.app')

@section('title', 'Budaya')

@section('content')
<div class="container py-5">
  <h1 class="mb-4">Informasi Budaya Tanjungpinang</h1>
  
  <div class="row mb-4">
    <div class="col-md-8">
      <form method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari budaya..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Cari</button>
      </form>
    </div>
    <div class="col-md-4">
      <select name="sort" class="form-select" onchange="location=this.value">
        <option value="">Urutkan</option>
        <option value="?sort=newest">Terbaru</option>
        <option value="?sort=oldest">Tertua</option>
      </select>
    </div>
  </div>

  <div class="row">
    @forelse($cultures as $culture)
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <img src="{{ $culture->image ?? 'https://via.placeholder.com/300x200' }}" class="card-img-top" alt="{{ $culture->name }}" style="height: 250px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">{{ $culture->name }}</h5>
            <p class="card-text text-muted small">{{ Str::limit($culture->short_description, 100) }}</p>
            <p class="card-text small"><i class="fas fa-map-marker-alt"></i> {{ $culture->location }}</p>
            <a href="{{ route('cultures.detail', $culture->slug) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12"><p class="alert alert-info">Tidak ada budaya ditemukan</p></div>
    @endforelse
  </div>

  <div class="d-flex justify-content-center">
    {{ $cultures->links() }}
  </div>
</div>
@endsection
