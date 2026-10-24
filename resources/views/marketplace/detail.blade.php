@extends('layouts.app')

@section('title', $product->name . ' - Detail Produk')

@section('styles')
<style>
  .product-detail-page { background: #FFF7E2; min-height: 85vh; padding-bottom: 70px; }

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

  /* MAIN GALLERY & INFO */
  .main-product-row {
    padding: 10px 0 40px;
  }
  .main-img-wrap {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.04);
    height: 480px;
  }
  .main-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: opacity 0.25s ease;
  }
  .thumb-row {
    display: flex;
    gap: 16px;
    margin-top: 16px;
  }
  .thumb-item {
    flex: 1;
    height: 110px;
    border-radius: 14px;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    background: #ffffff;
    transition: all 0.2s;
  }
  .thumb-item:hover, .thumb-item.active {
    border-color: #105746;
    transform: translateY(-2px);
  }
  .thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  /* INFO SECTION */
  .product-main-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1a1a1a;
    line-height: 1.2;
    margin-bottom: 8px;
    font-family: serif, 'Times New Roman', Times;
  }
  .product-main-price {
    font-size: 2rem;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 24px;
  }
  .product-desc-box {
    font-size: 1.05rem;
    line-height: 1.6;
    color: #444;
    margin-bottom: 36px;
  }

  /* QUANTITY & ACTIONS */
  .purchase-action-row {
    display: flex;
    gap: 16px;
    align-items: stretch;
    flex-wrap: wrap;
  }
  .qty-counter {
    display: inline-flex;
    align-items: center;
    background: #ffffff;
    border: 1.5px solid #d5d5d5;
    border-radius: 12px;
    height: 52px;
    min-width: 150px;
    padding: 0 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
  }
  .qty-btn {
    background: transparent;
    border: none;
    font-size: 1.4rem;
    font-weight: 600;
    color: #333;
    cursor: pointer;
    width: 36px;
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
    font-size: 1.2rem;
    font-weight: 700;
    color: #1a1a1a;
    outline: none;
    width: 50px;
  }

  .btn-action-col {
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex: 1;
    min-width: 240px;
  }
  .btn-tambah-keranjang {
    background: #105746;
    color: #ffffff;
    border: none;
    border-radius: 12px;
    height: 52px;
    font-size: 1.05rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
    box-shadow: 0 4px 14px rgba(16,87,70,0.25);
  }
  .btn-tambah-keranjang:hover {
    background: #0d4538;
    color: #ffffff;
  }
  .btn-beli-sekarang {
    background: #ffffff;
    color: #105746;
    border: 2px solid #105746;
    border-radius: 12px;
    height: 52px;
    font-size: 1.05rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s;
  }
  .btn-beli-sekarang:hover {
    background: #105746;
    color: #ffffff;
  }

  /* SPECS BADGES / BOXES */
  .spec-badges-row {
    display: flex;
    gap: 16px;
    margin-top: 36px;
    flex-wrap: wrap;
  }
  .spec-badge-box {
    background: #ffffff;
    border-radius: 14px;
    padding: 16px 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    flex: 1;
    min-width: 140px;
  }
  .spec-badge-label {
    font-size: 0.8rem;
    color: #888;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
  }
  .spec-badge-value {
    font-size: 1rem;
    font-weight: 700;
    color: #1a1a1a;
  }

  /* REVIEW & DETAIL EXPANDED BOX */
  .detail-extra-box {
    background: #ffffff;
    border-radius: 20px;
    padding: 28px;
    margin-top: 24px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.05);
  }
  .detail-extra-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 16px;
  }

  /* RELATED PRODUCTS */
  .related-section {
    padding-top: 40px;
  }
  .related-title {
    font-size: 2rem;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 24px;
    font-family: serif, 'Times New Roman', Times;
  }
  .related-card {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    transition: transform 0.22s, box-shadow 0.22s;
    height: 100%;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    border: 1px solid rgba(0,0,0,0.04);
  }
  .related-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
  }
  .related-card-img-wrap {
    padding: 14px 14px 0 14px;
  }
  .related-card-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 14px;
    display: block;
  }
  .related-card-body {
    padding: 16px 18px 20px;
  }
  .related-card-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 6px;
  }
  .related-card-price {
    font-size: 1.15rem;
    font-weight: 700;
    color: #C18A32;
  }

  @media (max-width: 767px) {
    .main-img-wrap { height: 320px; }
    .thumb-item { height: 80px; }
    .product-main-title { font-size: 1.8rem; }
    .product-main-price { font-size: 1.6rem; }
    .purchase-action-row { flex-direction: column; }
    .qty-counter { width: 100%; }
  }
</style>
@endsection

@section('content')
<div class="product-detail-page">

  {{-- BREADCRUMB --}}
  <div class="container breadcrumb-wrap">
    <div class="breadcrumb-custom">
      <a href="{{ route('home') }}">Home</a> &rsaquo;
      <a href="{{ route('marketplace') }}">Marketplace</a> &rsaquo;
      <span>Detail Produk</span>
    </div>
  </div>

  <div class="container">
    {{-- BARIS UTAMA DETAIL PRODUK --}}
    <div class="row g-5 main-product-row">
      {{-- KOLOM GAMBAR (KIRI) --}}
      <div class="col-lg-6">
        <div class="main-img-wrap">
          <img
            id="mainProductImg"
            src="{{ $product->image ?? 'https://via.placeholder.com/600x600?text=Produk' }}"
            class="main-img"
            alt="{{ $product->name }}"
          >
        </div>

        {{-- THUMBNAILS (Jika ada) --}}
        <div class="thumb-row">
          <div class="thumb-item active" onclick="switchImage('{{ $product->image ?? 'https://via.placeholder.com/600x600?text=Produk' }}', this)">
            <img src="{{ $product->image ?? 'https://via.placeholder.com/200x200?text=Produk' }}" alt="{{ $product->name }}">
          </div>
          {{-- Alternatif thumbnail jika ada data gambar lain --}}
          @if(isset($product->gallery) && is_array($product->gallery))
            @foreach($product->gallery as $imgUrl)
              <div class="thumb-item" onclick="switchImage('{{ $imgUrl }}', this)">
                <img src="{{ $imgUrl }}" alt="{{ $product->name }}">
              </div>
            @endforeach
          @endif
        </div>
      </div>

      {{-- KOLOM INFORMASI & BELI (KANAN) --}}
      <div class="col-lg-6 d-flex flex-column justify-content-center">
        <h1 class="product-main-title">{{ $product->name }}</h1>
        <div class="product-main-price">
          Rp {{ number_format($product->price, 0, ',', '.') }}
        </div>

        <div class="product-desc-box">
          {{ $product->description ?: 'Produk khas unggulan UMKM Kota Tanjungpinang dengan kualitas terbaik yang memadukan warisan seni tradisional dan sentuhan modern.' }}
        </div>

        {{-- FORM PEMBELIAN --}}
        @auth
          @if($product->stock > 0)
            <form id="purchaseForm" method="POST" action="{{ route('cart.add', $product->id) }}">
              @csrf
              <div class="purchase-action-row">
                {{-- KONTROL JUMLAH (+ / -) --}}
                <div class="qty-counter">
                  <button type="button" class="qty-btn" onclick="decreaseQty()">-</button>
                  <input type="number" id="qtyInput" name="quantity" class="qty-input" value="1" min="1" max="{{ $product->stock }}" readonly>
                  <button type="button" class="qty-btn" onclick="increaseQty({{ $product->stock }})">+</button>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="btn-action-col">
                  <button type="submit" class="btn-tambah-keranjang">
                    Tambah ke Keranjang
                  </button>
                  <button type="button" class="btn-beli-sekarang" onclick="buyNow('{{ route('buy-now', $product->id) }}')">
                    Beli Sekarang
                  </button>
                </div>
              </div>
            </form>
          @else
            <div class="alert alert-warning py-3 rounded-4">
              <strong>Stok Habis!</strong> Produk ini sedang tidak tersedia untuk saat ini.
            </div>
          @endif
        @else
          <div class="purchase-action-row">
            <div class="btn-action-col">
              <a href="{{ route('login') }}" class="btn-tambah-keranjang">
                Login untuk Membeli
              </a>
            </div>
          </div>
        @endauth

        {{-- INFO SPESIFIKASI TAMBAHAN --}}
        <div class="spec-badges-row">
          <div class="spec-badge-box">
            <div class="spec-badge-label">Penjual / UMKM</div>
            <div class="spec-badge-value">{{ $product->umkm->name ?? 'UMKM Tanjungpinang' }}</div>
          </div>
          <div class="spec-badge-box">
            <div class="spec-badge-label">Kategori</div>
            <div class="spec-badge-value">{{ $product->category->name ?? 'Lokal' }}</div>
          </div>
          <div class="spec-badge-box">
            <div class="spec-badge-label">Ketersediaan</div>
            <div class="spec-badge-value text-success">
              {{ $product->stock > 0 ? $product->stock . ' Tersedia' : 'Habis' }}
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- DETAIL & ULASAN PRODUK --}}
    <div class="detail-extra-box">
      <h3 class="detail-extra-title">Informasi Produk &amp; Toko</h3>
      <p class="text-muted mb-4">
        {{ $product->description }}
      </p>

      <hr class="my-4" style="border-color:#eee;">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="h5 fw-bold mb-0">Ulasan Pembeli ({{ $product->reviewCount() }})</h4>
        <a href="{{ route('reviews.index', $product->id) }}" class="text-decoration-none" style="color:#105746;font-weight:600;">
          Lihat Semua
        </a>
      </div>

      @if($product->reviews->count() > 0)
        <div class="row g-3">
          @foreach($product->reviews->take(2) as $review)
            <div class="col-md-6">
              <div class="p-3 rounded-3" style="background:#fdfcf7;border:1px solid #eee;">
                <div class="d-flex justify-content-between mb-1">
                  <strong>{{ $review->user->name }}</strong>
                  <span style="color:#FFB81C;"><i class="fas fa-star"></i> {{ $review->rating }}</span>
                </div>
                <p class="mb-1 text-muted small">{{ $review->comment }}</p>
                <small class="text-muted" style="font-size:0.75rem;">{{ $review->created_at->diffForHumans() }}</small>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <p class="text-muted small mb-0">Belum ada ulasan untuk produk ini.</p>
      @endif
    </div>

    {{-- PRODUK TERKAIT --}}
    @php
      $relatedProducts = \App\Models\Product::where('status', 'active')
        ->where('id', '!=', $product->id)
        ->when($product->category_id, fn($q) => $q->where('category_id', $product->category_id))
        ->take(3)
        ->get();

      // Fallback jika belum ada yang sekategori
      if($relatedProducts->isEmpty()) {
        $relatedProducts = \App\Models\Product::where('status', 'active')
          ->where('id', '!=', $product->id)
          ->take(3)
          ->get();
      }
    @endphp

    <div class="related-section">
      <h2 class="related-title">Produk Terkait</h2>

      @if($relatedProducts->count() > 0)
        <div class="row g-4">
          @foreach($relatedProducts as $rel)
            <div class="col-md-4">
              <a href="{{ route('products.detail', $rel->slug) }}" class="related-card">
                <div class="related-card-img-wrap">
                  <img
                    src="{{ $rel->image ?? 'https://via.placeholder.com/400x250?text=Produk' }}"
                    class="related-card-img"
                    alt="{{ $rel->name }}"
                  >
                </div>
                <div class="related-card-body">
                  <div class="related-card-title">{{ $rel->name }}</div>
                  <div class="related-card-price">
                    Rp {{ number_format($rel->price, 0, ',', '.') }}
                  </div>
                </div>
              </a>
            </div>
          @endforeach
        </div>
      @else
        <p class="text-muted">Tidak ada produk terkait saat ini.</p>
      @endif
    </div>

  </div>

</div>
@endsection

@section('scripts')
<script>
  function switchImage(src, element) {
    const mainImg = document.getElementById('mainProductImg');
    mainImg.style.opacity = '0.4';
    setTimeout(() => {
      mainImg.src = src;
      mainImg.style.opacity = '1';
    }, 150);

    document.querySelectorAll('.thumb-item').forEach(el => el.classList.remove('active'));
    element.classList.add('active');
  }

  function decreaseQty() {
    const input = document.getElementById('qtyInput');
    let val = parseInt(input.value) || 1;
    if (val > 1) {
      input.value = val - 1;
    }
  }

  function increaseQty(maxStock) {
    const input = document.getElementById('qtyInput');
    let val = parseInt(input.value) || 1;
    if (val < maxStock) {
      input.value = val + 1;
    }
  }

  function buyNow(action) {
    const quantity = document.getElementById('qtyInput').value;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = action;
    form.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="quantity" value="${quantity}">`;
    document.body.appendChild(form);
    form.submit();
  }
</script>
@endsection
