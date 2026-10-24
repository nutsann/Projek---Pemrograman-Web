@extends('layouts.admin')

@section('title', 'Kelola Pesanan Pelanggan')

@section('admin_content')
<div class="page-header-box">
  <div>
    <h1 class="page-header-title">Kelola Pesanan Marketplace</h1>
    <p class="text-muted mb-0">Pantau transaksi belanja produk UMKM lokal dan status pengiriman</p>
  </div>
</div>

@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="admin-table-card mb-3">
  <form method="GET" action="{{ route('admin.orders') }}" class="row g-2 align-items-end">
    <div class="col-md-4">
      <label for="payment_status" class="form-label fw-bold">Filter Status Pembayaran</label>
      <select id="payment_status" name="payment_status" class="form-select">
        <option value="">Semua Status</option>
        @foreach(['unpaid','waiting_verification','paid','failed'] as $paymentStatus)
          <option value="{{ $paymentStatus }}" @selected(request('payment_status') === $paymentStatus)>{{ \App\Models\Order::paymentStatusLabel($paymentStatus) }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn text-white" style="background:#105746;">Filter</button>
      <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
  </form>
</div>

<div class="admin-table-card">
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Nomor Pesanan</th>
          <th>Nama Pelanggan</th>
           <th>Total Pembayaran</th>
           <th>Metode Pembayaran</th>
           <th>Tanggal</th>
          <th>Status Saat Ini</th>
          <th class="text-end">Ubah Status</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $order)
          <tr>
             <td class="fw-bold" style="color:#105746;"><a href="{{ route('admin.order.show', $order->id) }}">#{{ $order->order_number }}</a></td>
            <td>{{ $order->user->name ?? $order->shipping_name }}</td>
            <td class="fw-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
            <td>
              {{ \App\Models\Order::paymentMethodLabel($order->payment_method) }}<br>
              <span class="badge bg-secondary">{{ \App\Models\Order::paymentStatusLabel($order->payment_status) }}</span>
              @if($order->payment_proof)
                <br><a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="small">Lihat bukti</a>
              @endif
              <form method="POST" action="{{ route('admin.order.payment-status', $order->id) }}" class="mt-2">
                @csrf @method('PUT')
                <select name="payment_status" class="form-select form-select-sm">
                  @foreach(['unpaid','waiting_verification','paid','failed'] as $paymentStatus)
                    <option value="{{ $paymentStatus }}" @selected($order->payment_status === $paymentStatus)>{{ \App\Models\Order::paymentStatusLabel($paymentStatus) }}</option>
                  @endforeach
                </select>
                <button type="submit" class="btn btn-sm btn-outline-success mt-1">Simpan</button>
              </form>
            </td>
            <td class="text-muted small">{{ $order->created_at->format('d M Y, H:i') }}</td>
            <td>
              <span class="badge" style="background:{{ $order->status === 'completed' ? '#105746' : ($order->status === 'processing' ? '#0d6efd' : ($order->status === 'pending' ? '#C18A32' : '#dc3545')) }}">
                {{ \App\Models\Order::statusLabel($order->status) }}
              </span>
            </td>
            <td class="text-end">
              <form method="POST" action="{{ route('admin.order.status', $order->id) }}" class="d-inline-flex gap-1">
                @csrf @method('PUT')
                <select name="status" class="form-select form-select-sm" style="border-radius:8px; font-weight:600;">
                  @foreach(['pending','processing','completed','cancelled'] as $s)
                    <option value="{{ $s }}" @selected($order->status === $s)>{{ \App\Models\Order::statusLabel($s) }}</option>
                  @endforeach
                </select>
                <button type="submit" class="btn btn-sm text-white" style="background:#105746; border-radius:8px;">
                  Update
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
                         <td colspan="7" class="text-center py-4 text-muted">Belum ada transaksi pesanan masuk.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="d-flex justify-content-center mt-3">
    {{ $orders->links() }}
  </div>
</div>
@endsection
