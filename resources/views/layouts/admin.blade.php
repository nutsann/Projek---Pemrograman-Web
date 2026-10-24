<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Panel') - Budaya Tanjungpinang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * { box-sizing: border-box; }
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #fcfbf7;
      color: #333333;
    }
    .admin-wrapper {
      display: flex;
      min-height: 100vh;
      width: 100%;
    }

    /* SIDEBAR */
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
      margin-bottom: 20px;
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
      background-color: rgba(255,255,255,0.18);
      color: #ffffff;
      font-weight: 700;
    }

    /* MAIN CONTENT */
    .admin-content {
      flex: 1;
      padding: 36px 40px;
      overflow-y: auto;
    }
    .page-header-box {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 28px;
      flex-wrap: wrap;
      gap: 16px;
    }
    .page-header-title {
      font-size: 2rem;
      font-weight: 800;
      color: #1a1a1a;
      margin: 0;
    }
    .btn-create-item {
      background: #105746;
      color: #ffffff;
      border: none;
      border-radius: 10px;
      padding: 10px 22px;
      font-weight: 700;
      font-size: 0.95rem;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: background 0.2s;
    }
    .btn-create-item:hover {
      background: #0d4538;
      color: #ffffff;
    }

    /* CARD TABLE */
    .admin-table-card {
      background: #ffffff;
      border-radius: 20px;
      padding: 24px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      border: 1px solid rgba(0,0,0,0.04);
    }
    .table thead th {
      font-weight: 700;
      font-size: 0.85rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #666;
      border-bottom: 2px solid #f0f0f0;
      padding: 12px 14px;
    }
    .table tbody td {
      padding: 14px;
      vertical-align: middle;
      font-size: 0.92rem;
      border-bottom: 1px solid #f8f8f8;
    }

    @media (max-width: 768px) {
      .admin-wrapper { flex-direction: column; }
      .admin-sidebar { width: 100%; padding: 20px; }
      .admin-content { padding: 24px 18px; }
    }
  </style>
  @yield('admin_styles')
</head>
<body>

<div class="admin-wrapper">

  {{-- SIDEBAR HIJAU TUA SESUAI FIGMA --}}
  <aside class="admin-sidebar">
    <a href="{{ route('home') }}" class="sidebar-brand">
      <i class="fas fa-landmark brand-icon"></i>
      <span class="brand-text">Budaya<br>Tanjungpinang</span>
    </a>

    {{-- KELOMPOK: MAIN MENU --}}
    <div class="nav-group-title">Main Menu</div>
    <ul class="sidebar-menu">
      <li class="sidebar-item">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ route('admin.cultures') }}" class="sidebar-link {{ request()->routeIs('admin.cultures*') ? 'active' : '' }}">Kelola Budaya</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ route('admin.tourisms') }}" class="sidebar-link {{ request()->routeIs('admin.tourisms*') ? 'active' : '' }}">Kelola Wisata</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ route('admin.umkms') }}" class="sidebar-link {{ request()->routeIs('admin.umkms*') ? 'active' : '' }}">Kelola Produk</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ route('admin.events') }}" class="sidebar-link {{ request()->routeIs('admin.events*') ? 'active' : '' }}">Event</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ route('admin.reviews') }}" class="sidebar-link {{ request()->routeIs('admin.reviews') ? 'active' : '' }}">Ulasan</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ route('profile') }}" class="sidebar-link">Pengaturan</a>
      </li>
    </ul>

    {{-- KELOMPOK: TRANSAKSI --}}
    <div class="nav-group-title">Transaksi</div>
    <ul class="sidebar-menu">
      <li class="sidebar-item">
        <a href="{{ route('admin.orders') }}" class="sidebar-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">Pesanan</a>
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

  {{-- AREA KONTEN --}}
  <main class="admin-content">
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

    @yield('admin_content')
  </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('admin_scripts')
</body>
</html>
