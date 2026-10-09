@extends('layouts.app')

@section('title', 'Kelola Pesanan')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Kelola Pesanan</h3>
  </div>

  <div class="card">
    <div class="card-body">
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Order #</th>
              <th>Pembeli</th>
              <th>Total</th>
              <th>Status</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($orders as $order)
              <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->user->name ?? '-' }}</td>
                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                <td><span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'processing' ? 'info' : ($order->status === 'completed' ? 'success' : 'danger')) }}">{{ \App\Models\Order::statusLabel($order->status) }}</span></td>
                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                <td>
                  <form method="POST" action="{{ route('admin.order.status', $order->id) }}" class="d-flex gap-1">
                    @csrf @method('PUT')
                    <select name="status" class="form-select form-select-sm" style="width:auto">
                      @foreach(['pending','processing','completed','cancelled'] as $s)
                        <option value="{{ $s }}" @selected($order->status === $s)>{{ \App\Models\Order::statusLabel($s) }}</option>
                      @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center text-muted">Belum ada pesanan.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $orders->links() }}
    </div>
  </div>
</div>
@endsection
