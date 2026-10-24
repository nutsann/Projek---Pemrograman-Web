@extends('layouts.app')

@section('title', 'Konfirmasi Pengiriman & Pembayaran')

@section('styles')
<style>
  .shipping-page { background: #FFF7E2; min-height: 85vh; padding-bottom: 70px; }

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
  .page-main-title {
    font-size: 2.4rem;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 24px;
    font-family: serif, 'Times New Roman', Times;
  }

  /* PANEL PUTIH */
  .custom-panel-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 28px;
    margin-bottom: 24px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.04);
    border: 1px solid rgba(0,0,0,0.04);
  }
  .panel-heading {
    font-size: 1.25rem;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .panel-heading i {
    color: #105746;
  }

  /* INPUTS */
  .form-label-custom {
    font-weight: 700;
    font-size: 0.9rem;
    color: #333333;
    margin-bottom: 6px;
  }
  .form-control-custom {
    width: 100%;
    border: 1.5px solid #d5d5d5;
    border-radius: 10px;
    padding: 10px 16px;
    font-size: 0.95rem;
    outline: none;
    transition: border-color 0.2s;
  }
  .form-control-custom:focus {
    border-color: #105746;
    box-shadow: 0 0 0 3px rgba(16,87,70,0.1);
  }

  /* ITEM ROW */
  .checkout-item-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #f2f2f2;
    gap: 16px;
  }
  .checkout-item-row:last-child {
    border-bottom: none;
  }
  .item-thumb {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    object-fit: cover;
    flex-shrink: 0;
  }
  .item-title {
    font-weight: 700;
    font-size: 1rem;
    color: #1a1a1a;
    margin-bottom: 2px;
  }
  .item-seller {
    font-size: 0.8rem;
    color: #888;
  }
  .item-qty-price {
    font-size: 0.9rem;
    color: #666;
  }
  .item-subtotal {
    font-weight: 800;
    font-size: 1.05rem;
    color: #1a1a1a;
    text-align: right;
  }

  /* RINGKASAN TOTAL */
  .summary-calc-row {
    display: flex;
    justify-content: space-between;
    font-size: 1.05rem;
    margin-bottom: 10px;
    color: #444;
  }
  .summary-calc-row.total-bold {
    font-size: 1.35rem;
    font-weight: 800;
    color: #105746;
    margin-top: 14px;
    padding-top: 14px;
    border-top: 1.5px dashed #e0e0e0;
  }

  /* BUTTONS */
  .btn-submit-order {
    background: #105746;
    color: #ffffff;
    border: none;
    border-radius: 12px;
    height: 52px;
    font-size: 1.1rem;
    font-weight: 700;
    width: 100%;
    cursor: pointer;
    transition: background 0.2s;
    box-shadow: 0 4px 14px rgba(16,87,70,0.25);
  }
  .btn-submit-order:hover {
    background: #0d4538;
  }
  .btn-back-cart {
    background: transparent;
    border: 1.5px solid #d5d5d5;
    color: #555;
    border-radius: 12px;
    height: 52px;
    font-size: 1rem;
    font-weight: 600;
    padding: 0 24px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.2s;
  }
  .btn-back-cart:hover {
    border-color: #105746;
    color: #105746;
    background: #ffffff;
  }
</style>
@endsection

@section('content')
<div class="shipping-page">

  {{-- BREADCRUMB --}}
  <div class="container breadcrumb-wrap">
    <div class="breadcrumb-custom">
      <a href="{{ route('home') }}">Home</a> &rsaquo;
      <a href="{{ route('cart.index') }}">Keranjang</a> &rsaquo;
      <span>Data Pengiriman</span>
    </div>
  </div>

  <div class="container" style="max-width: 980px;">
    <h1 class="page-main-title">Data Pengiriman &amp; Pembayaran</h1>

    @if(session('error'))
      <div class="alert alert-danger rounded-4 mb-4">
        {{ session('error') }}
      </div>
    @endif

    <form method="POST" action="{{ route('checkout.process') }}">
      @csrf

      <div class="row g-4">
        {{-- KOLOM KIRI: FORM ALAMAT PENGIRIMAN --}}
        <div class="col-lg-7">
          <div class="custom-panel-card">
            <div class="panel-heading">
              <i class="fas fa-map-marker-alt"></i> Alamat &amp; Penerima
            </div>

            <div class="mb-3">
              <label class="form-label-custom">Nama Lengkap Penerima</label>
              <input
                type="text"
                name="shipping_name"
                class="form-control-custom @error('shipping_name') is-invalid @enderror"
                value="{{ old('shipping_name', Auth::user()->name) }}"
                placeholder="Contoh: Budi Santoso"
                required
              >
              @error('shipping_name')
                <div class="text-danger small mt-1 fw-bold">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label-custom">Nomor Telepon / WhatsApp</label>
              <input
                type="tel"
                name="shipping_phone"
                class="form-control-custom @error('shipping_phone') is-invalid @enderror"
                value="{{ old('shipping_phone', Auth::user()->phone) }}"
                placeholder="Contoh: 081234567890"
                required
              >
              @error('shipping_phone')
                <div class="text-danger small mt-1 fw-bold">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label class="form-label-custom">Alamat Lengkap Pengiriman</label>
              <textarea
                name="shipping_address"
                class="form-control-custom @error('shipping_address') is-invalid @enderror"
                rows="3"
                placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan di Tanjungpinang"
                required
              >{{ old('shipping_address', Auth::user()->address) }}</textarea>
              @error('shipping_address')
                <div class="text-danger small mt-1 fw-bold">{{ $message }}</div>
              @enderror
            </div>

             <div class="mb-3">
               <label class="form-label-custom">Area Pengiriman</label>
               <select name="shipping_area" class="form-control-custom @error('shipping_area') is-invalid @enderror" required>
                 <option value="">Pilih area pengiriman</option>
                 <option value="tanjungpinang" @selected(old('shipping_area') === 'tanjungpinang')>Tanjungpinang — Gratis</option>
                 <option value="kijang" @selected(old('shipping_area') === 'kijang')>Kijang — Rp 10.000</option>
                 <option value="bintan_lainnya" @selected(old('shipping_area') === 'bintan_lainnya')>Bintan lainnya — Rp 15.000</option>
                 <option value="luar_daerah" @selected(old('shipping_area') === 'luar_daerah')>Luar daerah — Rp 30.000</option>
               </select>
               @error('shipping_area')
                 <div class="text-danger small mt-1 fw-bold">{{ $message }}</div>
               @enderror
             </div>

             <div class="mb-3">
               <label class="form-label-custom">Metode Pembayaran</label>
               <select name="payment_method" class="form-control-custom @error('payment_method') is-invalid @enderror" required>
                 <option value="">Pilih metode pembayaran</option>
                 <option value="cod" @selected(old('payment_method') === 'cod')>COD (Bayar di Tempat)</option>
                 <option value="bank_transfer" @selected(old('payment_method') === 'bank_transfer')>Transfer Bank</option>
                 <option value="qris" @selected(old('payment_method') === 'qris')>QRIS</option>
               </select>
               @error('payment_method')
                 <div class="text-danger small mt-1 fw-bold">{{ $message }}</div>
               @enderror
             </div>

             <div class="mb-0">
               <label class="form-label-custom">Catatan untuk Penjual (Opsional)</label>
              <textarea
                name="notes"
                class="form-control-custom"
                rows="2"
                placeholder="Contoh: Mohon dikirim dalam kemasan rapi"
              >{{ old('notes') }}</textarea>
            </div>
          </div>
        </div>

        {{-- KOLOM KANAN: RINGKASAN PESANAN & PEMBAYARAN --}}
        <div class="col-lg-5">
          <div class="custom-panel-card">
            <div class="panel-heading">
              <i class="fas fa-shopping-bag"></i> Rincian Produk
            </div>

            <div class="checkout-items-list mb-3">
              @foreach($carts as $cart)
                <div class="checkout-item-row">
                  <img
                    src="{{ $cart->product->image ?? 'https://via.placeholder.com/80x80?text=Produk' }}"
                    class="item-thumb"
                    alt="{{ $cart->product->name }}"
                  >
                  <div style="flex:1;">
                    <div class="item-title">{{ $cart->product->name }}</div>
                    <div class="item-seller">{{ $cart->product->umkm->name ?? 'UMKM' }}</div>
                    <div class="item-qty-price">{{ $cart->quantity }} x Rp {{ number_format($cart->product->price, 0, ',', '.') }}</div>
                  </div>
                  <div class="item-subtotal">
                    Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                  </div>
                </div>
              @endforeach
            </div>

            <div class="summary-calc-row">
              <span>Subtotal Produk</span>
              <span class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>

            <div class="summary-calc-row">
              <span>Biaya Pengiriman</span>
               <span id="shipping-cost-label" class="text-muted fw-bold">Pilih area</span>
            </div>

            <div class="summary-calc-row total-bold">
              <span>Total Pembayaran</span>
              <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>

            <div class="mt-4 d-flex gap-2">
              <a href="{{ route('cart.index') }}" class="btn-back-cart" title="Kembali">
                <i class="fas fa-arrow-left"></i>
              </a>
              <button type="submit" class="btn-submit-order flex-grow-1">
                Konfirmasi &amp; Buat Pesanan
              </button>
            </div>
          </div>
        </div>
      </div>

    </form>
  </div>

</div>

@push('scripts')
<script>
  const areaCosts = { tanjungpinang: 0, kijang: 10000, bintan_lainnya: 15000, luar_daerah: 30000 };
  const areaSelect = document.querySelector('[name="shipping_area"]');
  const shippingLabel = document.getElementById('shipping-cost-label');
  const totalLabel = document.querySelector('.total-bold span:last-child');
  const subtotal = {{ $subtotal }};

  areaSelect?.addEventListener('change', function () {
    const cost = areaCosts[this.value];
    shippingLabel.textContent = cost === undefined ? 'Pilih area' : `Rp ${cost.toLocaleString('id-ID')}`;
    if (cost !== undefined) totalLabel.textContent = `Rp ${(subtotal + cost).toLocaleString('id-ID')}`;
  });
</script>
@endpush
@endsection
