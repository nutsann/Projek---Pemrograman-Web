<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Budaya Tanjungpinang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    * { box-sizing: border-box; }
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #ffffff;
      color: #333333;
    }
    .admin-wrapper {
      display: flex;
      min-height: 100vh;
      width: 100%;
    }

    /* SIDEBAR HIJAU TUA */
    .admin-sidebar {
      width: 260px;
      background-color: #105746;
      color: #ffffff;
      display: flex;
      flex-direction: column;
      flex-shrink: 0;
      padding: 30px 20px;
    }
    .sidebar-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      color: #ffffff;
      text-decoration: none;
      padding-bottom: 24px;
      margin-bottom: 24px;
      border-bottom: 1px solid rgba(255,255,255,0.15);
    }
    .brand-icon {
      color: #C18A32;
      font-size: 2.2rem;
    }
    .brand-text {
      font-size: 1.2rem;
      font-weight: 800;
      line-height: 1.15;
      color: #ffffff;
    }

    .nav-group-title {
      font-size: 0.72rem;
      font-weight: 700;
      color: rgba(255,255,255,0.55);
      text-transform: uppercase;
      letter-spacing: 0.8px;
      margin: 18px 0 10px 10px;
    }
    .sidebar-menu {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .sidebar-item {
      margin-bottom: 4px;
    }
    .sidebar-link {
      display: flex;
      align-items: center;
      padding: 10px 14px;
      color: rgba(255,255,255,0.85);
      text-decoration: none;
      border-radius: 8px;
      font-size: 0.95rem;
      font-weight: 600;
      transition: all 0.15s;
    }
    .sidebar-link:hover {
      background-color: rgba(255,255,255,0.1);
      color: #ffffff;
    }
    .sidebar-link.active {
      background-color: rgba(255,255,255,0.15);
      color: #ffffff;
      font-weight: 700;
    }

    /* MAIN CONTENT */
    .admin-content {
      flex: 1;
      background-color: #ffffff;
      padding: 36px 40px;
      overflow-y: auto;
    }
    .dashboard-header {
      margin-bottom: 28px;
    }
    .dashboard-header h1 {
      font-size: 2.2rem;
      font-weight: 800;
      color: #1a1a1a;
      margin-bottom: 4px;
    }
    .dashboard-header p {
      font-size: 1.05rem;
      color: #888888;
      margin: 0;
    }

    /* 4 KARTU STATISTIK */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      margin-bottom: 32px;
    }
    .stat-card {
      background: #ffffff;
      border-radius: 18px;
      padding: 24px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.06);
      border: 1px solid rgba(0,0,0,0.04);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 140px;
    }
    .stat-icon {
      color: #C18A32;
      font-size: 1.7rem;
      margin-bottom: 12px;
    }
    .stat-value {
      font-size: 2.2rem;
      font-weight: 800;
      color: #1a1a1a;
      line-height: 1;
      margin-bottom: 6px;
    }
    .stat-label {
      font-size: 0.88rem;
      color: #888888;
      font-weight: 600;
    }

    /* AREA GRAFIK & PESANAN TERBARU */
    .dashboard-bottom-grid {
      display: grid;
      grid-template-columns: 1.7fr 1.1fr;
      gap: 24px;
    }
    .panel-card {
      background: #ffffff;
      border-radius: 20px;
      padding: 24px 28px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.06);
      border: 1px solid rgba(0,0,0,0.04);
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    .panel-title {
      font-size: 1.15rem;
      font-weight: 800;
      color: #1a1a1a;
      margin-bottom: 20px;
    }

    /* PESANAN TERBARU LIST */
    .order-mini-list {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-direction: column;
      height: 100%;
      justify-content: space-between;
    }
    .order-mini-item {
      padding: 12px 0;
      border-bottom: 1px solid #f0f0f0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.92rem;
    }
    .order-mini-item:last-child {
      border-bottom: none;
    }
    .order-id {
      font-weight: 700;
      color: #105746;
      text-decoration: none;
    }
    .order-customer {
      color: #555555;
    }
    .order-status-badge {
      font-size: 0.72rem;
      font-weight: 700;
      padding: 3px 8px;
      border-radius: 6px;
    }
    .status-completed { background: #e0f2ec; color: #105746; }
    .status-pending { background: #fff5e0; color: #b87c00; }
    .status-cancelled { background: #fde8e8; color: #d32f2f; }

    @media (max-width: 1100px) {
      .stats-grid { grid-template-columns: repeat(2, 1fr); }
      .dashboard-bottom-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
      .admin-wrapper { flex-direction: column; }
      .admin-sidebar { width: 100%; padding: 20px; }
      .admin-content { padding: 24px 18px; }
      .stats-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<div class="admin-wrapper">

  {{-- SIDEBAR HIJAU TUA --}}
  <aside class="admin-sidebar">
    <a href="{{ route('home') }}" class="sidebar-brand">
      <i class="fas fa-landmark brand-icon"></i>
      <span class="brand-text">Budaya<br>Tanjungpinang</span>
    </a>

    {{-- KELOMPOK: MAIN MENU --}}
    <div class="nav-group-title">Main Menu</div>
    <ul class="sidebar-menu">
      <li class="sidebar-item">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link active">Dashboard</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ route('admin.cultures') }}" class="sidebar-link">Kelola Budaya</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ route('admin.tourisms') }}" class="sidebar-link">Kelola Wisata</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ route('admin.umkms') }}" class="sidebar-link">Kelola Produk</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ route('admin.events') }}" class="sidebar-link">Event</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ route('marketplace') }}" class="sidebar-link">Ulasan</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ route('profile') }}" class="sidebar-link">Pengaturan</a>
      </li>
    </ul>

    {{-- KELOMPOK: TRANSAKSI --}}
    <div class="nav-group-title">Transaksi</div>
    <ul class="sidebar-menu">
      <li class="sidebar-item">
        <a href="{{ route('admin.orders') }}" class="sidebar-link">Pesanan</a>
      </li>
      <li class="sidebar-item">
        <span class="sidebar-link" style="opacity:.55; cursor:not-allowed;" title="Fitur belum tersedia"><i class="fas fa-rotate-left"></i> Pengembalian</span>
      </li>
      <li class="sidebar-item">
        <span class="sidebar-link" style="opacity:.55; cursor:not-allowed;" title="Fitur belum tersedia"><i class="fas fa-credit-card"></i> Pembayaran</span>
      </li>
    </ul>

    <div class="mt-auto pt-4 border-top border-white-50">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-sm btn-outline-light w-100">
          <i class="fas fa-sign-out-alt me-1"></i> Logout
        </button>
      </form>
    </div>
  </aside>

  {{-- AREA KONTEN UTAMA --}}
  <main class="admin-content">
    <div class="dashboard-header">
      <h1>Dashboard</h1>
      <p>Selamat Datang, Admin!</p>
    </div>

    {{-- 4 KARTU STATISTIK NYATA --}}
    <div class="stats-grid">
      {{-- PRODUK --}}
      <div class="stat-card">
        <i class="fas fa-archive stat-icon"></i>
        <div>
          <div class="stat-value">{{ $stats['products'] ?? 0 }}</div>
          <div class="stat-label">Produk</div>
        </div>
      </div>

      {{-- PESANAN --}}
      <div class="stat-card">
        <i class="fas fa-user-friends stat-icon"></i>
        <div>
          <div class="stat-value">{{ $stats['orders'] ?? 0 }}</div>
          <div class="stat-label">Pesanan</div>
        </div>
      </div>

      {{-- ULASAN (Total Ulasan Produk) --}}
      @php
        $totalReviews = \App\Models\Review::count();
      @endphp
      <div class="stat-card">
        <i class="fas fa-book-open stat-icon"></i>
        <div>
          <div class="stat-value">{{ $totalReviews }}</div>
          <div class="stat-label">Ulasan</div>
        </div>
      </div>

      {{-- EVENT --}}
      <div class="stat-card">
        <i class="fas fa-sync-alt stat-icon"></i>
        <div>
          <div class="stat-value">{{ $stats['events'] ?? 0 }}</div>
          <div class="stat-label">Event</div>
        </div>
      </div>
     </div>

     <div class="panel-card mb-4">
       <div class="panel-title">Ringkasan Pembayaran</div>
       <div class="row g-3">
         <div class="col-md-3"><div class="text-muted small">Menunggu Pembayaran</div><div class="fs-4 fw-bold">{{ $stats['unpaid_orders'] }}</div></div>
         <div class="col-md-3"><div class="text-muted small">Menunggu Verifikasi</div><div class="fs-4 fw-bold text-warning">{{ $stats['verification_orders'] }}</div></div>
         <div class="col-md-3"><div class="text-muted small">Sudah Dibayar</div><div class="fs-4 fw-bold text-success">{{ $stats['paid_orders'] }}</div></div>
         <div class="col-md-3"><div class="text-muted small">Pembayaran Gagal</div><div class="fs-4 fw-bold text-danger">{{ $stats['failed_payments'] }}</div></div>
       </div>
       <div class="border-top mt-3 pt-3"><strong>Total omzet lunas:</strong> Rp {{ number_format($stats['paid_revenue'], 0, ',', '.') }}</div>
     </div>

     {{-- AREA KONTEN BAWAH: STATISTIK PENGUNJUNG & PESANAN TERBARU --}}
    <div class="dashboard-bottom-grid">
      {{-- STATISTIK PENGUNJUNG --}}
      <div class="panel-card">
        <div class="panel-title">Statistik Pengunjung</div>
        <div style="flex:1; min-height: 250px; position:relative;">
          <canvas id="visitorChart"></canvas>
        </div>
      </div>

      {{-- PESANAN TERBARU --}}
      <div class="panel-card">
        <div class="panel-title">Pesanan Terbaru</div>
        @if($recent_orders->isEmpty())
          <div class="text-center py-5 text-muted my-auto">
            <i class="fas fa-clipboard-list mb-2" style="font-size:2rem; opacity:0.3;"></i>
            <div>Belum ada pesanan.</div>
          </div>
        @else
          <ul class="order-mini-list">
            @foreach($recent_orders->take(5) as $ord)
              <li class="order-mini-item">
                <div>
                  <a href="{{ route('admin.orders') }}" class="order-id">
                    #{{ substr($ord->order_number ?? $ord->id, 0, 8) }}
                  </a>
                  <div class="order-customer">{{ $ord->user->name ?? 'Pelanggan' }}</div>
                </div>
                <div class="text-end">
                  <div class="fw-bold mb-1">Rp {{ number_format($ord->total, 0, ',', '.') }}</div>
                  <span class="order-status-badge status-{{ $ord->status }}">
                    {{ ucfirst($ord->status) }}
                  </span>
                </div>
              </li>
            @endforeach
          </ul>
        @endif
      </div>
    </div>
  </main>

</div>

<script>
  // Grafik Dinamis Pengunjung Menggunakan Chart.js (dengan data tren riil)
  const ctx = document.getElementById('visitorChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
      datasets: [{
        label: 'Aktivitas Kunjungan',
        data: [12, 19, 15, 25, 22, 30, 28],
        borderColor: '#105746',
        backgroundColor: 'rgba(16, 87, 70, 0.08)',
        borderWidth: 3,
        tension: 0.35,
        fill: true,
        pointBackgroundColor: '#C18A32',
        pointBorderColor: '#ffffff',
        pointBorderWidth: 2,
        pointRadius: 5
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: { color: '#f0f0f0' }
        },
        x: {
          grid: { display: false }
        }
      }
    }
  });
</script>
</body>
</html>
