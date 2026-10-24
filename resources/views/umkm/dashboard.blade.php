<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Mitra UMKM - {{ $umkm->name }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    .seller-wrapper {
      display: flex;
      min-height: 100vh;
      width: 100%;
    }

    /* SIDEBAR HIJAU TUA */
    .seller-sidebar {
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
      margin-bottom: 20px;
      border-bottom: 1px solid rgba(255,255,255,0.15);
    }
    .brand-icon {
      color: #C18A32;
      font-size: 2rem;
    }
    .brand-text {
      font-size: 1.15rem;
      font-weight: 800;
      line-height: 1.15;
      color: #ffffff;
    }

    .store-badge {
      background: rgba(255,255,255,0.12);
      border-radius: 12px;
      padding: 12px 14px;
      margin-bottom: 20px;
      font-size: 0.85rem;
    }
    .store-badge-name {
      font-weight: 700;
      color: #ffffff;
      margin-bottom: 2px;
    }
    .store-badge-status {
      font-size: 0.75rem;
      color: #a3e6cd;
      font-weight: 600;
    }

    .sidebar-menu {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    .sidebar-item {
      margin-bottom: 6px;
    }
    .sidebar-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 11px 16px;
      color: rgba(255,255,255,0.85);
      text-decoration: none;
      border-radius: 10px;
      font-size: 0.95rem;
      font-weight: 600;
      transition: all 0.15s;
    }
    .sidebar-link:hover {
      background-color: rgba(255,255,255,0.1);
      color: #ffffff;
    }
    .sidebar-link.active {
      background-color: rgba(255,255,255,0.18);
      color: #ffffff;
      font-weight: 700;
    }

    /* MAIN CONTENT */
    .seller-content {
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

    /* KARTU STATISTIK */
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

    /* BOTTOM GRID */
    .dashboard-bottom-grid {
      display: grid;
      grid-template-columns: 1.6fr 1.1fr;
      gap: 24px;
    }
    .panel-card {
      background: #ffffff;
      border-radius: 20px;
      padding: 26px 28px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.06);
      border: 1px solid rgba(0,0,0,0.04);
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    .panel-header-wrap {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    .panel-title {
      font-size: 1.2rem;
      font-weight: 800;
      color: #1a1a1a;
      margin: 0;
    }
    .panel-link-all {
      font-size: 0.88rem;
      font-weight: 700;
      color: #105746;
      text-decoration: none;
    }
    .panel-link-all:hover {
      text-decoration: underline;
    }

    /* LIST ORDERS */
    .order-item-box {
      padding: 14px 0;
      border-bottom: 1px solid #f0f0f0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.95rem;
    }
    .order-item-box:last-child { border-bottom: none; }
    .order-code { font-weight: 800; color: #105746; }
    .order-date { font-size: 0.8rem; color: #888; margin-top: 2px; }

    .status-badge {
      font-size: 0.72rem;
      font-weight: 700;
      padding: 3px 10px;
      border-radius: 6px;
      text-transform: uppercase;
    }
    .status-pending { background: #fff5e0; color: #b87c00; }
    .status-processing { background: #e0edff; color: #1f64c4; }
    .status-completed { background: #e0f2ec; color: #105746; }

    /* BTN TAMBAH */
    .btn-add-product {
      background: #105746;
      color: #ffffff;
      border: none;
      border-radius: 10px;
      padding: 8px 16px;
      font-size: 0.88rem;
      font-weight: 700;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: background 0.2s;
    }
    .btn-add-product:hover {
      background: #0d4538;
      color: #ffffff;
    }

    @media (max-width: 1100px) {
      .stats-grid { grid-template-columns: repeat(2, 1fr); }
      .dashboard-bottom-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
      .seller-wrapper { flex-direction: column; }
      .seller-sidebar { width: 100%; padding: 20px; }
      .seller-content { padding: 24px 18px; }
      .stats-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<div class="seller-wrapper">

  {{-- SIDEBAR MITRA UMKM --}}
  <aside class="seller-sidebar">
    <a href="{{ route('home') }}" class="sidebar-brand">
      <i class="fas fa-landmark brand-icon"></i>
      <span class="brand-text">Budaya<br>Tanjungpinang</span>
    </a>

    {{-- KARTU INFO TOKO --}}
    <div class="store-badge">
      <div class="store-badge-name">{{ $umkm->name }}</div>
      <div class="store-badge-status">
        <i class="fas fa-check-circle me-1"></i> Mitra Terverifikasi
      </div>
    </div>

    <ul class="sidebar-menu">
      <li class="sidebar-item">
        <a href="{{ route('umkm.dashboard') }}" class="sidebar-link active">
          <i class="fas fa-chart-pie"></i> Dashboard
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ route('umkm.products') }}" class="sidebar-link">
          <i class="fas fa-box"></i> Produk Saya
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ route('umkm.products.create') }}" class="sidebar-link">
          <i class="fas fa-plus-circle"></i> Tambah Produk
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ route('umkm.orders') }}" class="sidebar-link">
          <i class="fas fa-shopping-bag"></i> Pesanan Masuk
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ route('home') }}" class="sidebar-link">
          <i class="fas fa-globe"></i> Halaman Publik
        </a>
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

  {{-- AREA KONTEN SELLER --}}
  <main class="seller-content">
    <div class="dashboard-header d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        <h1>Dashboard UMKM</h1>
        <p>Kelola etalase produk dan pantau pesanan toko Anda.</p>
      </div>
      <div>
        <a href="{{ route('umkm.products.create') }}" class="btn-add-product">
          <i class="fas fa-plus"></i> Tambah Produk Baru
        </a>
      </div>
    </div>

    {{-- 4 KARTU STATISTIK TOKO --}}
    <div class="stats-grid">
      <div class="stat-card">
        <i class="fas fa-box-open stat-icon"></i>
        <div>
          <div class="stat-value">{{ $stats['products'] ?? 0 }}</div>
          <div class="stat-label">Total Produk</div>
        </div>
      </div>

      <div class="stat-card">
        <i class="fas fa-shopping-cart stat-icon"></i>
        <div>
          <div class="stat-value">{{ $stats['orders'] ?? 0 }}</div>
          <div class="stat-label">Total Pesanan</div>
        </div>
      </div>

      <div class="stat-card">
        <i class="fas fa-clock stat-icon"></i>
        <div>
          <div class="stat-value">{{ $stats['pending_orders'] ?? 0 }}</div>
          <div class="stat-label">Pesanan Perlu Diproses</div>
        </div>
      </div>

      <div class="stat-card">
        <i class="fas fa-coins stat-icon"></i>
        <div>
          <div class="stat-value" style="font-size:1.7rem; color:#105746;">
            Rp {{ number_format($stats['total_sales'] ?? 0, 0, ',', '.') }}
          </div>
          <div class="stat-label">Total Penjualan</div>
        </div>
      </div>
    </div>

    {{-- GRID BAWAH: PESANAN TERBARU & PROFIL TOKO --}}
    <div class="dashboard-bottom-grid">
      {{-- PESANAN TERBARU MASUK --}}
      <div class="panel-card">
        <div class="panel-header-wrap">
          <h2 class="panel-title">Pesanan Masuk Terbaru</h2>
          <a href="{{ route('umkm.orders') }}" class="panel-link-all">Lihat Semua</a>
        </div>

        @if($recent_orders->isEmpty())
          <div class="text-center py-5 text-muted my-auto">
            <i class="fas fa-shopping-bag mb-2" style="font-size:2.2rem; opacity:0.3;"></i>
            <div>Belum ada pesanan masuk untuk produk Anda.</div>
          </div>
        @else
          <div>
            @foreach($recent_orders as $ord)
              <div class="order-item-box">
                <div>
                  <div class="order-code">#{{ $ord->order_number }}</div>
                  <div class="order-date">{{ $ord->created_at->translatedFormat('d M Y, H:i') }} WIB</div>
                </div>
                <div class="text-end">
                  <div class="fw-bold mb-1">Rp {{ number_format($ord->total, 0, ',', '.') }}</div>
                  <span class="status-badge status-{{ $ord->status }}">
                    {{ ucfirst($ord->status) }}
                  </span>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>

      {{-- RINGKASAN PROFIL TOKO --}}
      <div class="panel-card">
        <div class="panel-header-wrap">
          <h2 class="panel-title">Profil Toko / UMKM</h2>
        </div>

        <div style="font-size:0.95rem;">
          <div class="mb-3">
            <div class="text-muted small fw-bold text-uppercase">Nama Toko</div>
            <div class="fw-bold fs-5 text-dark">{{ $umkm->name }}</div>
          </div>
          <div class="mb-3">
            <div class="text-muted small fw-bold text-uppercase">Alamat</div>
            <div class="text-dark">{{ $umkm->address }}</div>
          </div>
          <div class="mb-3">
            <div class="text-muted small fw-bold text-uppercase">Kontak / WhatsApp</div>
            <div class="text-dark"><i class="fas fa-phone-alt me-1 text-success"></i> {{ $umkm->phone }}</div>
          </div>
          <div class="mb-3">
            <div class="text-muted small fw-bold text-uppercase">Email Usaha</div>
            <div class="text-dark"><i class="fas fa-envelope me-1 text-muted"></i> {{ $umkm->email }}</div>
          </div>
          <hr class="my-3">
          <a href="{{ route('umkm.products') }}" class="btn btn-outline-success w-100 fw-bold" style="border-radius:10px;">
            <i class="fas fa-boxes me-1"></i> Buka Katalog Produk Toko
          </a>
        </div>
      </div>
    </div>
  </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
