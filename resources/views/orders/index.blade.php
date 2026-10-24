@extends('layouts.app')

@section('title', 'Riwayat Pesanan Saya')

@section('styles')
<style>
  .orders-page { background: #FFF7E2; min-height: 85vh; padding-bottom: 70px; }

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

  /* KARTU PESANAN */
  .order-history-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 24px 28px;
    margin-bottom: 20px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.04);
    border: 1px solid rgba(0,0,0,0.04);
    transition: transform 0.15s, box-shadow 0.15s;
  }
  .order-history-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
  }

  .order-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 14px;
    margin-bottom: 14px;
    border-bottom: 1.5px solid #f2f2f2;
    flex-wrap: wrap;
    gap: 10px;
  }
  .order-number {
    font-size: 1.15rem;
    font-weight: 800;
    color: #105746;
  }
  .order-date {
    font-size: 0.85rem;
    color: #888;
  }

  /* BADGE STATUS */
  .order-status-badge {
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
  }
  .status-pending { background: #fff5e0; color: #b87c00; }
  .status-processing { background: #e0edff; color: #1f64c4; }
  .status-completed { background: #e0f2ec; color: #105746; }
  .status-cancelled { background: #fde8e8; color: #d32f2f; }

  /* ISI PESANAN */
  .order-content-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
  }
  .order-products-summary {
    font-size: 0.95rem;
    color: #444;
    line-height: 1.5;
  }
  .order-total-price {
    font-size: 1.35rem;
    font-weight: 800;
    color: #C18A32;
  }

  .btn-detail-order {
    background: #105746;
    color: #ffffff;
    border: none;
    border-radius: 10px;
    padding: 8px 22px;
    font-size: 0.9rem;
    font-weight: 700;
    text-decoration: none;
    transition: background 0.2s;
    display: inline-block;
  }
  .btn-detail-order:hover {
    background: #0d4538;
    color: #ffffff;
  }

  /* EMPTY STATE */
  .empty-state-box {
    background: #ffffff;
    border-radius: 24px;
    padding: 60px 24px;
    text-align: center;
    box-shadow: 0 4px 18px rgba(0,0,0,0.04);
  }
  .empty-state-box i {
    font-size: 3.5rem;
    color: #d5d5d5;
    margin-bottom: 16px;
  }
</style>
@endsection

@section('content')
<div class="orders-page">

  {{-- BREADCRUMB --}}
  <div class="container breadcrumb-wrap">
    <div class="breadcrumb-custom">
      <a href="{{ route('home') }}">Home</a> &rsaquo;
      <span>Pesanan Saya</span>
    </div>
  </div>

  <div class="container" style="max-width: 960px;">
    <h1 class="page-main-title">Riwayat Pesanan Saya</h1>

    @if($orders->isEmpty())
      <div class="empty-state-box">
        <i class="fas fa-box-open d-block"></i>
        <h3 class="fw-bold text-dark mb-2">Belum Ada Pesanan</h3>
        <p class="text-muted mb-4">Anda belum pernah melakukan pemesanan produk UMKM lokal.</p>
        <a href="{{ route('marketplace') }}" class="btn text-white px-4 py-2" style="background:#105746; border-radius:12px; font-weight:700;">
          Mulai Belanja di Marketplace
        </a>
      </div>
    @else
      <div>
        @foreach($orders as $order)
          <div class="order-history-card">
            <div class="order-card-header">
              <div>
                <span class="order-number">#{{ $order->order_number }}</span>
                <span class="order-date ms-2">&bull; {{ $order->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
              </div>
               <div class="d-flex gap-2 align-items-center flex-wrap justify-content-end">
                 <span class="order-status-badge status-{{ $order->status }}">
                   Pesanan: {{ \App\Models\Order::statusLabel($order->status) }}
                 </span>
                 <span class="badge rounded-pill text-bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'failed' ? 'danger' : 'warning') }}">
                   Bayar: {{ \App\Models\Order::paymentStatusLabel($order->payment_status) }}
                 </span>
               </div>
            </div>

            <div class="order-content-row">
              <div style="flex:1; min-width: 250px;">
                @php
                  $itemCount = $order->items->count();
                  $productNames = $order->items->pluck('product_name')->join(', ', ', dan ');
                @endphp
                <div class="order-products-summary">
                  <strong>{{ $itemCount }} Produk:</strong> {{ Str::limit($productNames, 70) }}
                </div>
                <div class="small text-muted mt-1">
                  Penerima: {{ $order->shipping_name }} ({{ $order->shipping_phone }})
                </div>
              </div>

              <div class="text-end">
                <div class="small text-muted mb-1">Total Belanja</div>
                <div class="order-total-price">
                  Rp {{ number_format($order->total, 0, ',', '.') }}
                </div>
                <div class="mt-2">
                  <a href="{{ route('orders.show', $order->id) }}" class="btn-detail-order">
                    Lihat Detail
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
      </div>
    @endif
  </div>

</div>
@endsection
