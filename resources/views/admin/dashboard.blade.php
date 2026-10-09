@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Admin Dashboard</h2>
    <div class="btn-group">
      <a href="{{ route('admin.cultures') }}" class="btn btn-outline-primary btn-sm">Kelola Budaya</a>
      <a href="{{ route('admin.tourisms') }}" class="btn btn-outline-primary btn-sm">Kelola Wisata</a>
      <a href="{{ route('admin.events') }}" class="btn btn-outline-primary btn-sm">Kelola Event</a>
      <a href="{{ route('admin.umkms') }}" class="btn btn-outline-primary btn-sm">Kelola UMKM</a>
    </div>
  </div>

  <div class="row">
    <div class="col-md-3">
      <div class="card mb-3 border-primary">
        <div class="card-body">
          <h6 class="text-muted mb-1">Total Pengguna</h6>
          <h3 class="mb-0 text-primary">{{ $stats['users'] }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card mb-3 border-info">
        <div class="card-body">
          <h6 class="text-muted mb-1">Total UMKM</h6>
          <h3 class="mb-0 text-info">{{ $stats['umkms'] }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card mb-3 border-success">
        <div class="card-body">
          <h6 class="text-muted mb-1">Total Produk</h6>
          <h3 class="mb-0 text-success">{{ $stats['products'] }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card mb-3 border-warning">
        <div class="card-body">
          <h6 class="text-muted mb-1">Total Pesanan</h6>
          <h3 class="mb-0 text-warning">{{ $stats['orders'] }}</h3>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-3">
      <div class="card mb-3">
        <div class="card-body">
          <h6 class="text-muted mb-1">Budaya</h6>
          <h3 class="mb-0">{{ $stats['cultures'] }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card mb-3">
        <div class="card-body">
          <h6 class="text-muted mb-1">Wisata</h6>
          <h3 class="mb-0">{{ $stats['tourisms'] }}</h3>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card mb-3">
        <div class="card-body">
          <h6 class="text-muted mb-1">Event</h6>
          <h3 class="mb-0">{{ $stats['events'] }}</h3>
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
  </div>

  @if($stats['pending_umkms'] > 0)
    <div class="row mt-4">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
            <h5 class="mb-0">⚠️ UMKM Menunggu Approval ({{ $stats['pending_umkms'] }})</h5>
            <a href="{{ route('admin.umkms') }}" class="btn btn-sm btn-outline-dark">Lihat Semua</a>
          </div>
          <div class="card-body">
            @foreach($pending_umkms as $umkm)
              <div class="card mb-3">
                <div class="card-body">
                  <h6 class="mb-1">{{ $umkm->name }}</h6>
                  <small class="text-muted d-block mb-2">PIC: {{ $umkm->user->name }} ({{ $umkm->user->email }})</small>
                  <small class="text-muted d-block mb-3">{{ Str::limit($umkm->description, 80) }}</small>
                  <form method="POST" action="{{ route('admin.umkm.approve', $umkm->id) }}" style="display:inline">
                    @csrf @method('PUT')
                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                  </form>
                  <form method="POST" action="{{ route('admin.umkm.reject', $umkm->id) }}" style="display:inline">
                    @csrf @method('PUT')
                    <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                  </form>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-light">
            <h5 class="mb-0">Pesanan Terbaru</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover table-sm">
                <thead>
                  <tr>
                    <th>Order #</th>
                    <th>Pembeli</th>
                    <th>Total</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($recent_orders as $order)
                    <tr>
                      <td>{{ substr($order->order_number, 0, 8) }}</td>
                      <td>{{ $order->user->name }}</td>
                      <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                      <td><span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'processing' ? 'info' : 'success') }}">{{ ucfirst($order->status) }}</span></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  @else
    <div class="alert alert-success mt-4">✓ Semua UMKM sudah diapprove.</div>
  @endif
</div>
@endsection
