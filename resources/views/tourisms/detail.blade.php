@extends('layouts.app')

@section('title', $tourism->name . ' - Wisata Tanjungpinang')

@section('styles')
<style>
  .detail-page { background: #FFF7E2; min-height: 85vh; padding-bottom: 70px; }

  /* BREADCRUMB */
  .breadcrumb-wrap { padding: 30px 0 15px; }
  .breadcrumb-custom { font-size: 0.9rem; color: #666; }
  .breadcrumb-custom a { color: #105746; text-decoration: none; font-weight: 500; }
  .breadcrumb-custom a:hover { text-decoration: underline; }

  /* HERO IMAGE */
  .detail-hero-wrap {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    margin-bottom: 30px;
    height: 440px;
    position: relative;
  }
  .detail-hero-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* HEADINGS */
  .detail-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1a1a1a;
    font-family: serif, 'Times New Roman', Times;
    margin-bottom: 12px;
  }
  .detail-location-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 1rem;
    color: #666;
    margin-bottom: 24px;
  }
  .detail-location-badge i { color: #105746; font-size: 1.1rem; }

  /* CONTENT CARD */
  .content-card-box {
    background: #ffffff;
    border-radius: 20px;
    padding: 36px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.04);
    margin-bottom: 30px;
  }
  .content-heading {
    font-size: 1.4rem;
    font-weight: 800;
    color: #105746;
    margin-bottom: 16px;
    font-family: serif, 'Times New Roman', Times;
  }
  .content-text {
    font-size: 1.05rem;
    line-height: 1.75;
    color: #333333;
    margin-bottom: 0;
  }

  /* SIDEBAR INFO CARD */
  .side-info-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 28px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.04);
    position: sticky;
    top: 90px;
  }
  .side-info-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 1.5px solid #f0f0f0;
  }
  .info-meta-row {
    margin-bottom: 16px;
  }
  .info-meta-label {
    font-size: 0.82rem;
    font-weight: 700;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
  }
  .info-meta-val {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1a1a1a;
  }
  .price-highlight {
    color: #C18A32;
    font-size: 1.35rem;
  }
  .btn-map-guide {
    background: #105746;
    color: #ffffff;
    border: none;
    border-radius: 12px;
    height: 48px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    text-decoration: none;
    margin-top: 10px;
    transition: background 0.2s;
  }
  .btn-map-guide:hover {
    background: #0d4538;
    color: #ffffff;
  }

  @media (max-width: 768px) {
    .detail-hero-wrap { height: 260px; }
    .detail-title { font-size: 1.9rem; }
    .content-card-box { padding: 24px; }
  }
</style>
@endsection

@section('content')
<div class="detail-page">

  {{-- BREADCRUMB --}}
  <div class="container breadcrumb-wrap">
    <div class="breadcrumb-custom">
      <a href="{{ route('home') }}">Home</a> &rsaquo;
      <a href="{{ route('tourisms') }}">Wisata</a> &rsaquo;
      <span>{{ $tourism->name }}</span>
    </div>
  </div>

  <div class="container">
    <div class="row g-4">
      {{-- KOLOM KIRI (KONTEN UTAMA) --}}
      <div class="col-lg-8">
        {{-- GAMBAR UTAMA --}}
        <div class="detail-hero-wrap">
          <img
            src="{{ $tourism->image ?? 'https://via.placeholder.com/900x500?text=Wisata' }}"
            class="detail-hero-img"
            alt="{{ $tourism->name }}"
          >
        </div>

        <h1 class="detail-title">{{ $tourism->name }}</h1>
        <div class="detail-location-badge">
          <i class="fas fa-map-marker-alt"></i>
          <span>{{ $tourism->location ?: 'Kota Tanjungpinang, Kepulauan Riau' }}</span>
        </div>

        {{-- DESKRIPSI LENGKAP --}}
        <div class="content-card-box">
          <h2 class="content-heading">Deskripsi Destinasi</h2>
          <p class="content-text">
            {{ $tourism->description ?: $tourism->short_description }}
          </p>
        </div>

        {{-- GALERI FOTO (JIKA ADA) --}}
        @if($tourism->gallery && is_array($tourism->gallery))
          <div class="content-card-box">
            <h2 class="content-heading">Galeri Foto</h2>
            <div class="row g-3">
              @foreach($tourism->gallery as $gImg)
                <div class="col-sm-6 col-md-4">
                  <img src="{{ $gImg }}" class="img-fluid rounded-3 w-100" style="height:150px;object-fit:cover;" alt="Galeri">
                </div>
              @endforeach
            </div>
          </div>
        @endif
      </div>

      {{-- KOLOM KANAN (SIDEBAR INFORMASI OPERASIONAL & TIKET) --}}
      <div class="col-lg-4">
        <div class="side-info-card">
          <div class="side-info-title">Informasi Kunjungan</div>

          <div class="info-meta-row">
            <div class="info-meta-label">Kategori Wisata</div>
            <div class="info-meta-val">{{ $tourism->category->name ?? 'Destinasi Wisata' }}</div>
          </div>

          <div class="info-meta-row">
            <div class="info-meta-label">Jam Operasional</div>
            <div class="info-meta-val">
              @if($tourism->open_time && $tourism->close_time)
                {{ $tourism->open_time->format('H:i') }} - {{ $tourism->close_time->format('H:i') }} WIB
              @else
                Setiap Hari (Buka 24 Jam)
              @endif
            </div>
          </div>

          <div class="info-meta-row">
            <div class="info-meta-label">Tiket Masuk</div>
            <div class="info-meta-val price-highlight">
              @if($tourism->ticket_price > 0)
                Rp {{ number_format($tourism->ticket_price, 0, ',', '.') }}
              @else
                Gratis
              @endif
            </div>
          </div>

          <div class="info-meta-row">
            <div class="info-meta-label">Lokasi</div>
            <div class="info-meta-val">{{ $tourism->location }}</div>
          </div>

          @if($tourism->latitude && $tourism->longitude)
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $tourism->latitude }},{{ $tourism->longitude }}" target="_blank" class="btn-map-guide">
              <i class="fas fa-directions"></i> Petunjuk Arah (Navigasi)
            </a>
          @endif

          <a href="{{ route('map') }}" class="btn-map-guide" style="background:#ffffff; color:#105746; border:1.5px solid #105746;">
            <i class="fas fa-map-location-dot"></i> Buka di Peta Interaktif
          </a>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
