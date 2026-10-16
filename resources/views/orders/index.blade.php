@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="container py-5">
  <h2 class="mb-4">Riwayat Pesanan</h2>

  @if($orders->isEmpty())
    <div class="alert alert-info text-center py-5">
      <i class="fas fa-box-open" style="font-size: 2rem; color: #ccc; margin-bottom: 10px;"></i>
      <h5>Belum ada pesanan</h5>
      <p>Mulai berbelanja sekarang di <a href="{{ route('marketplace') }}">marketplace</a>.</p>
    </div>
  @else
    <div class="row">
      @foreach($orders as $order)
        <div class="col-md-12 mb-3">
          <div class="card border-start border-5" style="border-start-color: {{ $order->status === 'pending' ? '#ffc107' : ($order->status === 'processing' ? '#17a2b8' : '#28a745') }}!important;">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-md-8">
                  <h6 class="mb-1">{{ $order->order_number }}</h6>
                  <p class="text-muted small mb-2">{{ $order->created_at->format('d M Y H:i') }}</p>
                  <p class="small mb-0">
                    @php
                      $itemCount = $order->items->count();
                      $productNames = $order->items->pluck('product_name')->join(', ', ', dan ');
                    @endphp
                    {{ $itemCount }} produk: {{ Str::limit($productNames, 50) }}
                  </p>
                </div>
                <div class="col-md-4 text-end">
                  <div class="mb-2">
                    <strong class="text-success">Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                  </div>
                  <div class="mb-2">
                    <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'processing' ? 'info' : 'success') }}">
                      {{ $order->status === 'pending' ? 'Menunggu' : ($order->status === 'processing' ? 'Diproses' : 'Selesai') }}
                    </span>
                  </div>
                  <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                </div>
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
@endsection
