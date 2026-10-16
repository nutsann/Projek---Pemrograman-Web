@extends('layouts.app')

@section('title', 'Dashboard UMKM')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-md-3">
      <div class="card mb-3">
        <div class="card-body">
          <h6 class="text-muted mb-1">Total Produk</h6>
          <h3 class="mb-0">{{ $stats['products'] }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card mb-3">
        <div class="card-body">
          <h6 class="text-muted mb-1">Total Pesanan</h6>
          <h3 class="mb-0">{{ $stats['orders'] }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card mb-3">
        <div class="card-body">
          <h6 class="text-muted mb-1">Total Penjualan</h6>
          <h3 class="mb-0 text-success">Rp {{ number_format($stats['total_sales'], 0, ',', '.') }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card mb-3">
        <div class="card-body">
          <h6 class="text-muted mb-1">Pesanan Pending</h6>
          <h3 class="mb-0 text-warning">{{ $stats['pending_orders'] }}</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Pesanan Terbaru</h5>
          <a href="{{ route('umkm.orders') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
        </div>
        <div class="card-body">
          @if($recent_orders->isEmpty())
            <p class="text-muted text-center py-3">Belum ada pesanan.</p>
          @else
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Order #</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($recent_orders as $order)
                    <tr>
                      <td>{{ $order->order_number }}</td>
                      <td>{{ $order->created_at->format('d M Y') }}</td>
                      <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                      <td>
                        <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'processing' ? 'info' : 'success') }}">
                          {{ ucfirst($order->status) }}
                        </span>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Produk</h5>
          <a href="{{ route('umkm.products.create') }}" class="btn btn-sm btn-primary">Tambah</a>
        </div>
        <div class="card-body">
          <a href="{{ route('umkm.products') }}" class="btn btn-outline-primary w-100">Kelola Produk</a>
        </div>
      </div>

      <div class="card mt-3">
        <div class="card-header bg-light">
          <h5 class="mb-0">UMKM Profile</h5>
        </div>
        <div class="card-body">
          <h6>{{ $umkm->name }}</h6>
          <p class="text-muted small mb-2">{{ $umkm->address }}</p>
          <p class="small mb-0"><i class="fas fa-phone"></i> {{ $umkm->phone }}</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
