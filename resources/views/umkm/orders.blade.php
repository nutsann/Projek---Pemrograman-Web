@extends('layouts.app')

@section('title', 'Pesanan Masuk')

@section('content')
<div class="container py-4">
  <h3>Pesanan Masuk</h3>
  <div class="card">
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Pelanggan</th>
            <th>Total (Produk Saya)</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
            <tr>
              <td>{{ $order->order_number }}</td>
              <td>{{ $order->user->name }}</td>
              <td>Rp {{ number_format($order->items->where('umkm_id', $umkm->id)->sum('subtotal'), 0, ',', '.') }}</td>
              <td><span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'processing' ? 'info' : 'success') }}">{{ ucfirst($order->status) }}</span></td>
              <td>
                <form method="POST" action="{{ route('umkm.order-items.update', $order->items->where('umkm_id', $umkm->id)->first()->id) }}" style="display:inline">
                  @csrf @method('PUT')
                  <select name="status" onchange="this.form.submit()" class="form-select form-select-sm d-inline-block" style="width: auto">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Proses</option>
                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Batal</option>
                  </select>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      {{ $orders->links() }}
    </div>
  </div>
</div>
@endsection