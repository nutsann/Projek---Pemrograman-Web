@extends('layouts.app')

@section('title', 'Destinasi Wisata')

@section('styles')
<style>
  .tourism-page { background: #FFF7E2; min-height: 80vh; }

  /* HEADER */
  .tourism-header {
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
  .tourism-header h1 {
    font-size: 2.4rem;
    font-weight: 800;
    color: #1a1a1a;
    line-height: 1.2;
    margin-bottom: 10px;
  }
  .tourism-header p {
    font-size: 1rem;
    color: #666;
    margin-bottom: 0;
  }

  /* FILTER BAR */
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
  .tourism-search {
    display: flex;
    width: 280px;
    flex-shrink: 0;
    border-radius: 999px;
    overflow: hidden;
    border: 1.5px solid #d5d5d5;
    background: #fff;
  }
  .tourism-search input {
    flex: 1;
    border: none;
    padding: 8px 16px;
    font-size: 0.88rem;
    outline: none;
    background: transparent;
  }
  .tourism-search button {
    background: #105746;
    color: #fff;
    border: none;
    padding: 8px 16px;
    cursor: pointer;
  }

  /* GRID KARTU */
  .tourism-grid {
    padding: 36px 0 52px;
  }
  .tourism-card {
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
  .tourism-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 28px rgba(0,0,0,0.12);
  }
  .tourism-card-img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    display: block;
  }
  .tourism-card-body {
    padding: 20px 22px 22px;
    display: flex;
    flex-direction: column;
    flex: 1;
  }
  .tourism-card-title {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 8px;
    line-height: 1.3;
  }
  .tourism-card-desc {
    font-size: 0.85rem;
    color: #666;
    flex-grow: 1;
    margin-bottom: 16px;
    line-height: 1.5;
  }
  .tourism-card-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
  }
  .tourism-card-location {
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
    .tourism-header h1 { font-size: 1.7rem; }
    .filter-bar { position: static; }
    .filter-inner { flex-direction: column; align-items: flex-start; }
    .tourism-search { width: 100%; }
  }
</style>
@endsection

@section('content')
<div class="tourism-page">

  {{-- HEADER --}}
  <div class="tourism-header">
    <div class="container">
      <div class="breadcrumb-custom">
        <a href="{{ route('home') }}">Home</a> &rsaquo; <span>Wisata</span>
      </div>
      <h1>Destinasi Wisata<br>Tanjungpinang</h1>
      <p>Nikmati keindahan alam, sejarah, dan budaya di setiap sudut kota.</p>
    </div>
  </div>

  {{-- FILTER BAR --}}
  <div class="filter-bar">
    <div class="container">
      <div class="filter-inner">
        <div class="filter-scroll">
          <button class="filter-btn {{ request('category', 'semua') === 'semua' ? 'active' : '' }}" data-category="semua">Semua</button>
          <button class="filter-btn" data-category="sejarah">Wisata Sejarah</button>
          <button class="filter-btn" data-category="pantai">Pantai</button>
          <button class="filter-btn" data-category="keluarga">Wisata Keluarga</button>
        </div>
        <form method="GET" class="tourism-search">
          <input type="text" name="search" placeholder="Cari wisata..." value="{{ request('search') }}">
          <button type="submit"><i class="fas fa-search"></i></button>
        </form>
      </div>
    </div>
  </div>

  {{-- GRID --}}
  <div class="tourism-grid">
    <div class="container">
      <div class="row g-4" id="tourism-grid">
        @forelse($tourisms as $tourism)
          <div class="col-md-6 tourism-item"
               data-name="{{ strtolower($tourism->name) }}"
               data-desc="{{ strtolower($tourism->short_description ?? '') }}">
            <div class="tourism-card">
              <img
                src="{{ $tourism->image ?? 'https://via.placeholder.com/600x220?text=Wisata' }}"
                class="tourism-card-img"
                alt="{{ $tourism->name }}"
              >
              <div class="tourism-card-body">
                <div class="tourism-card-title">{{ $tourism->name }}</div>
                <div class="tourism-card-desc">{{ Str::limit($tourism->short_description, 120) }}</div>
                <div class="tourism-card-footer">
                  <span class="tourism-card-location">
                    @if($tourism->location)
                      <i class="fas fa-map-marker-alt me-1"></i>{{ $tourism->location }}
                    @endif
                  </span>
                  <a href="{{ route('tourisms.detail', $tourism->slug) }}" class="btn-detail">Lihat Detail</a>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <div class="empty-state">
              <i class="fas fa-mountain-sun d-block"></i>
              <p>Tidak ada destinasi wisata ditemukan.</p>
            </div>
          </div>
        @endforelse
      </div>

      {{-- EMPTY STATE --}}
      <div id="no-result" class="empty-state" style="display:none;">
        <i class="fas fa-mountain-sun d-block"></i>
        <p>Tidak ada destinasi wisata dalam kategori ini.</p>
      </div>

      {{-- PAGINATION --}}
      <div class="d-flex justify-content-center mt-4">
        {{ $tourisms->links() }}
      </div>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script>
  const filterBtns = document.querySelectorAll('.filter-btn');
  const items = document.querySelectorAll('.tourism-item');
  const noResult = document.getElementById('no-result');

  // Keyword mapping untuk kategori wisata
  const categoryKeywords = {
    sejarah: ['sejarah', 'masjid', 'penyengat', 'benteng', 'makam', 'sultan', 'candi', 'kelenteng', 'museum', 'gedung'],
    pantai: ['pantai', 'laut', 'pesisir', 'tepi laut', 'pulau', 'pasir', 'sunset'],
    keluarga: ['keluarga', 'taman', 'rekreasi', 'pasar', 'kuliner', 'anak', 'mall', 'pusat']
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
        const desc = item.dataset.desc;
        const keywords = categoryKeywords[cat] || [cat];

        const match = keywords.some(kw => name.includes(kw) || desc.includes(kw));

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
