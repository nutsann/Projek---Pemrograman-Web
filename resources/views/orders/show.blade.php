@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('styles')
<style>
  .order-detail-page { background: #FFF7E2; min-height: 85vh; padding-bottom: 70px; }

  /* BREADCRUMB */
  .breadcrumb-wrap { padding: 30px 0 15px; }
  .breadcrumb-custom { font-size: 0.9rem; color: #666; }
  .breadcrumb-custom a { color: #105746; text-decoration: none; font-weight: 500; }
  .breadcrumb-custom a:hover { text-decoration: underline; }

  /* TITLE */
  .page-main-title {
    font-size: 2.4rem;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 24px;
    font-family: serif, 'Times New Roman', Times;
  }

  /* PANEL KARTU */
  .custom-panel-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 28px;
    margin-bottom: 24px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.04);
    border: 1px solid rgba(0,0,0,0.04);
  }
  .panel-heading {
    font-size: 1.25rem;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .panel-heading i { color: #105746; }

  /* BADGE STATUS */
  .order-status-badge {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.82rem;
    font-weight: 700;
    text-transform: uppercase;
  }
  .status-pending { background: #fff5e0; color: #b87c00; }
  .status-processing { background: #e0edff; color: #1f64c4; }
  .status-completed { background: #e0f2ec; color: #105746; }
  .status-cancelled { background: #fde8e8; color: #d32f2f; }

  /* ITEM ROW */
  .item-list-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 0;
    border-bottom: 1px solid #f2f2f2;
    gap: 16px;
  }
  .item-list-row:last-child { border-bottom: none; }
  .item-thumb-sm {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    object-fit: cover;
    flex-shrink: 0;
  }
  .item-title-text {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 2px;
  }
  .item-seller-text {
    font-size: 0.82rem;
    color: #888;
  }
  .item-price-gold {
    font-size: 1.15rem;
    font-weight: 800;
    color: #C18A32;
    text-align: right;
  }

  /* BUTTONS */
  .btn-green-action {
    background: #105746;
    color: #ffffff;
    border: none;
    border-radius: 12px;
    height: 48px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    text-decoration: none;
    transition: background 0.2s;
  }
  .btn-green-action:hover {
    background: #0d4538;
    color: #ffffff;
  }
</style>
@endsection

@section('content')
<div class="order-detail-page">

  {{-- BREADCRUMB --}}
  <div class="container breadcrumb-wrap">
    <div class="breadcrumb-custom">
      <a href="{{ route('home') }}">Home</a> &rsaquo;
      <a href="{{ route('orders.index') }}">Pesanan Saya</a> &rsaquo;
      <span>Detail #{{ $order->order_number }}</span>
    </div>
  </div>

  <div class="container" style="max-width: 1020px;">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
      <div>
        <h1 class="page-main-title mb-1">Detail Pesanan</h1>
        <div class="text-muted small">
          Nomor: <strong class="text-dark">#{{ $order->order_number }}</strong> &bull; Dipesan pada {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB
        </div>
      </div>
      <div>
        <span class="order-status-badge status-{{ $order->status }}">
          {{ \App\Models\Order::statusLabel($order->status) }}
        </span>
      </div>
    </div>

     @if(session('success'))
       <div class="alert alert-success rounded-4 mb-4">
         {{ session('success') }}
       </div>
     @endif
     @if(session('error'))
       <div class="alert alert-danger rounded-4 mb-4">
         {{ session('error') }}
       </div>
     @endif
     @if($errors->any())
       <div class="alert alert-danger rounded-4 mb-4">
         {{ $errors->first() }}
       </div>
     @endif

    <div class="row g-4">
      {{-- KOLOM KIRI: DAFTAR PRODUK & ALAMAT --}}
      <div class="col-lg-7">
        {{-- RINCIAN PRODUK PESANAN --}}
        <div class="custom-panel-card">
          <div class="panel-heading">
            <i class="fas fa-box-open"></i> Produk yang Dipesan
          </div>

          <div class="items-wrap">
            @foreach($order->items as $item)
              <div class="item-list-row">
                <img
                  src="{{ $item->product->image ?? 'https://via.placeholder.com/80x80?text=Produk' }}"
                  class="item-thumb-sm"
                  alt="{{ $item->product_name }}"
                >
                <div style="flex:1;">
                  <div class="item-title-text">{{ $item->product_name }}</div>
                  <div class="item-seller-text">{{ $item->umkm->name ?? 'UMKM Mitra' }}</div>
                  <div class="small text-muted">{{ $item->quantity }} barang x Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                </div>
                <div class="item-price-gold">
                  Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                </div>
              </div>
            @endforeach
          </div>
        </div>

        {{-- DATA PENGIRIMAN --}}
        <div class="custom-panel-card">
          <div class="panel-heading">
            <i class="fas fa-truck"></i> Informasi Pengiriman
          </div>

          <div class="row g-3" style="font-size:0.95rem;">
            <div class="col-sm-6">
              <div class="text-muted small fw-bold text-uppercase">Nama Penerima</div>
              <div class="fw-bold text-dark">{{ $order->shipping_name }}</div>
            </div>
            <div class="col-sm-6">
              <div class="text-muted small fw-bold text-uppercase">Nomor Telepon</div>
              <div class="text-dark">{{ $order->shipping_phone }}</div>
            </div>
            <div class="col-12">
              <div class="text-muted small fw-bold text-uppercase">Alamat Lengkap</div>
              <div class="text-dark">{{ $order->shipping_address }}</div>
            </div>
            @if($order->notes)
              <div class="col-12">
                <div class="text-muted small fw-bold text-uppercase">Catatan untuk Penjual</div>
                <div class="text-dark fst-italic">"{{ $order->notes }}"</div>
              </div>
            @endif
          </div>
        </div>
      </div>

      {{-- KOLOM KANAN: RINGKASAN PEMBAYARAN --}}
      <div class="col-lg-5">
        <div class="custom-panel-card sticky-top" style="top: 90px;">
          <div class="panel-heading">
            <i class="fas fa-receipt"></i> Rincian Pembayaran
          </div>

          <div class="alert alert-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'failed' ? 'danger' : 'warning') }} py-2 small">
            Pembayaran: <strong>{{ \App\Models\Order::paymentStatusLabel($order->payment_status) }}</strong>
            <br>Metode: <strong>{{ \App\Models\Order::paymentMethodLabel($order->payment_method) }}</strong>
          </div>

           <div class="d-flex justify-content-between mb-2" style="font-size:0.95rem;">
             <span class="text-muted">Subtotal Produk</span>
            <span class="fw-bold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
          </div>

          <div class="d-flex justify-content-between mb-3" style="font-size:0.95rem;">
            <span class="text-muted">Biaya Pengiriman</span>
            <span class="fw-bold text-success">
              {{ $order->shipping_cost > 0 ? 'Rp ' . number_format($order->shipping_cost, 0, ',', '.') : 'Gratis (Lokal)' }}
            </span>
          </div>

          <hr style="border-color:#eee; margin:16px 0;">

          <div class="d-flex justify-content-between align-items-baseline mb-4">
            <span class="fw-bold fs-5 text-dark">Total Tagihan</span>
            <span class="fw-bold fs-4" style="color:#105746;">
              Rp {{ number_format($order->total, 0, ',', '.') }}
            </span>
          </div>

           @if(in_array($order->payment_method, ['bank_transfer', 'qris'], true) && $order->payment_status === 'unpaid')
             <form method="POST" action="{{ route('orders.pay', $order->id) }}" class="mb-2">
               @csrf
               <button type="submit" class="btn-green-action">Bayar dengan Midtrans</button>
             </form>
           @endif

           @if(in_array($order->payment_method, ['bank_transfer', 'qris'], true) && $order->payment_status !== 'paid')
             <form method="POST" action="{{ route('orders.payment-proof', $order->id) }}" enctype="multipart/form-data" class="mb-3">
               @csrf
               <label class="form-label fw-bold">Upload Bukti Pembayaran</label>
               <input type="file" name="payment_proof" class="form-control mb-2" accept=".jpg,.jpeg,.png,.pdf" required>
               @error('payment_proof')
                 <div class="text-danger small mb-2">{{ $message }}</div>
               @enderror
               <button type="submit" class="btn-green-action">Kirim Bukti Pembayaran</button>
             </form>
           @elseif($order->payment_proof)
             <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="btn btn-outline-success w-100 mb-3">Lihat Bukti Pembayaran</a>
           @endif

           @if($order->status === 'completed')
            <a href="{{ route('reviews.create', $order->id) }}" class="btn-green-action mb-2">
              <i class="fas fa-star text-warning"></i> Berikan Ulasan Produk
            </a>
          @endif

           @if($order->status === 'pending')
             <form method="POST" action="{{ route('orders.cancel', $order->id) }}" class="mb-2" onsubmit="return confirm('Batalkan pesanan ini?')">
               @csrf @method('PUT')
               <button type="submit" class="btn btn-outline-danger w-100 py-2" style="border-radius:12px; font-weight:600;">Batalkan Pesanan</button>
             </form>
           @endif

           <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary w-100 py-2" style="border-radius:12px; font-weight:600;">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Pesanan Saya
          </a>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
