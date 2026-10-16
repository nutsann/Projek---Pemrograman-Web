@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
  <div class="row">
    <div class="col-md-8">
      <h2 class="mb-4">Checkout</h2>
      <form method="POST" action="{{ route('checkout.process') }}">
        @csrf
        <div class="card mb-4">
          <div class="card-header bg-light">
            <h5 class="mb-0">Data Pengiriman</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label">Nama Penerima</label>
              <input type="text" name="shipping_name" class="form-control @error('shipping_name') is-invalid @enderror" value="{{ old('shipping_name', Auth::user()->name) }}" required>
              @error('shipping_name')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Nomor Telepon</label>
              <input type="tel" name="shipping_phone" class="form-control @error('shipping_phone') is-invalid @enderror" value="{{ old('shipping_phone', Auth::user()->phone) }}" required>
              @error('shipping_phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Alamat Pengiriman</label>
              <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" rows="3" required>{{ old('shipping_address', Auth::user()->address) }}</textarea>
              @error('shipping_address')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Catatan (Opsional)</label>
              <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-header bg-light">
            <h5 class="mb-0">Ringkasan Pesanan</h5>
          </div>
          <div class="card-body">
            @foreach($carts as $cart)
              <div class="row align-items-center mb-3 pb-3 border-bottom">
                <div class="col-md-7">
                  <h6 class="mb-1">{{ $cart->product->name }}</h6>
                  <p class="text-muted small mb-0">{{ $cart->product->umkm->name }}</p>
                </div>
                <div class="col-md-3">
                  <small class="text-muted">{{ $cart->quantity }} x Rp {{ number_format($cart->product->price, 0, ',', '.') }}</small>
                </div>
                <div class="col-md-2 text-end">
                  <strong>Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}</strong>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-9">Subtotal</div>
              <div class="col-md-3 text-end">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
            </div>
            <div class="row mb-3">
              <div class="col-md-9">Biaya Pengiriman</div>
              <div class="col-md-3 text-end">Rp 0</div>
            </div>
            <hr>
            <div class="row fw-bold">
              <div class="col-md-9">Total</div>
              <div class="col-md-3 text-end text-success" style="font-size: 1.3rem;">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
            </div>
          </div>
        </div>

        <div class="mt-4 d-flex gap-2">
          <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">Kembali ke Keranjang</a>
          <button type="submit" class="btn btn-primary flex-grow-1">Proses Pesanan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
