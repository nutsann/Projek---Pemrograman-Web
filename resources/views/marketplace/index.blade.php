@extends('layouts.app')

@section('title', 'Marketplace UMKM Lokal')

@section('styles')
<style>
  .marketplace-page { background: #FFF7E2; min-height: 85vh; padding-bottom: 60px; }

  /* HEADER */
  .market-header {
    background: #FFF7E2;
    padding: 40px 0 20px;
  }
  .breadcrumb-custom {
    font-size: 0.85rem;
    color: #888;
    margin-bottom: 14px;
  }
  .breadcrumb-custom a { color: #105746; text-decoration: none; }
  .breadcrumb-custom a:hover { text-decoration: underline; }
  .market-header h1 {
    font-size: 2.6rem;
    font-weight: 800;
    color: #1a1a1a;
    line-height: 1.2;
    margin-bottom: 10px;
    font-family: serif, 'Times New Roman', Times;
  }
  .market-header p {
    font-size: 1.05rem;
    color: #555;
    margin-bottom: 0;
  }

  /* SEARCH & DROPDOWN ROW */
  .market-search-row {
    padding: 10px 0 20px;
  }
  .search-input-wrap {
    display: flex;
    background: #ffffff;
    border-radius: 12px;
    border: 1.5px solid #d5d5d5;
    overflow: hidden;
    height: 52px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
  }
  .search-input-wrap input {
    flex: 1;
    border: none;
    padding: 0 20px;
    font-size: 0.95rem;
    outline: none;
    background: transparent;
  }
  .search-input-wrap button {
    background: #105746;
    color: #ffffff;
    border: none;
    padding: 0 24px;
    font-size: 1.05rem;
    cursor: pointer;
    transition: background 0.2s;
  }
  .search-input-wrap button:hover {
    background: #0d4538;
  }

  /* DROPDOWN SELECT */
  .custom-dropdown-wrap {
    position: relative;
    height: 52px;
  }
  .custom-dropdown-wrap select {
    width: 100%;
    height: 100%;
    background: #ffffff;
    border: 1.5px solid #d5d5d5;
    border-radius: 12px;
    padding: 0 40px 0 20px;
    font-size: 0.95rem;
    font-weight: 600;
    color: #1a1a1a;
    outline: none;
    appearance: none;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
  }
  .custom-dropdown-wrap::after {
    content: "\f078";
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: #222;
    font-size: 0.85rem;
  }

  /* FILTER BUTTONS ROW */
  .filter-bar {
    background: transparent;
    padding: 0 0 32px;
  }
  .filter-inner {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
  }
  .filter-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 120px;
    height: 46px;
    padding: 0 28px;
    border-radius: 999px;
    border: 1.5px solid #d5d5d5;
    background: #ffffff;
    color: #222;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.18s;
    white-space: nowrap;
    box-shadow: 0 2px 6px rgba(0,0,0,0.03);
  }
  .filter-btn:hover {
    border-color: #105746;
    color: #105746;
  }
  .filter-btn.active {
    background: #105746;
    color: #ffffff;
    border-color: #105746;
    box-shadow: 0 4px 12px rgba(16,87,70,0.25);
  }

  /* GRID PRODUK (3 Kolom Desktop) */
  .product-grid {
    padding-top: 6px;
  }
  .product-card {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(0,0,0,0.06);
    transition: transform 0.22s, box-shadow 0.22s;
    display: flex;
    flex-direction: column;
    height: 100%;
    border: 1px solid rgba(0,0,0,0.04);
  }
  .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 28px rgba(0,0,0,0.12);
  }
  .product-card-img-wrap {
    padding: 16px 16px 0 16px;
  }
  .product-card-img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 14px;
    display: block;
  }
  .product-card-body {
    padding: 18px 20px 20px;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 12px;
    flex: 1;
  }
  .product-info {
    flex: 1;
  }
  .product-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 6px;
    line-height: 1.3;
    text-decoration: none;
    display: block;
  }
  .product-title:hover {
    color: #105746;
  }
  .product-price {
    font-size: 1.2rem;
    font-weight: 700;
    color: #C18A32;
    margin: 0;
  }
  .btn-cart-add {
    background: #105746;
    color: #ffffff;
    border: none;
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
    flex-shrink: 0;
  }
  .btn-cart-add:hover {
    background: #0d4538;
    color: #ffffff;
    transform: scale(1.05);
  }

  /* EMPTY STATE */
  .empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #888;
  }
  .empty-state i {
    font-size: 3.5rem;
    margin-bottom: 16px;
    color: #ccc;
  }

  /* PAGINATION */
  .pagination .page-link { color: #105746; }
  .pagination .page-item.active .page-link { background: #105746; border-color: #105746; color: #fff; }

  @media (max-width: 991px) {
    .product-card-img { height: 190px; }
  }
  @media (max-width: 767px) {
    .market-header h1 { font-size: 2rem; }
    .filter-inner { gap: 10px; }
    .filter-btn { min-width: 90px; height: 40px; padding: 0 18px; font-size: 0.88rem; }
    .search-input-wrap, .custom-dropdown-wrap { height: 46px; }
  }
</style>
@endsection

@section('content')
<div class="marketplace-page">

  {{-- HEADER --}}
  <div class="market-header">
    <div class="container">
      <div class="breadcrumb-custom">
        <a href="{{ route('home') }}">Home</a> &rsaquo; <span>Marketplace</span>
      </div>
      <h1>Produk<br>UMKM Lokal</h1>
      <p>Sejumlah produk budaya dan UMKM Tanjungpinang</p>
    </div>
  </div>

  <div class="container">
    {{-- SEARCH & DROPDOWN ROW --}}
    <div class="market-search-row">
      <div class="row g-3">
        <div class="col-md-7 col-lg-8">
          <form action="{{ route('marketplace') }}" method="GET" class="search-input-wrap">
            @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
            @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
            <input type="text" name="search" placeholder="Cari Produk" value="{{ request('search') }}">
            <button type="submit"><i class="fas fa-search"></i></button>
          </form>
        </div>
        <div class="col-md-5 col-lg-4">
          <div class="custom-dropdown-wrap">
            <select onchange="window.location.href=this.value;">
              <option value="{{ route('marketplace', array_merge(request()->except('category', 'page'))) }}">Kategori Produk</option>
              @foreach($categories as $cat)
                <option value="{{ route('marketplace', array_merge(request()->except('page'), ['category' => $cat->slug])) }}"
                  {{ request('category') == $cat->slug ? 'selected' : '' }}>
                  {{ $cat->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>

    {{-- FILTER BUTTONS ROW --}}
    <div class="filter-bar">
      <div class="filter-inner">
        <button class="filter-btn {{ request('category', 'semua') === 'semua' ? 'active' : '' }}" data-category="semua">Semua</button>
        <button class="filter-btn" data-category="kuliner">Kuliner</button>
        <button class="filter-btn" data-category="fashion">Fashion</button>
        <button class="filter-btn" data-category="umkm">UMKM</button>
        <button class="filter-btn" data-category="souvenir">Souvenir</button>
      </div>
    </div>

    {{-- GRID PRODUK (3 Kolom Desktop) --}}
    <div class="product-grid">
      <div class="row g-4" id="product-grid">
        @forelse($products as $product)
          <div class="col-md-6 col-lg-4 product-item"
               data-name="{{ strtolower($product->name) }}"
               data-cat="{{ strtolower($product->category->name ?? '') }}"
               data-desc="{{ strtolower($product->description ?? '') }}">
            <div class="product-card">
              <div class="product-card-img-wrap">
                <a href="{{ route('products.detail', $product->slug) }}">
                  <img
                    src="{{ $product->image ?? 'https://via.placeholder.com/400x250?text=Produk' }}"
                    class="product-card-img"
                    alt="{{ $product->name }}"
                  >
                </a>
              </div>
              <div class="product-card-body">
                <div class="product-info">
                  <a href="{{ route('products.detail', $product->slug) }}" class="product-title">
                    {{ $product->name }}
                  </a>
                  <div class="product-price">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                  </div>
                </div>

                {{-- FORM TOMBOL KERANJANG --}}
                @auth
                  <form action="{{ route('cart.add', $product->id) }}" method="POST" style="margin:0;">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn-cart-add" title="Tambah ke Keranjang">
                      <i class="fas fa-shopping-cart"></i>
                    </button>
                  </form>
                @else
                  <a href="{{ route('login') }}" class="btn-cart-add" title="Login untuk Beli">
                    <i class="fas fa-shopping-cart"></i>
                  </a>
                @endauth
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <div class="empty-state">
              <i class="fas fa-box-open d-block"></i>
              <p>Tidak ada produk yang ditemukan.</p>
            </div>
          </div>
        @endforelse
      </div>

      {{-- EMPTY STATE FILTER --}}
      <div id="no-result" class="empty-state" style="display:none;">
        <i class="fas fa-box-open d-block"></i>
        <p>Tidak ada produk dalam kategori ini.</p>
      </div>

      {{-- PAGINATION --}}
      <div class="d-flex justify-content-center mt-5">
        {{ $products->links() }}
      </div>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script>
  const filterBtns = document.querySelectorAll('.filter-btn');
  const items = document.querySelectorAll('.product-item');
  const noResult = document.getElementById('no-result');

  // Mapping kata kunci kategori produk
  const categoryKeywords = {
    kuliner: ['kuliner', 'gonggong', 'luti', 'gendang', 'makanan', 'minuman', 'kue', 'kerupuk', 'sambal', 'otak-otak', 'kopi', 'teh'],
    fashion: ['fashion', 'tenun', 'kain', 'batik', 'baju', 'pakaian', 'songket', 'tanjak', 'selendang'],
    umkm: ['umkm', 'kerajinan', 'anyaman', 'tas', 'dompet', 'lokal', 'rotan', 'pandan'],
    souvenir: ['souvenir', 'miniatur', 'kapal', 'gantungan', 'cinderamata', 'plakat', 'hiasan', 'oleholeh', 'oleh-oleh']
  };

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const params = new URLSearchParams(window.location.search);
      params.set('category', btn.dataset.category);
      params.delete('page');
      window.location.href = `${window.location.pathname}?${params.toString()}`;
      return;
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const cat = btn.dataset.category;
      let visible = 0;

      items.forEach(item => {
        if (cat === 'semua') {
          item.style.display = '';
          visible++;
          return;
        }

        const name = item.dataset.name;
        const itemCat = item.dataset.cat;
        const desc = item.dataset.desc;
        const keywords = categoryKeywords[cat] || [cat];

        const match = keywords.some(kw => name.includes(kw) || itemCat.includes(kw) || desc.includes(kw));

        if (match) {
          item.style.display = '';
          visible++;
        } else {
          item.style.display = 'none';
        }
      });

      noResult.style.display = visible === 0 ? 'block' : 'none';
    });
  });
</script>
@endsection
