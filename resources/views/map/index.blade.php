@extends('layouts.app')

@section('title', 'Peta Interaktif')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
  .map-page { background: #FFF7E2; min-height: 85vh; padding-bottom: 60px; }

  /* HEADER */
  .map-header {
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
  .map-header h1 {
    font-size: 2.4rem;
    font-weight: 800;
    color: #1a1a1a;
    line-height: 1.2;
    margin-bottom: 10px;
  }
  .map-header p {
    font-size: 1rem;
    color: #666;
    margin-bottom: 0;
  }

  /* FILTER BAR */
  .filter-bar {
    background: transparent;
    padding: 10px 0 24px;
  }
  .filter-inner {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
  }
  .filter-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 100px;
    height: 44px;
    padding: 0 24px;
    border-radius: 999px;
    border: 1.5px solid #e0d8c3;
    background: #ffffff;
    color: #333;
    font-size: 0.92rem;
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

  /* MAP CONTAINER */
  .map-card-wrapper {
    position: relative;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    background: #ffffff;
    border: 4px solid #ffffff;
  }
  #map {
    height: 540px;
    width: 100%;
    border-radius: 20px;
  }

  /* LEGENDA BAWAH */
  .bottom-legend-container {
    display: flex;
    justify-content: center;
    margin-top: 24px;
  }
  .bottom-legend {
    display: inline-flex;
    align-items: center;
    background: #ffffff;
    padding: 10px 24px;
    border-radius: 999px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    gap: 20px;
    flex-wrap: wrap;
  }
  .legend-pill {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    color: #333;
  }
  .legend-dot {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    display: inline-block;
  }
  .legend-divider {
    width: 1px;
    height: 18px;
    background: #e5e5e5;
  }

  /* POPUP STYLES */
  .leaflet-popup-content-wrapper {
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    padding: 4px;
  }
  .popup-body {
    min-width: 200px;
    padding: 4px;
  }
  .popup-body img {
    width: 100%;
    height: 110px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 8px;
  }
  .popup-title {
    font-size: 0.98rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 4px;
  }
  .popup-cat {
    display: inline-block;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    padding: 2px 8px;
    border-radius: 12px;
    margin-bottom: 6px;
  }
  .popup-cat.budaya { background: #ffe9d6; color: #d9531e; }
  .popup-cat.wisata { background: #dff0e8; color: #105746; }
  .popup-cat.umkm { background: #fff4d6; color: #b87c00; }
  .popup-cat.event { background: #e0edff; color: #1f64c4; }

  .loc-btn {
    position: absolute;
    top: 16px;
    right: 16px;
    z-index: 400;
    background: #ffffff;
    border: none;
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 0.85rem;
    font-weight: 600;
    color: #105746;
    box-shadow: 0 2px 10px rgba(0,0,0,0.15);
    cursor: pointer;
    transition: all 0.2s;
  }
  .loc-btn:hover {
    background: #105746;
    color: #ffffff;
  }

  @media (max-width: 767px) {
    .map-header h1 { font-size: 1.8rem; }
    #map { height: 420px; }
    .bottom-legend { gap: 12px; padding: 10px 16px; justify-content: center; }
    .legend-divider { display: none; }
    .filter-btn { height: 38px; min-width: 80px; padding: 0 16px; font-size: 0.85rem; }
  }
</style>
@endsection

@section('content')
<div class="map-page">

  {{-- HEADER --}}
  <div class="map-header">
    <div class="container">
      <div class="breadcrumb-custom">
        <a href="{{ route('home') }}">Home</a> &rsaquo; <span>Peta</span>
      </div>
      <h1>Peta Interaktif<br>Budaya dan UMKM</h1>
      <p>Temukan lokasi budaya, destinasi wisata, event, dan UMKM di Tanjungpinang</p>
    </div>
  </div>

  <div class="container">
    {{-- FILTER BAR --}}
    <div class="filter-bar">
      <div class="filter-inner">
        <button class="filter-btn active" data-category="all">Semua</button>
        <button class="filter-btn" data-category="budaya">Budaya</button>
        <button class="filter-btn" data-category="wisata">Wisata</button>
        <button class="filter-btn" data-category="umkm">UMKM</button>
        <button class="filter-btn" data-category="event">Event</button>
      </div>
    </div>

    {{-- PETA CONTAINER --}}
    <div class="map-card-wrapper">
      <button onclick="getUserLocation()" class="loc-btn">
        <i class="fas fa-location-arrow me-1"></i> Lokasi Saya
      </button>
      <div id="map"></div>
    </div>

    {{-- LEGENDA BAWAH --}}
    <div class="bottom-legend-container">
      <div class="bottom-legend">
        <div class="legend-pill">
          <span class="legend-dot" style="background:#D9531E;"></span>
          <span>Budaya</span>
        </div>
        <div class="legend-divider"></div>
        <div class="legend-pill">
          <span class="legend-dot" style="background:#105746;"></span>
          <span>Wisata</span>
        </div>
        <div class="legend-divider"></div>
        <div class="legend-pill">
          <span class="legend-dot" style="background:#E5A93C;"></span>
          <span>UMKM</span>
        </div>
        <div class="legend-divider"></div>
        <div class="legend-pill">
          <span class="legend-dot" style="background:#2670E8;"></span>
          <span>Event</span>
        </div>
      </div>
    </div>

  </div>

</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  // Inisialisasi Peta (Tanjungpinang)
  const map = L.map('map').setView([0.9174, 104.4501], 13);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
  }).addTo(map);

  let userMarker = null;

  function getUserLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(position => {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        if (userMarker) map.removeLayer(userMarker);
        userMarker = L.marker([lat, lng]).addTo(map).bindPopup("<b>📍 Lokasi Anda</b>").openPopup();
        map.setView([lat, lng], 14);
      }, () => {
        alert("Gagal mengambil lokasi Anda. Pastikan izin GPS aktif.");
      });
    }
  }

  function createCustomIcon(color, faIcon) {
    return L.divIcon({
      className: 'custom-map-pin',
      html: `
        <div style="background:${color};width:32px;height:32px;border-radius:50%;border:2.5px solid white;box-shadow:0 3px 10px rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;color:white;font-size:13px;">
          <i class="fas ${faIcon}"></i>
        </div>
      `,
      iconSize: [32, 32],
      iconAnchor: [16, 16],
      popupAnchor: [0, -16]
    });
  }

  const cultures = @json($cultures ?? []);
  const tourisms = @json($tourisms ?? []);
  const umkms = @json($umkms ?? []);

  // Simpan instance marker berdasarkan kategori
  const markers = {
    budaya: [],
    wisata: [],
    umkm: [],
    event: []
  };

  // 1. BUDAYA (Oranye/Coklat: #D9531E)
  cultures.forEach(c => {
    if(c.latitude && c.longitude) {
      const gmapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${c.latitude},${c.longitude}`;
      const m = L.marker([c.latitude, c.longitude], {
        icon: createCustomIcon('#D9531E', 'fa-landmark')
      }).bindPopup(`
        <div class="popup-body">
          ${c.image ? `<img src="${c.image}" alt="${c.name}">` : ''}
          <span class="popup-cat budaya">Budaya</span>
          <div class="popup-title">${c.name}</div>
          <small class="text-muted d-block mb-2"><i class="fas fa-map-marker-alt me-1"></i>${c.location || 'Tanjungpinang'}</small>
          <div class="d-grid gap-1 mt-2">
            <a href="${gmapsUrl}" target="_blank" class="btn btn-sm text-white" style="background:#D9531E;"><i class="fas fa-directions me-1"></i> Petunjuk Arah</a>
            <a href="{{ url('/cultures') }}/${c.slug}" class="btn btn-sm btn-outline-secondary">Lihat Detail</a>
          </div>
        </div>
      `);
      m.addTo(map);
      markers.budaya.push(m);
    }
  });

  // 2. WISATA (Hijau Tua: #105746)
  tourisms.forEach(t => {
    if(t.latitude && t.longitude) {
      const gmapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${t.latitude},${t.longitude}`;
      const m = L.marker([t.latitude, t.longitude], {
        icon: createCustomIcon('#105746', 'fa-mountain-sun')
      }).bindPopup(`
        <div class="popup-body">
          ${t.image ? `<img src="${t.image}" alt="${t.name}">` : ''}
          <span class="popup-cat wisata">Wisata</span>
          <div class="popup-title">${t.name}</div>
          <small class="text-muted d-block mb-2"><i class="fas fa-map-marker-alt me-1"></i>${t.location || 'Tanjungpinang'}</small>
          <div class="d-grid gap-1 mt-2">
            <a href="${gmapsUrl}" target="_blank" class="btn btn-sm text-white" style="background:#105746;"><i class="fas fa-directions me-1"></i> Petunjuk Arah</a>
            <a href="{{ url('/tourisms') }}/${t.slug}" class="btn btn-sm btn-outline-secondary">Lihat Detail</a>
          </div>
        </div>
      `);
      m.addTo(map);
      markers.wisata.push(m);
    }
  });

  // 3. UMKM (Emas: #E5A93C)
  umkms.forEach(u => {
    if(u.latitude && u.longitude) {
      const gmapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${u.latitude},${u.longitude}`;
      const m = L.marker([u.latitude, u.longitude], {
        icon: createCustomIcon('#E5A93C', 'fa-store')
      }).bindPopup(`
        <div class="popup-body">
          ${u.logo ? `<img src="${u.logo}" alt="${u.name}">` : ''}
          <span class="popup-cat umkm">UMKM</span>
          <div class="popup-title">${u.name}</div>
          <small class="text-muted d-block mb-2"><i class="fas fa-map-marker-alt me-1"></i>${u.address || 'Tanjungpinang'}</small>
          <div class="d-grid gap-1 mt-2">
            <a href="${gmapsUrl}" target="_blank" class="btn btn-sm text-white" style="background:#E5A93C;"><i class="fas fa-directions me-1"></i> Petunjuk Arah</a>
          </div>
        </div>
      `);
      m.addTo(map);
      markers.umkm.push(m);
    }
  });

  // Fit bounds awal jika ada marker
  const allCoords = [];
  [...cultures, ...tourisms, ...umkms].forEach(p => {
    if(p.latitude && p.longitude) allCoords.push([p.latitude, p.longitude]);
  });
  if(allCoords.length > 1) {
    const group = L.featureGroup(allCoords.map(c => L.marker(c)));
    map.fitBounds(group.getBounds().pad(0.15), { maxZoom: 15 });
  }

  // LOGIKA FILTER MARKER
  const filterBtns = document.querySelectorAll('.filter-btn');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const selectedCat = btn.dataset.category;

      // Sembunyikan/tampilkan layer marker
      Object.keys(markers).forEach(cat => {
        markers[cat].forEach(m => {
          if (selectedCat === 'all' || selectedCat === cat) {
            if (!map.hasLayer(m)) map.addLayer(m);
          } else {
            if (map.hasLayer(m)) map.removeLayer(m);
          }
        });
      });
    });
  });
</script>
@endsection
