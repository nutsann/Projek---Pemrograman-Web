@extends('layouts.app')

@section('title', 'Pendaftaran Event Saya')

@section('content')
<div class="container py-4">
  <h3>Pendaftaran Event</h3>
  @if($registrations->isEmpty())
    <div class="alert alert-info">Belum ada pendaftaran event.</div>
  @else
    <div class="row">
      @foreach($registrations as $reg)
        <div class="col-md-6 mb-3">
          <div class="card">
            <div class="card-body">
              <h5>{{ $reg->event->name }}</h5>
              <p class="mb-1 text-muted"><i class="fas fa-calendar"></i> {{ $reg->event->start_date->format('d M Y') }}</p>
              <p class="mb-2">Status: <span class="badge bg-info">{{ ucfirst($reg->status) }}</span></p>
              <a href="{{ route('events.detail', $reg->event->slug) }}" class="btn btn-sm btn-outline-primary">Detail Event</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    {{ $registrations->links() }}
  @endif
</div>
@endsection