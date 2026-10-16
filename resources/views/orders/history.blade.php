@extends('layouts.app')

@section('title', 'Histori Pesanan')

@section('content')
<div class="container py-5">
  <h2 class="mb-4">Histori Pesanan</h2>

  @if($orders->isEmpty())
    <div class="alert alert-info text-center py-5">
      <h5>Belum ada histori pesanan</h5>
      <p>Mulai berbelanja di <a href="{{ route('marketplace') }}">marketplace</a>.</p>
    </div>
  @else
    <div class="row">
      @foreach($orders as $order)
        <div class="col-md-12 mb-3">
          <div class="card">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-md-8">
                  <h6 class="mb-1">{{ $order->order_number }}</h6>
                  <p class="text-muted small mb-2">{{ $order->created_at->format('d M Y H:i') }}</p>
                  <p class="small mb-0">{{ $order->items->count() }} produk: {{ Str::limit($order->items->pluck('product_name')->join(', '), 60) }}</p>
                </div>
                <div class="col-md-4 text-end">
                  <div class="mb-2"><strong class="text-success">Rp {{ number_format($order->total, 0, ',', '.') }}</strong></div>
                  <div class="mb-2"><span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'processing' ? 'info' : ($order->status === 'completed' ? 'success' : 'danger')) }}">{{ \App\Models\Order::statusLabel($order->status) }}</span></div>
                  <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">{{ $orders->links() }}</div>
  @endif
</div>
@endsection
