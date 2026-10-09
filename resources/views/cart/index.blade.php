@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<div class="container py-5">
  <h2 class="section-title">Keranjang Belanja</h2>

  @php $subtotal = $subtotal ?? 0; @endphp

  @if($carts->isEmpty())
    <div class="text-center py-5">
      <i class="fas fa-shopping-cart" style="font-size: 4rem; color: #ccc;"></i>
      <h4 class="mt-3">Keranjang kosong</h4>
      <p class="text-muted mb-4">Anda belum menambahkan produk ke keranjang.</p>
      <a href="{{ route('marketplace') }}" class="btn btn-primary">Jelajahi Marketplace</a>
    </div>
  @else
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($carts as $cart)
            <tr>
              <td>
                <div class="d-flex align-items-center gap-3">
                  <img src="{{ $cart->product->image ?? 'https://via.placeholder.com/80x80' }}" alt="{{ $cart->product->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                  <div>
                    <h6 class="mb-0">{{ $cart->product->name }}</h6>
                    <small class="text-muted">{{ $cart->product->umkm->name ?? '-' }}</small>
                  </div>
                </div>
              </td>
              <td>Rp {{ number_format($cart->product->price, 0, ',', '.') }}</td>
              <td>
                <form method="POST" action="{{ route('cart.update', $cart->id) }}" class="d-flex gap-1" style="width: 120px;">
                  @csrf
                  @method('PUT')
                  <input type="number" name="quantity" value="{{ $cart->quantity }}" min="1" max="{{ $cart->product->stock }}" class="form-control form-control-sm">
                  <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                </form>
              </td>
              <td>Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}</td>
              <td>
                <form method="POST" action="{{ route('cart.remove', $cart->id) }}" style="display: inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus dari keranjang?')">Hapus</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr class="table-light">
            <td colspan="3" class="text-end fw-bold">Total:</td>
            <td class="fw-bold text-success">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
      <a href="{{ route('marketplace') }}" class="btn btn-outline-secondary">Kembali ke Marketplace</a>
      <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg">Lanjut ke Checkout <i class="fas fa-arrow-right"></i></a>
    </div>
  @endif
</div>
@endsection