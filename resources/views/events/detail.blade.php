@extends('layouts.app')

@section('title', $event->name)

@section('content')
<div class="container py-5">
  <div class="row">
    <div class="col-md-8">
      <img src="{{ $event->image ?? 'https://via.placeholder.com/800x500' }}" class="img-fluid rounded mb-4" alt="{{ $event->name }}" style="height: 500px; object-fit: cover;">
      <h1 class="mb-3">{{ $event->name }}</h1>
      
      <h3 class="mt-5">Deskripsi</h3>
      <p>{{ $event->description }}</p>

      <h3 class="mt-5">Detail Event</h3>
      <p><strong>Tanggal Mulai:</strong> {{ $event->start_date->format('d M Y H:i') }}</p>
      <p><strong>Tanggal Selesai:</strong> {{ $event->end_date->format('d M Y H:i') }}</p>
      <p><strong>Lokasi:</strong> {{ $event->location }}</p>
      <p><strong>Status:</strong> <span class="badge bg-info">{{ ucfirst($event->status) }}</span></p>
      @if($event->max_participants)
        <p><strong>Kuota Peserta:</strong> {{ $event->max_participants }}</p>
      @endif
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Daftar Event</h5>
          @auth
            @if($event->is_registration_open)
              <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#registerModal">Daftar Sekarang</button>
            @else
              <button class="btn btn-secondary w-100" disabled>Pendaftaran Ditutup</button>
            @endif
          @else
            <p class="text-muted">Silakan login terlebih dahulu untuk mendaftar</p>
            <a href="{{ route('login') }}" class="btn btn-primary w-100">Login</a>
          @endauth
        </div>
      </div>
    </div>
  </div>
</div>

@auth
<div class="modal fade" id="registerModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Daftar Event</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('events.register', $event->id) }}">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Nomor Telepon</label>
            <input type="tel" name="phone" class="form-control" value="{{ Auth::user()->phone }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Catatan</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Daftar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endauth
@endsection
