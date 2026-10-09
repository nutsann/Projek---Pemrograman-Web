@extends('layouts.app')

@section('title', $tourism->name)

@section('content')
<div class="container py-5">
  <div class="row">
    <div class="col-md-8">
      <img src="{{ $tourism->image ?? 'https://via.placeholder.com/800x500' }}" class="img-fluid rounded mb-4" alt="{{ $tourism->name }}" style="height: 500px; object-fit: cover;">
      <h1 class="mb-3">{{ $tourism->name }}</h1>
      <p class="text-muted mb-4"><i class="fas fa-map-marker-alt"></i> {{ $tourism->location }}</p>
      
      <h3 class="mt-5">Deskripsi</h3>
      <p>{{ $tourism->description }}</p>

      @if($tourism->gallery)
        <h3 class="mt-5">Galeri</h3>
        <div class="row">
          @foreach($tourism->gallery as $img)
            <div class="col-md-4 mb-3">
              <img src="{{ $img }}" class="img-fluid rounded" style="height: 200px; object-fit: cover;">
            </div>
          @endforeach
        </div>
      @endif
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Informasi</h5>
          <p><strong>Lokasi:</strong> {{ $tourism->location }}</p>
          @if($tourism->open_time && $tourism->close_time)
            <p><strong>Jam Buka:</strong> {{ $tourism->open_time->format('H:i') }} - {{ $tourism->close_time->format('H:i') }}</p>
          @endif
          @if($tourism->ticket_price > 0)
            <p><strong>Harga Tiket:</strong> Rp {{ number_format($tourism->ticket_price, 0, ',', '.') }}</p>
          @endif
          <a href="{{ route('map') }}" class="btn btn-primary w-100">Lihat di Peta</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
