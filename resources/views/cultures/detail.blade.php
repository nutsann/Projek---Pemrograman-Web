@extends('layouts.app')

@section('title', $culture->name)

@section('content')
<div class="container py-5">
  <div class="row">
    <div class="col-md-8">
      <img src="{{ $culture->image ?? 'https://via.placeholder.com/800x500' }}" class="img-fluid rounded mb-4" alt="{{ $culture->name }}" style="height: 500px; object-fit: cover;">
      <h1 class="mb-3">{{ $culture->name }}</h1>
      <p class="text-muted mb-4"><i class="fas fa-map-marker-alt"></i> {{ $culture->location }}</p>
      
      <h3 class="mt-5">Deskripsi</h3>
      <p>{{ $culture->description }}</p>

      @if($culture->history)
        <h3 class="mt-5">Sejarah</h3>
        <p>{{ $culture->history }}</p>
      @endif

      @if($culture->gallery)
        <h3 class="mt-5">Galeri</h3>
        <div class="row">
          @foreach($culture->gallery as $img)
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
          <p><strong>Kategori:</strong> {{ $culture->category->name ?? '-' }}</p>
          <p><strong>Lokasi:</strong> {{ $culture->location }}</p>
          <a href="{{ route('map') }}" class="btn btn-primary w-100">Lihat di Peta</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
