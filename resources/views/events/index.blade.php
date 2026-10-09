@extends('layouts.app')

@section('title', 'Event & Budaya')

@section('content')
<div class="container py-5">
  <h1 class="mb-4">Event & Budaya Tanjungpinang</h1>
  
  <div class="row mb-4">
    <div class="col-md-8">
      <form method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari event..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Cari</button>
      </form>
    </div>
    <div class="col-md-4">
      <select name="status" class="form-select" onchange="location=this.value">
        <option value="">Semua Status</option>
        <option value="?status=upcoming">Akan Datang</option>
        <option value="?status=ongoing">Sedang Berlangsung</option>
      </select>
    </div>
  </div>

  <div class="row">
    @forelse($events as $event)
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <img src="{{ $event->image ?? 'https://via.placeholder.com/300x200' }}" class="card-img-top" alt="{{ $event->name }}" style="height: 250px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title">{{ $event->name }}</h5>
            <p class="card-text text-muted small">{{ Str::limit($event->description, 100) }}</p>
            <p class="card-text small">
              <i class="fas fa-calendar"></i> {{ $event->start_date->format('d M Y') }}<br>
              <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
            </p>
            <a href="{{ route('events.detail', $event->slug) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12"><p class="alert alert-info">Tidak ada event ditemukan</p></div>
    @endforelse
  </div>

  <div class="d-flex justify-content-center">
    {{ $events->links() }}
  </div>
</div>
@endsection
