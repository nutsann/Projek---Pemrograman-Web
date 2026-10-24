@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('admin_content')
<div class="page-header-box d-flex justify-content-between align-items-center">
  <div>
    <h1 class="page-header-title">Detail Pesanan #{{ $order->order_number }}</h1>
    <p class="text-muted mb-0">{{ $order->created_at->format('d M Y H:i') }}</p>
  </div>
  <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary">Kembali</a>
</div>

<div class="row g-4">
  <div class="col-lg-7">
    <div class="admin-table-card p-4 mb-4">
      <h5>Produk</h5>
      @foreach($order->items as $item)
        <div class="d-flex justify-content-between border-bottom py-3">
          <div>
            <strong>{{ $item->product_name }}</strong>
            <div class="small text-muted">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
          </div>
          <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
        </div>
      @endforeach
    </div>

    <div class="admin-table-card p-4">
      <h5>Pengiriman</h5>
      <p class="mb-1"><strong>Penerima:</strong> {{ $order->shipping_name }}</p>
      <p class="mb-1"><strong>Telepon:</strong> {{ $order->shipping_phone }}</p>
      <p class="mb-0"><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="admin-table-card p-4">
      <h5>Informasi Pembayaran</h5>
      <p><strong>Metode:</strong> {{ \App\Models\Order::paymentMethodLabel($order->payment_method) }}</p>
      <p><strong>Status:</strong> {{ \App\Models\Order::paymentStatusLabel($order->payment_status) }}</p>
      <p><strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}</p>
      @if($order->payment_proof)
        <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="btn btn-success w-100">Buka Bukti Pembayaran</a>
      @else
        <div class="alert alert-warning mb-0">Belum ada bukti pembayaran.</div>
      @endif
    </div>
  </div>
</div>
@endsection
