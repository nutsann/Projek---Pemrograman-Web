@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container py-5">
  <div class="row">
    <div class="col-md-8">
      <h2 class="mb-4">Detail Pesanan</h2>
      <div class="card mb-4">
        <div class="card-header bg-light">
          <div class="row">
            <div class="col-md-8">
              <h6 class="mb-0">{{ $order->order_number }}</h6>
              <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
            </div>
            <div class="col-md-4 text-end">
              <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'processing' ? 'info' : 'success') }}">
                {{ ucfirst($order->status) }}
              </span>
            </div>
          </div>
        </div>
        <div class="card-body">
          <h5 class="mb-3">Produk Pesanan</h5>
          @foreach($order->items as $item)
            <div class="row align-items-center mb-3 pb-3 border-bottom">
              <div class="col-md-7">
                <h6 class="mb-1">{{ $item->product_name }}</h6>
                <p class="text-muted small mb-0">{{ $item->umkm->name }}</p>
              </div>
              <div class="col-md-3">
                <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</small>
              </div>
              <div class="col-md-2 text-end">
                <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="card">
        <div class="card-header bg-light">
          <h5 class="mb-0">Data Pengiriman</h5>
        </div>
        <div class="card-body">
          <p><strong>Nama:</strong> {{ $order->shipping_name }}</p>
          <p><strong>Telepon:</strong> {{ $order->shipping_phone }}</p>
          <p><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
          @if($order->notes)
            <p><strong>Catatan:</strong> {{ $order->notes }}</p>
          @endif
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card sticky-top" style="top: 80px;">
        <div class="card-body">
          <h5 class="card-title mb-3">Ringkasan Pesanan</h5>
          <div class="mb-2">
            <div class="d-flex justify-content-between">
              <span>Subtotal</span>
              <strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong>
            </div>
          </div>
          <div class="mb-3">
            <div class="d-flex justify-content-between">
              <span>Biaya Pengiriman</span>
              <strong>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong>
            </div>
          </div>
          <hr>
          <div class="mb-4">
            <div class="d-flex justify-content-between">
              <strong>Total</strong>
              <strong class="text-success" style="font-size: 1.2rem;">Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
            </div>
          </div>
          @if($order->status === 'completed')
            <a href="{{ route('reviews.create', $order->id) }}" class="btn btn-success w-100">Buat Review</a>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
