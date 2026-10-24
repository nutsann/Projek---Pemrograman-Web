@extends('layouts.app')

@section('title', 'Pembayaran Order')

@section('content')
<div class="container py-5" style="max-width:700px;">
  <div class="card p-4 text-center">
    <h2 class="mb-3">Bayar Order #{{ $order->order_number }}</h2>
    <p class="text-muted">Total: <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></p>
    <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
  </div>
</div>
@endsection

@push('scripts')
<script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
  document.getElementById('pay-button').addEventListener('click', function () {
    window.snap.pay(@json($snapToken), {
      onSuccess: function () { window.location.href = @json(route('orders.show', $order->id)); },
      onPending: function () { window.location.href = @json(route('orders.show', $order->id)); },
      onError: function () { alert('Pembayaran gagal. Silakan coba lagi.'); }
    });
  });
</script>
@endpush
