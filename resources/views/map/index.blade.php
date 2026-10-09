@extends('layouts.app')

@section('title', 'Peta Interaktif')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
  #map { height: 650px; border-radius: 12px; border: 2px solid #e9ecef; }
  .map-legend { position: absolute; bottom: 20px; right: 20px; z-index: 400; background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.15); }
  .legend-item { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
  .legend-dot { width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; box-shadow: 0 1px 4px rgba(0,0,0,0.3); }
  .popup-content img { width: 100%; height: 120px; object-fit: cover; border-radius: 60px; margin-bottom: 8px; }
</style>
@endsection

@section('content')
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Peta Interaktif Tanjungpinang</h2>
    <button onclick="getUserLocation()" class="btn btn-primary btn-sm"><i class="fas fa-location-arrow"></i> Lokasi Saya</button>
  </div>
  <p class="text-muted mb-4">Klik marker wisata/budaya/UMKM untuk melihat info dan membuka <b>Petunjuk Arah (Navigasi)</b> menuju lokasi.</p>
  <div style="position: relative;">
    <div id="map"></div>
    <div class="map-legend">
      <strong class="d-block mb-2">Legend</strong>
      <div class="legend-item"><span class="legend-dot" style="background: #8B4513;"></span> Budaya</div>
      <div class="legend-item"><span class="legend-dot" style="background: #2E5090;"></span> Wisata</div>
      <div class="legend-item"><span class="legend-dot" style="background: #28a745;"></span> UMKM</div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  const map = L.map('map').setView([0.9174, 104.4501], 13);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap' }).addTo(map);

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

  function coloredIcon(color) {
    return L.divIcon({
      className: 'custom-marker',
      html: `<div style="background:${color};width:22px;height:22px;border-radius:50%;border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.4);display:flex;align-items:center;justify-content:center;"></div>`,
      iconSize: [22, 22],
      iconAnchor: [11, 11]
    });
  }

  const cultures = @json($cultures);
  const tourisms = @json($tourisms);
  const umkms = @json($umkms);

  cultures.forEach(c => {
    if(c.latitude && c.longitude) {
      const gmapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${c.latitude},${c.longitude}`;
      L.marker([c.latitude, c.longitude], { icon: coloredIcon('#8B4513') })
        .bindPopup(`
          <div style="min-width: 200px;">
            ${c.image ? `<img src="${c.image}" style="width:100%;height:100px;object-fit:cover;border-radius:6px;margin-bottom:8px;">` : ''}
            <h6 class="mb-1">🏛️ ${c.name}</h6>
            <small class="text-muted d-block mb-2">${c.location}</small>
            <div class="d-grid gap-1">
              <a href="${gmapsUrl}" target="_blank" class="btn btn-sm btn-success text-white"><i class="fas fa-directions"></i> Petunjuk Arah</a>
              <a href="{{ url('/cultures') }}/${c.slug}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
            </div>
          </div>
        `).addTo(map);
    }
  });

  tourisms.forEach(t => {
    if(t.latitude && t.longitude) {
      const gmapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${t.latitude},${t.longitude}`;
      L.marker([t.latitude, t.longitude], { icon: coloredIcon('#2E5090') })
        .bindPopup(`
          <div style="min-width: 200px;">
            ${t.image ? `<img src="${t.image}" style="width:100%;height:100px;object-fit:cover;border-radius:6px;margin-bottom:8px;">` : ''}
            <h6 class="mb-1">🏖️ ${t.name}</h6>
            <small class="text-muted d-block mb-2">${t.location}</small>
            <div class="d-grid gap-1">
              <a href="${gmapsUrl}" target="_blank" class="btn btn-sm btn-success text-white"><i class="fas fa-directions"></i> Petunjuk Arah (Navigasi)</a>
              <a href="{{ url('/tourisms') }}/${t.slug}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
            </div>
          </div>
        `).addTo(map);
    }
  });

  umkms.forEach(u => {
    if(u.latitude && u.longitude) {
      const gmapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${u.latitude},${u.longitude}`;
      L.marker([u.latitude, u.longitude], { icon: coloredIcon('#28a745') })
        .bindPopup(`
          <div style="min-width: 200px;">
            <h6 class="mb-1">🏪 ${u.name}</h6>
            <small class="text-muted d-block mb-2">${u.address}</small>
            <div class="d-grid gap-1">
              <a href="${gmapsUrl}" target="_blank" class="btn btn-sm btn-success text-white"><i class="fas fa-directions"></i> Petunjuk Arah</a>
            </div>
          </div>
        `).addTo(map);
    }
  });

  const allPoints = [...cultures, ...tourisms, ...umkms].filter(p => p.latitude && p.longitude);
  if(allPoints.length > 1) {
    const group = L.featureGroup(allPoints.map(p => L.marker([p.latitude, p.longitude])));
    map.fitBounds(group.getBounds().pad(0.2), { maxZoom: 15 });
  }
</script>
@endsection
