@extends('layouts.app')

@section('title', $event->name . ' - Event Tanjungpinang')

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
  .badge-status {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.82rem;
    font-weight: 700;
    text-transform: uppercase;
  }
  .status-upcoming { background: #e0f2ec; color: #105746; }
  .status-ongoing { background: #fff5e0; color: #b87c00; }
  .status-completed { background: #f0f0f0; color: #888; }

  .btn-register-event {
    background: #105746;
    color: #ffffff;
    border: none;
    border-radius: 12px;
    height: 50px;
    font-weight: 700;
    font-size: 1.05rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    cursor: pointer;
    transition: background 0.2s;
    margin-top: 10px;
  }
  .btn-register-event:hover {
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
      <a href="{{ route('events') }}">Event</a> &rsaquo;
      <span>{{ $event->name }}</span>
    </div>
  </div>

  <div class="container">
    @if(session('success'))
      <div class="alert alert-success rounded-4 mb-4">
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger rounded-4 mb-4">
        {{ session('error') }}
      </div>
    @endif

    <div class="row g-4">
      {{-- KOLOM KIRI (KONTEN EVENT) --}}
      <div class="col-lg-8">
        {{-- GAMBAR UTAMA --}}
        <div class="detail-hero-wrap">
          <img
            src="{{ $event->image ?? 'https://via.placeholder.com/900x500?text=Event' }}"
            class="detail-hero-img"
            alt="{{ $event->name }}"
          >
        </div>

        <h1 class="detail-title">{{ $event->name }}</h1>
        <div class="detail-location-badge">
          <i class="fas fa-map-marker-alt"></i>
          <span>{{ $event->location ?: 'Kota Tanjungpinang, Kepulauan Riau' }}</span>
        </div>

        {{-- DESKRIPSI EVENT --}}
        <div class="content-card-box">
          <h2 class="content-heading">Deskripsi &amp; Rangkaian Acara</h2>
          <p class="content-text">
            {{ $event->description }}
          </p>
        </div>
      </div>

      {{-- KOLOM KANAN (SIDEBAR JADWAL & PENDAFTARAN) --}}
      <div class="col-lg-4">
        <div class="side-info-card">
          <div class="side-info-title">Jadwal &amp; Partisipasi</div>

          <div class="info-meta-row">
            <div class="info-meta-label">Status Acara</div>
            <div>
              <span class="badge-status status-{{ $event->status }}">
                {{ $event->status === 'upcoming' ? 'Akan Datang' : ($event->status === 'ongoing' ? 'Sedang Berlangsung' : 'Selesai') }}
              </span>
            </div>
          </div>

          <div class="info-meta-row">
            <div class="info-meta-label">Waktu Pelaksanaan</div>
            <div class="info-meta-val" style="font-size:0.98rem;">
              <i class="far fa-calendar-alt text-muted me-1"></i>
              @if($event->start_date && $event->end_date && $event->start_date != $event->end_date)
                {{ $event->start_date->format('d M Y') }} s/d {{ $event->end_date->format('d M Y') }}
              @elseif($event->start_date)
                {{ $event->start_date->format('d M Y H:i') }} WIB
              @else
                Tanggal Segera Diumumkan
              @endif
            </div>
          </div>

          <div class="info-meta-row">
            <div class="info-meta-label">Lokasi</div>
            <div class="info-meta-val" style="font-size:0.98rem;">
              <i class="fas fa-map-marker-alt text-muted me-1"></i>
              {{ $event->location }}
            </div>
          </div>

          @if($event->max_participants)
            @php
              $registeredCount = \App\Models\EventRegistration::where('event_id', $event->id)->count();
              $remainingSlots = max(0, $event->max_participants - $registeredCount);
            @endphp
            <div class="info-meta-row">
              <div class="info-meta-label">Kuota Peserta</div>
              <div class="info-meta-val">
                {{ number_format($remainingSlots, 0, ',', '.') }} slot tersisa
                <div class="small text-muted fw-normal mt-1">dari {{ number_format($event->max_participants, 0, ',', '.') }} kuota</div>
              </div>
            </div>
          @endif

          {{-- TOMBOL DAFTAR EVENT --}}
          @auth
            @if($event->is_registration_open && $event->status !== 'completed' && $event->status !== 'cancelled' && (!$event->max_participants || $remainingSlots > 0))
              <button class="btn-register-event" data-bs-toggle="modal" data-bs-target="#registerEventModal">
                <i class="fas fa-ticket-alt"></i> Daftar Acara Sekarang
              </button>
            @else
              <button class="btn-register-event" style="background:#a0a0a0; cursor:not-allowed;" disabled>
                Pendaftaran Ditutup
              </button>
            @endif
          @else
            <a href="{{ route('login') }}" class="btn-register-event">
              Login untuk Mendaftar
            </a>
          @endauth

          @if($event->latitude && $event->longitude)
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $event->latitude }},{{ $event->longitude }}" target="_blank" class="btn-register-event" style="background:#ffffff; color:#105746; border:1.5px solid #105746;">
              <i class="fas fa-directions"></i> Petunjuk Arah Lokasi
            </a>
          @endif
        </div>
      </div>
    </div>
  </div>

</div>

{{-- MODAL REGISTRASI EVENT --}}
@auth
<div class="modal fade" id="registerEventModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:20px; overflow:hidden; border:none;">
      <div class="modal-header" style="background:#105746; color:#ffffff; padding:20px 24px;">
        <h5 class="modal-title fw-bold">Konfirmasi Pendaftaran Event</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('events.register', $event->id) }}">
        @csrf
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label fw-bold small text-muted">Nama Peserta</label>
            <input type="text" name="name" class="form-control form-control-lg" value="{{ Auth::user()->name }}" required style="border-radius:10px; font-size:1rem;">
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold small text-muted">Nomor WhatsApp / HP</label>
            <input type="tel" name="phone" class="form-control form-control-lg" value="{{ Auth::user()->phone }}" placeholder="08xxxxxxxxxx" required style="border-radius:10px; font-size:1rem;">
          </div>
          <div class="mb-0">
            <label class="form-label fw-bold small text-muted">Catatan / Asal Instansi (Opsional)</label>
            <textarea name="notes" class="form-control" rows="3" placeholder="Tuliskan catatan tambahan jika ada..." style="border-radius:10px;"></textarea>
          </div>
        </div>
        <div class="modal-footer p-3 bg-light">
          <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal" style="border-radius:10px;">Batal</button>
          <button type="submit" class="btn text-white px-4" style="background:#105746; border-radius:10px; font-weight:700;">Konfirmasi Daftar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endauth
@endsection
