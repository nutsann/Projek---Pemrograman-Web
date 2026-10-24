@extends('layouts.app')

@section('title', 'Keranjang Belanja & Checkout')

@section('styles')
<style>
  .checkout-page { background: #FFF7E2; min-height: 85vh; padding-bottom: 70px; }

  /* BREADCRUMB */
  .breadcrumb-wrap {
    padding: 30px 0 15px;
  }
  .breadcrumb-custom {
    font-size: 0.9rem;
    color: #666;
  }
  .breadcrumb-custom a { color: #105746; text-decoration: none; font-weight: 500; }
  .breadcrumb-custom a:hover { text-decoration: underline; }

  /* TITLE */
  .checkout-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 24px;
    font-family: serif, 'Times New Roman', Times;
  }
  .section-subheading {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 20px;
    font-family: serif, 'Times New Roman', Times;
  }

  /* ITEM CARD */
  .cart-item-row {
    background: #ffffff;
    border-radius: 18px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 16px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    border: 1px solid rgba(0,0,0,0.04);
  }
  .cart-item-left {
    display: flex;
    align-items: center;
    gap: 18px;
    flex: 1;
    min-width: 200px;
  }
  .cart-item-img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 12px;
    flex-shrink: 0;
  }
  .cart-item-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
  }
  .cart-item-seller {
    font-size: 0.85rem;
    color: #888;
    margin-top: 4px;
  }

  /* QUANTITY CONTROLLER */
  .qty-counter {
    display: inline-flex;
    align-items: center;
    background: #ffffff;
    border: 1.5px solid #d5d5d5;
    border-radius: 12px;
    height: 48px;
    padding: 0 10px;
    min-width: 140px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
  }
  .qty-btn {
    background: transparent;
    border: none;
    font-size: 1.3rem;
    font-weight: 600;
    color: #333;
    cursor: pointer;
    width: 34px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: color 0.15s;
    user-select: none;
  }
  .qty-btn:hover { color: #105746; }
  .qty-input {
    flex: 1;
    border: none;
    background: transparent;
    text-align: center;
    font-size: 1.15rem;
    font-weight: 700;
    color: #1a1a1a;
    outline: none;
    width: 44px;
  }

  /* PRICE */
  .cart-item-price {
    font-size: 1.3rem;
    font-weight: 800;
    color: #1a1a1a;
    min-width: 160px;
    text-align: right;
  }

  /* PROMO CODE SECTION */
  .promo-row {
    display: flex;
    gap: 16px;
    margin: 28px 0 36px;
  }
  .promo-input-wrap {
    flex: 1;
    background: #f1ede1;
    border-radius: 14px;
    padding: 0 20px;
    display: flex;
    align-items: center;
    height: 54px;
  }
  .promo-input-wrap input {
    width: 100%;
    border: none;
    background: transparent;
    outline: none;
    font-size: 1rem;
    color: #444;
  }
  .promo-input-wrap input::placeholder {
    color: #8c887e;
  }
  .btn-use-promo {
    background: #105746;
    color: #ffffff;
    border: none;
    border-radius: 14px;
    padding: 0 42px;
    font-size: 1.05rem;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s;
    height: 54px;
    white-space: nowrap;
  }
  .btn-use-promo:hover {
    background: #0d4538;
  }

  /* RINGKASAN PESANAN BOX */
  .summary-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.04);
  }
  .summary-title {
    font-size: 1.45rem;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 24px;
    font-family: serif, 'Times New Roman', Times;
  }
  .summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
    font-size: 1.15rem;
    color: #222;
  }
  .summary-row .label {
    font-weight: 700;
  }
  .summary-row .value {
    font-weight: 800;
  }
  .summary-divider {
    height: 1px;
    background: #eeeeee;
    margin: 20px 0;
  }
  .summary-row.total-row {
    font-size: 1.35rem;
    color: #1a1a1a;
    margin-bottom: 28px;
  }
  .btn-checkout-submit {
    background: #105746;
    color: #ffffff;
    border: none;
    border-radius: 14px;
    width: 100%;
    height: 56px;
    font-size: 1.15rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
    text-decoration: none;
    box-shadow: 0 4px 14px rgba(16,87,70,0.25);
  }
  .btn-checkout-submit:hover {
    background: #0d4538;
    color: #ffffff;
  }

  /* BTN DELETE ITEM */
  .btn-remove-item {
    background: transparent;
    border: none;
    color: #dc3545;
    font-size: 1.1rem;
    cursor: pointer;
    padding: 6px;
    border-radius: 6px;
    transition: all 0.2s;
  }
  .btn-remove-item:hover {
    background: #ffebe9;
  }

  @media (max-width: 767px) {
    .cart-item-row { flex-direction: column; align-items: stretch; text-align: left; }
    .cart-item-price { text-align: left; min-width: auto; }
    .promo-row { flex-direction: column; }
    .btn-use-promo { width: 100%; }
  }
</style>
@endsection

@section('content')
<div class="checkout-page">

  {{-- BREADCRUMB --}}
  <div class="container breadcrumb-wrap">
    <div class="breadcrumb-custom">
      <a href="{{ route('home') }}">Home</a> &rsaquo;
      <a href="{{ route('marketplace') }}">Marketplace</a> &rsaquo;
      <span>Detail Produk</span>
    </div>
  </div>

  <div class="container" style="max-width: 980px;">
    {{-- JUDUL HALAMAN --}}
    <h1 class="checkout-title">Checkout</h1>

    @if($carts->isEmpty())
      <div class="summary-card text-center py-5">
        <i class="fas fa-shopping-cart mb-3" style="font-size: 4rem; color: #ccc;"></i>
        <h3 class="fw-bold">Keranjang Belanja Kosong</h3>
        <p class="text-muted mb-4">Anda belum memiliki produk di dalam keranjang untuk di-checkout.</p>
        <a href="{{ route('marketplace') }}" class="btn btn-checkout-submit mx-auto" style="max-width: 260px;">
          Jelajahi Produk
        </a>
      </div>
    @else
      {{-- PRODUK DALAM KERANJANG --}}
      <h2 class="section-subheading">Produk dalam Keranjang</h2>

      <div class="cart-items-container">
        @foreach($carts as $cart)
          <div class="cart-item-row" id="cart-row-{{ $cart->id }}">
            {{-- KIRI: GAMBAR & NAMA --}}
            <div class="cart-item-left">
              <img
                src="{{ $cart->product->image ?? 'https://via.placeholder.com/150x150?text=Produk' }}"
                class="cart-item-img"
                alt="{{ $cart->product->name }}"
              >
              <div>
                <h3 class="cart-item-name">{{ $cart->product->name }}</h3>
                <div class="cart-item-seller">
                  {{ $cart->product->umkm->name ?? 'UMKM Tanjungpinang' }}
                </div>
              </div>
            </div>

            {{-- TENGAH: KONTROL JUMLAH (+ / -) --}}
            <div class="d-flex align-items-center gap-2">
              <div class="qty-counter">
                <form id="form-qty-dec-{{ $cart->id }}" action="{{ route('cart.update', $cart->id) }}" method="POST" style="display:none;">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="quantity" value="{{ max(1, $cart->quantity - 1) }}">
                </form>

                <button type="button" class="qty-btn" onclick="submitQtyChange('form-qty-dec-{{ $cart->id }}', {{ $cart->quantity }}, -1)">-</button>
                <input type="text" class="qty-input" value="{{ $cart->quantity }}" readonly>

                <form id="form-qty-inc-{{ $cart->id }}" action="{{ route('cart.update', $cart->id) }}" method="POST" style="display:none;">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="quantity" value="{{ min($cart->product->stock, $cart->quantity + 1) }}">
                </form>

                <button type="button" class="qty-btn" onclick="submitQtyChange('form-qty-inc-{{ $cart->id }}', {{ $cart->quantity }}, 1, {{ $cart->product->stock }})">+</button>
              </div>

              {{-- TOMBOL HAPUS --}}
              <form action="{{ route('cart.remove', $cart->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini dari keranjang?');" style="margin:0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-remove-item" title="Hapus">
                  <i class="far fa-trash-alt"></i>
                </button>
              </form>
            </div>

            {{-- KANAN: HARGA SUBTOTAL ITEM --}}
            <div class="cart-item-price">
              Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
            </div>
          </div>
        @endforeach
      </div>

      {{-- INPUT KODE PROMO --}}
      <div class="promo-row">
        <div class="promo-input-wrap">
          <input type="text" id="promoCodeInput" placeholder="Masukkan Kode Promo">
        </div>
        <button type="button" class="btn-use-promo" onclick="applyPromo()">Gunakan</button>
      </div>

      <div id="promoFeedback" style="display:none; margin-top:-24px; margin-bottom:24px; font-weight:600; font-size:0.95rem;"></div>

      {{-- RINGKASAN PESANAN --}}
      <div class="summary-card">
        <h3 class="summary-title">Ringkasan Pesanan</h3>

        <div class="summary-row">
          <span class="label">Subtotal</span>
          <span class="value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>

        <div class="summary-row">
          <span class="label">Ongkos Kirim</span>
          <span class="value text-muted" style="font-size:1.05rem;">Dihitung saat pengiriman</span>
        </div>

        <div class="summary-divider"></div>

        <div class="summary-row total-row">
          <span class="label">Total</span>
          <span class="value" style="color:#105746;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>

        {{-- TOMBOL LANJUT PEMBAYARAN --}}
        <a href="{{ route('checkout') }}" class="btn-checkout-submit">
          Lanjut Pembayaran
        </a>
      </div>
    @endif

  </div>

</div>
@endsection

@section('scripts')
<script>
  function submitQtyChange(formId, currentVal, change, maxStock = 999) {
    if (change === -1 && currentVal <= 1) {
      alert("Jumlah produk minimal 1.");
      return;
    }
    if (change === 1 && currentVal >= maxStock) {
      alert("Jumlah melebihi stok tersedia (" + maxStock + " item).");
      return;
    }
    document.getElementById(formId).submit();
  }

  function applyPromo() {
    const code = document.getElementById('promoCodeInput').value.trim();
    const feedback = document.getElementById('promoFeedback');

    if (!code) {
      feedback.style.display = 'block';
      feedback.style.color = '#dc3545';
      feedback.innerText = 'Harap masukkan kode promo terlebih dahulu.';
      return;
    }

    // Validasi jelas karena sistem voucher backend belum dikonfigurasi
    feedback.style.display = 'block';
    feedback.style.color = '#dc3545';
    feedback.innerText = 'Kode promo "' + code + '" tidak ditemukan atau belum aktif.';
  }
</script>
@endsection
