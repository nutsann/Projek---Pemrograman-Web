@extends('layouts.app')

@section('title', 'Event & Budaya Tanjungpinang')

@section('styles')
<style>
  .event-page { background: #FFF7E2; min-height: 85vh; padding-bottom: 60px; }

  /* HEADER */
  .event-header {
    background: #FFF7E2;
    padding: 40px 0 24px;
  }
  .breadcrumb-custom {
    font-size: 0.85rem;
    color: #888;
    margin-bottom: 14px;
  }
  .breadcrumb-custom a { color: #105746; text-decoration: none; }
  .breadcrumb-custom a:hover { text-decoration: underline; }
  .event-header h1 {
    font-size: 2.6rem;
    font-weight: 800;
    color: #1a1a1a;
    line-height: 1.2;
    margin-bottom: 10px;
    font-family: serif, 'Times New Roman', Times;
  }
  .event-header p {
    font-size: 1.05rem;
    color: #555;
    margin-bottom: 0;
  }

  /* FILTER BAR */
  .filter-bar {
    background: transparent;
    padding: 10px 0 28px;
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

  /* GRID KARTU EVENT */
  .event-grid {
    padding-top: 10px;
  }
  .event-card {
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
  .event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 28px rgba(0,0,0,0.12);
  }
  .event-card-img-wrap {
    padding: 16px 16px 0 16px;
  }
  .event-card-img {
    width: 100%;
    height: 230px;
    object-fit: cover;
    border-radius: 14px;
    display: block;
  }
  .event-card-body {
    padding: 20px;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 16px;
    flex: 1;
  }
  .event-card-info {
    flex: 1;
  }
  .event-card-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 12px;
    line-height: 1.3;
  }
  .event-meta-item {
    font-size: 0.88rem;
    color: #555;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .event-meta-item i {
    color: #105746;
    width: 16px;
    font-size: 0.95rem;
  }
  .btn-detail-event {
    background: #105746;
    color: #ffffff;
    border: none;
    border-radius: 10px;
    padding: 10px 22px;
    font-size: 0.92rem;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s;
    white-space: nowrap;
    display: inline-block;
  }
  .btn-detail-event:hover {
    background: #0d4538;
    color: #ffffff;
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

  @media (max-width: 767px) {
    .event-header h1 { font-size: 2rem; }
    .filter-inner { gap: 10px; }
    .filter-btn { min-width: 90px; height: 40px; padding: 0 18px; font-size: 0.88rem; }
    .event-card-body { flex-direction: column; align-items: stretch; }
    .btn-detail-event { text-align: center; margin-top: 10px; }
    .event-card-img { height: 190px; }
  }
</style>
@endsection

@section('content')
<div class="event-page">

  {{-- HEADER --}}
  <div class="event-header">
    <div class="container">
      <div class="breadcrumb-custom">
        <a href="{{ route('home') }}">Home</a> &rsaquo; <span>Event</span>
      </div>
      <h1>Event &amp; Budaya</h1>
      <p>Jangan Lewatkan Berbagai event budaya Tanjungpinang</p>
    </div>
  </div>

  <div class="container">
    {{-- FILTER BAR --}}
    <div class="filter-bar">
      <div class="filter-inner">
        <button class="filter-btn {{ request('category', 'semua') === 'semua' ? 'active' : '' }}" data-category="semua">Semua</button>
        <button class="filter-btn" data-category="festival">Festival</button>
        <button class="filter-btn" data-category="pameran">Pameran</button>
        <button class="filter-btn" data-category="workshop">Workshop</button>
      </div>
    </div>

    {{-- GRID EVENT (2 Kolom Desktop) --}}
    <div class="event-grid">
      <div class="row g-4" id="event-grid">
        @forelse($events as $event)
          <div class="col-md-6 event-item"
               data-name="{{ strtolower($event->name) }}"
               data-desc="{{ strtolower($event->description ?? '') }}">
            <div class="event-card">
              <div class="event-card-img-wrap">
                <img
                  src="{{ $event->image ?? 'https://via.placeholder.com/600x240?text=Event' }}"
                  class="event-card-img"
                  alt="{{ $event->name }}"
                >
              </div>
              <div class="event-card-body">
                <div class="event-card-info">
                  <div class="event-card-title">{{ $event->name }}</div>
                  {{-- Tanggal Pelaksanaan --}}
                  <div class="event-meta-item">
                    <i class="far fa-calendar-alt"></i>
                    <span>
                      @if($event->start_date && $event->end_date && $event->start_date != $event->end_date)
                        {{ $event->start_date->format('d') }}–{{ $event->end_date->format('d M Y') }}
                      @elseif($event->start_date)
                        {{ $event->start_date->format('d M Y') }}
                      @else
                        Tanggal Segera Diumumkan
                      @endif
                    </span>
                  </div>

                  {{-- Lokasi Event --}}
                  <div class="event-meta-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $event->location ?: 'Tanjungpinang' }}</span>
                  </div>
                </div>

                {{-- Tombol Detail --}}
                <div>
                  <a href="{{ route('events.detail', $event->slug) }}" class="btn-detail-event">
                    Lihat Detail
                  </a>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <div class="empty-state">
              <i class="fas fa-calendar-times d-block"></i>
              <p>Belum ada event budaya yang dijadwalkan.</p>
            </div>
          </div>
        @endforelse
      </div>

      {{-- EMPTY STATE SAAT FILTER KOSONG --}}
      <div id="no-result" class="empty-state" style="display:none;">
        <i class="fas fa-calendar-times d-block"></i>
        <p>Tidak ada event dalam kategori ini.</p>
      </div>

      {{-- PAGINATION --}}
      <div class="d-flex justify-content-center mt-5">
        {{ $events->links() }}
      </div>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script>
  const filterBtns = document.querySelectorAll('.filter-btn');
  const items = document.querySelectorAll('.event-item');
  const noResult = document.getElementById('no-result');

  // Mapping kata kunci kategori event
  const categoryKeywords = {
    festival: ['festival', 'pawai', 'karnaval', 'tari', 'zapin', 'budaya', 'parade', 'pesta'],
    pameran: ['pameran', 'ekspo', 'expo', 'umkm', 'bazar', 'pasar', 'galeri', 'seni'],
    workshop: ['workshop', 'pelatihan', 'kelas', 'tenun', 'belajar', 'kuliner', 'membatik', 'kerajinan']
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
