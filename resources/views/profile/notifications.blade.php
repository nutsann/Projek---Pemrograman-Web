@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="container py-5" style="max-width:900px;">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="fw-bold" style="color:#105746;">Notifikasi</h1>
    <a href="{{ route('profile') }}" class="btn btn-outline-secondary">Kembali ke Profil</a>
  </div>

  <div class="card">
    <div class="card-body">
      @forelse($notifications as $notification)
        <div class="border-bottom py-3">
          <div class="fw-bold">{{ $notification->data['message'] ?? 'Notifikasi baru' }}</div>
          <div class="small text-muted">{{ $notification->created_at->format('d M Y H:i') }}</div>
          @if(!empty($notification->data['order_id']))
            <a href="{{ route('orders.show', $notification->data['order_id']) }}" class="small">Lihat order</a>
          @endif
        </div>
      @empty
        <p class="text-muted text-center mb-0">Belum ada notifikasi.</p>
      @endforelse
    </div>
  </div>

  <div class="d-flex justify-content-center mt-4">{{ $notifications->links() }}</div>
</div>
@endsection
