@extends('layouts.app')

@section('title', 'Budaya')

@section('styles')
<style>
  .culture-page { background: #FFF7E2; min-height: 80vh; }

  /* HEADER */
  .culture-header {
    background: #FFF7E2;
    padding: 40px 0 32px;
  }
  .breadcrumb-custom {
    font-size: 0.85rem;
    color: #888;
    margin-bottom: 14px;
  }
  .breadcrumb-custom a { color: #105746; text-decoration: none; }
  .breadcrumb-custom a:hover { text-decoration: underline; }
  .culture-header h1 {
    font-size: 2.4rem;
    font-weight: 800;
    color: #1a1a1a;
    line-height: 1.2;
    margin-bottom: 10px;
  }
  .culture-header p {
    font-size: 1rem;
    color: #666;
    margin-bottom: 0;
  }

  /* FILTER */
  .filter-bar {
    background: #ffffff;
    padding: 18px 0;
    border-bottom: 1px solid #ebebeb;
    position: sticky;
    top: 56px;
    z-index: 100;
  }
  .filter-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
  }
  .filter-scroll {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
  }
  .filter-btn {
    display: inline-flex;
    align-items: center;
    height: 44px;
    padding: 0 24px;
    border-radius: 999px;
    border: 1.5px solid #d5d5d5;
    background: #ffffff;
    color: #333;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.18s;
    white-space: nowrap;
    line-height: 1;
  }
  .filter-btn:hover {
    border-color: #105746;
    color: #105746;
  }
  .filter-btn.active {
    background: #105746;
    color: #ffffff;
    border-color: #105746;
  }

  /* SEARCH BAR */
  .culture-search {
    display: flex;
    width: 280px;
    flex-shrink: 0;
    border-radius: 999px;
    overflow: hidden;
    border: 1.5px solid #d5d5d5;
    background: #fff;
  }
  .culture-search input {
    flex: 1;
    border: none;
    padding: 8px 14px;
    font-size: 0.88rem;
    outline: none;
    background: transparent;
  }
  .culture-search button {
    background: #105746;
    color: #fff;
    border: none;
    padding: 8px 14px;
    cursor: pointer;
  }

  /* GRID KARTU */
  .culture-grid {
    padding: 36px 0 52px;
  }
  .culture-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    transition: transform 0.22s, box-shadow 0.22s;
    display: flex;
    flex-direction: column;
    height: 100%;
    margin-bottom: 24px;
  }
  .culture-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 28px rgba(0,0,0,0.12);
  }
  .culture-card-img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    display: block;
  }
  .culture-card-body {
    padding: 20px 22px 22px;
    display: flex;
    flex-direction: column;
    flex: 1;
  }
  .culture-card-category {
    display: inline-block;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #105746;
    background: #e8f4f0;
    border-radius: 20px;
    padding: 3px 12px;
    margin-bottom: 10px;
  }
  .culture-card-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 8px;
    line-height: 1.3;
  }
  .culture-card-desc {
    font-size: 0.85rem;
    color: #666;
    flex-grow: 1;
    margin-bottom: 16px;
    line-height: 1.5;
  }
  .culture-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
  }
  .culture-card-location {
    font-size: 0.8rem;
    color: #999;
  }
  .btn-detail {
    background: #105746;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 8px 20px;
    font-size: 0.83rem;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s;
    white-space: nowrap;
  }
  .btn-detail:hover { background: #0d4538; color: #fff; }

  /* KOSONG */
  .empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #aaa;
  }
  .empty-state i { font-size: 3rem; margin-bottom: 16px; color: #ddd; }

  /* PAGINATION */
  .pagination .page-link { color: #105746; }
  .pagination .page-item.active .page-link { background: #105746; border-color: #105746; color: #fff; }

  @media (max-width: 767px) {
    .culture-header h1 { font-size: 1.7rem; }
    .filter-bar { position: static; }
    .filter-inner { flex-direction: column; align-items: flex-start; }
    .culture-search { width: 100%; }
  }
</style>
@endsection

@section('content')
<div class="culture-page">

  {{-- HEADER --}}
  <div class="culture-header">
    <div class="container">
      <div class="breadcrumb-custom">
        <a href="{{ route('home') }}">Home</a> &rsaquo; <span>Budaya</span>
      </div>
      <h1>Warisan Budaya<br>Tanjungpinang</h1>
      <p>Mengenal lebih dekat kekayaan budaya Melayu Kepulauan Riau</p>
    </div>
  </div>

  {{-- FILTER BAR --}}
  <div class="filter-bar">
    <div class="container">
      <div class="filter-inner">
        <div class="filter-scroll">
          <button class="filter-btn {{ request('category', 'semua') === 'semua' ? 'active' : '' }}" data-category="semua">Semua</button>
          <button class="filter-btn" data-category="tari">Tari</button>
          <button class="filter-btn" data-category="tradisi">Tradisi</button>
          <button class="filter-btn" data-category="kesenian">Kesenian</button>
          <button class="filter-btn" data-category="kuliner">Kuliner</button>
          <button class="filter-btn" data-category="bahasa">Bahasa</button>
        </div>
        <form method="GET" class="culture-search">
          <input type="text" name="search" placeholder="Cari budaya..." value="{{ request('search') }}">
          <button type="submit"><i class="fas fa-search"></i></button>
        </form>
      </div>
    </div>
  </div>

  {{-- GRID --}}
  <div class="culture-grid">
    <div class="container">
      <div class="row g-4" id="culture-grid">
        @forelse($cultures as $culture)
          <div class="col-md-6 culture-item"
               data-category="{{ strtolower($culture->category->name ?? 'semua') }}">
            <div class="culture-card">
              <img
                src="{{ $culture->image ?? 'https://via.placeholder.com/600x220?text=Budaya' }}"
                class="culture-card-img"
                alt="{{ $culture->name }}"
              >
              <div class="culture-card-body">
                @if($culture->category)
                  <span class="culture-card-category">{{ $culture->category->name }}</span>
                @endif
                <div class="culture-card-title">{{ $culture->name }}</div>
                <div class="culture-card-desc">{{ Str::limit($culture->short_description, 120) }}</div>
                <div class="culture-card-footer">
                  <span class="culture-card-location">
                    @if($culture->location)
                      <i class="fas fa-map-marker-alt me-1"></i>{{ $culture->location }}
                    @endif
                  </span>
                  <a href="{{ route('cultures.detail', $culture->slug) }}" class="btn-detail">Lihat Detail</a>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <div class="empty-state">
              <i class="fas fa-masks-theater d-block"></i>
              <p>Tidak ada budaya ditemukan.</p>
            </div>
          </div>
        @endforelse
      </div>

      {{-- EMPTY STATE (ditampilkan via JS saat filter aktif) --}}
      <div id="no-result" class="empty-state" style="display:none;">
        <i class="fas fa-masks-theater d-block"></i>
        <p>Tidak ada budaya dalam kategori ini.</p>
      </div>

      {{-- PAGINATION --}}
      <div class="d-flex justify-content-center mt-4">
        {{ $cultures->links() }}
      </div>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script>
  const filterBtns = document.querySelectorAll('.filter-btn');
  const items = document.querySelectorAll('.culture-item');
  const noResult = document.getElementById('no-result');

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
        const itemCat = item.dataset.category;
        if (cat === 'semua' || itemCat.includes(cat)) {
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
