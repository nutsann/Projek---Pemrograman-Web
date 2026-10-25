@extends('layouts.app')

@section('title', 'Beranda')

@section('styles')
<style>
  /* ── HERO ── */
  .hero-section {
    position: relative;
    min-height: 600px;
    background-image: url('/images/hero-dompak.jpg');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    overflow: hidden;
  }
  .hero-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.38);
    z-index: 1;
  }
  .hero-content {
    position: relative;
    z-index: 2;
    color: #fff;
    text-align: left;
    width: 100%;
    padding: 110px 0 90px;
  }
  .hero-content h1 {
    font-size: 2.8rem;
    font-weight: 800;
    margin-bottom: 10px;
    text-shadow: 0 2px 14px rgba(0,0,0,0.55);
    max-width: 640px;
    line-height: 1.2;
  }
  .hero-content .hero-subtitle {
    font-size: 1.2rem;
    font-weight: 500;
    color: #C18A32;
    margin-bottom: 14px;
  }
  .hero-content .hero-desc {
    font-size: 1rem;
    opacity: 0.9;
    margin-bottom: 28px;
    max-width: 520px;
  }
  .hero-search {
    max-width: 500px;
    margin: 0 0 28px;
    display: flex;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.25);
  }
  .hero-search input {
    flex: 1;
    border: none;
    padding: 13px 18px;
    font-size: 0.95rem;
    outline: none;
  }
  .hero-search button {
    background: #C18A32;
    color: #fff;
    border: none;
    padding: 13px 20px;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.2s;
  }
  .hero-search button:hover { background: #a87428; }
  .hero-search-wrap { position: relative; max-width: 500px; }
  .hero-search-wrap .hero-search { max-width: none; }
  .quick-results {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    right: 0;
    z-index: 20;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
    overflow: hidden;
    display: none;
    text-align: left;
  }
  .quick-result { display:flex; align-items:center; gap:10px; padding:10px 14px; color:#222; text-decoration:none; border-bottom:1px solid #eee; }
  .quick-result:hover { background:#FFF7E2; color:#105746; }
  .quick-result img { width:42px; height:42px; object-fit:cover; border-radius:7px; background:#eee; }
  .quick-result small { display:block; color:#888; font-size:.72rem; }
  .hero-actions .btn { margin: 4px; }

  /* ── JELAJAHI LEBIH BANYAK ── */
  .explore-section {
    background: #fff;
    padding: 48px 0 40px;
  }
  .explore-section .section-left-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #105746;
    margin-bottom: 28px;
  }
  .explore-grid {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
  }
  .explore-item {
    flex: 1 1 0;
    min-width: 120px;
    background: #FFF7E2;
    border-radius: 14px;
    padding: 24px 12px 18px;
    text-align: center;
    text-decoration: none;
    color: #1a1a1a;
    transition: box-shadow 0.2s, transform 0.2s;
    border: 1.5px solid #eee;
  }
  .explore-item:hover {
    box-shadow: 0 6px 20px rgba(16,87,70,0.13);
    transform: translateY(-4px);
    color: #105746;
    border-color: #105746;
  }
  .explore-item .explore-icon {
    font-size: 2rem;
    margin-bottom: 10px;
    color: #105746;
  }
  .explore-item span {
    display: block;
    font-size: 0.88rem;
    font-weight: 600;
  }

  /* ── DESTINASI POPULER ── */
  .destinasi-section {
    background: #FFF7E2;
    padding: 48px 0 52px;
  }
  .section-left-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #105746;
    margin-bottom: 24px;
  }
  .destinasi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
  }
  .destinasi-card {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    height: 200px;
    cursor: pointer;
    text-decoration: none;
  }
  .destinasi-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
  }
  .destinasi-card:hover img { transform: scale(1.06); }
  .destinasi-card .dest-label {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.65));
    color: #fff;
    font-size: 0.88rem;
    font-weight: 600;
    padding: 20px 12px 10px;
  }

  /* ── SECTION UMUM ── */
  .content-section { background-color: #FFF7E2; padding: 52px 0; }
  .content-section-white { background-color: #fff; padding: 52px 0; }
  .map-section { background-color: #FFF7E2; padding: 52px 0; }

  .home-section-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #105746;
    margin-bottom: 28px;
  }
  .home-card {
    background: #fff;
    border: none;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    transition: transform 0.25s, box-shadow 0.25s;
    overflow: hidden;
    height: 100%;
  }
  .home-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
  }
  .home-card .card-img-top {
    height: 200px;
    object-fit: cover;
    width: 100%;
  }
  .home-card .card-body {
    display: flex;
    flex-direction: column;
    padding: 16px 18px 18px;
  }
  .home-card .card-title {
    font-size: 0.97rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 7px;
  }
  .home-card .card-text {
    font-size: 0.85rem;
    color: #666;
    flex-grow: 1;
    margin-bottom: 12px;
  }
  .price-gold { color: #C18A32; font-weight: 700; }
  .btn-lihat {
    background: #105746;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 7px 16px;
    font-size: 0.83rem;
    font-weight: 600;
    align-self: flex-start;
    transition: background 0.2s;
    text-decoration: none;
    display: inline-block;
  }
  .btn-lihat:hover { background: #0d4538; color: #fff; }
  .btn-lihat-all {
    background: #105746;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 28px;
    font-size: 0.93rem;
    font-weight: 600;
    transition: background 0.2s;
    text-decoration: none;
    display: inline-block;
  }
  .btn-lihat-all:hover { background: #0d4538; color: #fff; }

  /* ── RESPONSIVE ── */
  @media (max-width: 991px) {
    .destinasi-grid { grid-template-columns: repeat(2, 1fr); }
  }
  @media (max-width: 767px) {
    .hero-content { text-align: center; padding: 80px 0 60px; }
    .hero-content h1 { font-size: 1.9rem; max-width: 100%; }
    .hero-search { margin: 0 auto 24px; }
    .hero-content .hero-desc { margin-left: auto; margin-right: auto; }
    .explore-item { min-width: 80px; padding: 18px 8px 14px; }
    .destinasi-grid { grid-template-columns: repeat(2, 1fr); }
    .section-left-title, .explore-section .section-left-title { text-align: center; }
  }
  @media (max-width: 480px) {
    .destinasi-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
    .destinasi-card { height: 140px; }
    .explore-grid { gap: 10px; }
  }
</style>
@endsection

@section('content')

{{-- HERO --}}
<section class="hero-section">
  <div class="hero-content">
    <div class="container">
      <h1>Jelajahi Budaya Tanjungpinang</h1>
      <p class="hero-subtitle">Warisan Melayu, Pesona Masa Depan</p>
      <p class="hero-desc">Temukan budaya, destinasi, produk UMKM lokal, dan event menarik dalam satu platform digital.</p>
      <div class="hero-search-wrap">
        <form class="hero-search" action="{{ route('cultures') }}" method="GET">
          <input id="quickSearchInput" type="text" name="search" placeholder="Cari budaya, wisata, atau produk..." autocomplete="off">
          <button type="submit"><i class="fas fa-search"></i></button>
        </form>
        <div id="quickSearchResults" class="quick-results"></div>
      </div>
      <div class="hero-actions">
        <a href="{{ route('cultures') }}" class="btn btn-light btn-lg me-2"><i class="fas fa-landmark me-1"></i>Jelajahi Budaya</a>
        <a href="{{ route('marketplace') }}" class="btn btn-lg" style="background:#C18A32;color:#fff;"><i class="fas fa-shopping-cart me-1"></i>Jelajahi Marketplace</a>
      </div>
    </div>
  </div>
</section>

{{-- JELAJAHI LEBIH BANYAK --}}
<section class="explore-section">
  <div class="container">
    <h2 class="explore-section section-left-title" style="padding:0;background:none;">Jelajahi Lebih Banyak</h2>
    <div class="explore-grid">
      <a href="{{ route('cultures') }}" class="explore-item">
        <div class="explore-icon"><i class="fas fa-masks-theater"></i></div>
        <span>Budaya</span>
      </a>
      <a href="{{ route('tourisms') }}" class="explore-item">
        <div class="explore-icon"><i class="fas fa-mountain-sun"></i></div>
        <span>Wisata</span>
      </a>
      <a href="{{ route('events') }}" class="explore-item">
        <div class="explore-icon"><i class="fas fa-calendar-check"></i></div>
        <span>Event</span>
      </a>
      <a href="{{ route('map') }}" class="explore-item">
        <div class="explore-icon"><i class="fas fa-map-location-dot"></i></div>
        <span>Peta</span>
      </a>
      <a href="{{ route('marketplace') }}" class="explore-item">
        <div class="explore-icon"><i class="fas fa-store"></i></div>
        <span>UMKM</span>
      </a>
    </div>
  </div>
</section>

{{-- DESTINASI POPULER --}}
<section class="destinasi-section">
  <div class="container">
    <h2 class="section-left-title">Destinasi Populer</h2>
    <div class="destinasi-grid">
      @forelse($featured_tourisms->take(4) as $tourism)
        <a href="{{ route('tourisms.detail', $tourism->slug) }}" class="destinasi-card">
          <img src="{{ $tourism->image ?? 'https://via.placeholder.com/400x200?text=Wisata' }}" alt="{{ $tourism->name }}">
          <div class="dest-label">{{ $tourism->name }}</div>
        </a>
      @empty
        <div class="col-12 text-muted">Belum ada destinasi.</div>
      @endforelse
    </div>
    <div class="mt-4">
      <a href="{{ route('tourisms') }}" class="btn-lihat-all">Lihat Semua Wisata</a>
    </div>
  </div>
</section>

{{-- BUDAYA --}}
<section class="content-section-white">
  <div class="container">
    <h2 class="home-section-title">Budaya Tanjungpinang</h2>
    <div class="row g-4">
      @foreach($featured_cultures as $culture)
        <div class="col-md-4 col-sm-6">
          <div class="home-card">
            <img src="{{ $culture->image ?? 'https://via.placeholder.com/400x200?text=Budaya' }}" class="card-img-top" alt="{{ $culture->name }}">
            <div class="card-body">
              <h5 class="card-title">{{ $culture->name }}</h5>
              <p class="card-text">{{ Str::limit($culture->short_description, 100) }}</p>
              <a href="{{ route('cultures.detail', $culture->slug) }}" class="btn-lihat">Lihat Detail</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="mt-4">
      <a href="{{ route('cultures') }}" class="btn-lihat-all">Lihat Semua Budaya</a>
    </div>
  </div>
</section>

{{-- EVENT --}}
<section class="content-section">
  <div class="container">
    <h2 class="home-section-title">Event &amp; Budaya</h2>
    <div class="row g-4">
      @foreach($featured_events as $event)
        <div class="col-md-4 col-sm-6">
          <div class="home-card">
            <img src="{{ $event->image ?? 'https://via.placeholder.com/400x200?text=Event' }}" class="card-img-top" alt="{{ $event->name }}">
            <div class="card-body">
              <h5 class="card-title">{{ $event->name }}</h5>
              <p class="card-text"><i class="fas fa-calendar me-1"></i>{{ $event->start_date->format('d M Y') }}</p>
              <a href="{{ route('events.detail', $event->slug) }}" class="btn-lihat">Lihat Detail</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="mt-4">
      <a href="{{ route('events') }}" class="btn-lihat-all">Lihat Semua Event</a>
    </div>
  </div>
</section>

{{-- PRODUK UMKM --}}
<section class="content-section-white">
  <div class="container">
    <h2 class="home-section-title">Produk UMKM Unggulan</h2>
    <div class="row g-4">
      @foreach($featured_products as $product)
        <div class="col-md-4 col-sm-6">
          <div class="home-card">
            <img src="{{ $product->image ?? 'https://via.placeholder.com/400x200?text=Produk' }}" class="card-img-top" alt="{{ $product->name }}">
            <div class="card-body">
              <h5 class="card-title">{{ $product->name }}</h5>
              <p class="price-gold mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
              <div class="rating mb-2" style="font-size:0.83rem;">
                <i class="fas fa-star"></i> {{ number_format($product->avgRating(), 1) }} ({{ $product->reviewCount() }} review)
              </div>
              <a href="{{ route('products.detail', $product->slug) }}" class="btn-lihat mt-auto">Lihat Detail</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="mt-4">
      <a href="{{ route('marketplace') }}" class="btn-lihat-all">Lihat Semua Produk</a>
    </div>
  </div>
</section>

{{-- UMKM LOKAL --}}
<section class="content-section">
  <div class="container">
    <h2 class="home-section-title">UMKM Lokal</h2>
    <div class="row g-4">
      @foreach($umkms as $umkm)
        <div class="col-md-6">
          <div class="home-card">
            <div class="row g-0">
              <div class="col-4">
                <img src="{{ $umkm->logo ?? 'https://via.placeholder.com/150x150?text=UMKM' }}" class="img-fluid w-100 h-100" alt="{{ $umkm->name }}" style="object-fit:cover;border-radius:14px 0 0 14px;min-height:150px;">
              </div>
              <div class="col-8">
                <div class="card-body">
                  <h5 class="card-title">{{ $umkm->name }}</h5>
                  <p class="card-text">{{ Str::limit($umkm->description, 80) }}</p>
                  <p class="card-text" style="font-size:0.82rem;color:#888;"><i class="fas fa-map-marker-alt me-1"></i>{{ $umkm->address }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

{{-- PETA --}}
<section class="map-section">
  <div class="container text-center">
    <h2 class="home-section-title text-center">Peta Lokasi</h2>
    <p class="text-muted mb-4">Jelajahi lokasi wisata, budaya, dan UMKM di Tanjungpinang</p>
    <a href="{{ route('map') }}" class="btn-lihat-all"><i class="fas fa-map-marked-alt me-2"></i>Buka Peta Interaktif</a>
  </div>
</section>
@endsection

@section('scripts')
<script>
  const quickInput = document.getElementById('quickSearchInput');
  const quickResults = document.getElementById('quickSearchResults');
  let quickTimer;

  function renderQuickResults(data) {
    const groups = [
      ['Budaya', data.cultures],
      ['Wisata', data.tourisms],
      ['Produk', data.products],
      ['Event', data.events]
    ];
    const items = groups.flatMap(([label, values]) => (values || []).map(item => ({...item, label})));
    quickResults.innerHTML = items.length ? items.slice(0, 8).map(item => `
      <a class="quick-result" href="${item.url}">
        <img src="${item.image || '/images/hero-dompak.jpg'}" alt="${item.name}">
        <span><strong>${item.name}</strong><small>${item.label}${item.price ? ' · ' + item.price : ''}</small></span>
      </a>
    `).join('') : '<div class="p-3 text-muted">Data tidak ditemukan.</div>';
    quickResults.style.display = 'block';
  }

  quickInput.addEventListener('input', () => {
    clearTimeout(quickTimer);
    quickTimer = setTimeout(() => {
      fetch(`{{ route('quick-search') }}?q=${encodeURIComponent(quickInput.value)}`)
        .then(response => response.json())
        .then(renderQuickResults);
    }, 250);
  });

  quickInput.addEventListener('focus', () => {
    if (!quickResults.innerHTML) quickInput.dispatchEvent(new Event('input'));
    else quickResults.style.display = 'block';
  });

  document.addEventListener('click', event => {
    if (!event.target.closest('.hero-search-wrap')) quickResults.style.display = 'none';
  });
</script>
@endsection
