@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="text-center mb-5">
        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
          <i class="fas fa-check" style="font-size: 2rem;"></i>
        </div>
        <h2>Pesanan Berhasil Dibuat!</h2>
        <p class="text-muted">Terima kasih telah berbelanja di Platform Digital Budaya Tanjungpinang.</p>
      </div>

      <div class="card mb-4">
        <div class="card-header bg-light">
          <h5 class="mb-0">Detail Pesanan</h5>
        </div>
        <div class="card-body">
          <p><strong>Nomor Pesanan:</strong> {{ $order->order_number }}</p>
          <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>
          <p><strong>Total:</strong> <span class="text-success">Rp {{ number_format($order->total, 0, ',', '.') }}</span></p>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header bg-light">
          <h5 class="mb-0">Produk Pesanan</h5>
        </div>
        <div class="card-body">
          @foreach($order->items as $item)
            <div class="row align-items-center mb-3 pb-3 border-bottom">
              <div class="col-md-7">
                <h6 class="mb-1">{{ $item->product_name }}</h6>
                <small class="text-muted">UMKM: {{ $item->umkm->name }}</small>
              </div>
              <div class="col-md-3 text-center">
                <small>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</small>
              </div>
              <div class="col-md-2 text-end">
                <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header bg-light">
          <h5 class="mb-0">Data Pengiriman</h5>
        </div>
        <div class="card-body">
          <p><strong>Nama:</strong> {{ $order->shipping_name }}</p>
          <p><strong>Telepon:</strong> {{ $order->shipping_phone }}</p>
          <p><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
        </div>
      </div>

      <div class="d-flex gap-2 justify-content-center">
        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary">Lihat Detail Pesanan</a>
        <a href="{{ route('marketplace') }}" class="btn btn-outline-secondary">Lanjut Belanja</a>
      </div>
    </div>
  </div>
</div>
@endsection