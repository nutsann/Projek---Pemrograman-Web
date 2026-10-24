@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('styles')
<style>
  .profile-page { background: #FFF7E2; min-height: 85vh; padding-bottom: 70px; }

  /* BREADCRUMB */
  .breadcrumb-wrap { padding: 30px 0 15px; }
  .breadcrumb-custom { font-size: 0.9rem; color: #666; }
  .breadcrumb-custom a { color: #105746; text-decoration: none; font-weight: 500; }
  .breadcrumb-custom a:hover { text-decoration: underline; }

  /* TITLE */
  .page-main-title {
    font-size: 2.4rem;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 24px;
    font-family: serif, 'Times New Roman', Times;
  }

  /* PANEL KARTU */
  .custom-panel-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.04);
    border: 1px solid rgba(0,0,0,0.04);
    margin-bottom: 24px;
  }

  /* FOTO PROFIL */
  .avatar-display {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #105746;
    margin-bottom: 16px;
  }
  .avatar-fallback {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: #e0f2ec;
    color: #105746;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 2.8rem;
    font-weight: 800;
    margin-bottom: 16px;
    border: 3px solid #105746;
  }

  .role-pill-badge {
    background: #e0f2ec;
    color: #105746;
    font-weight: 700;
    font-size: 0.8rem;
    padding: 4px 14px;
    border-radius: 20px;
    display: inline-block;
  }

  /* SIDEBAR MENU LINK */
  .profile-nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 18px;
    border-radius: 12px;
    color: #444;
    font-weight: 600;
    text-decoration: none;
    margin-bottom: 8px;
    transition: all 0.18s;
  }
  .profile-nav-link:hover {
    background: #FFF7E2;
    color: #105746;
  }
  .profile-nav-link.active {
    background: #105746;
    color: #ffffff;
  }

  /* FORM STYLES */
  .form-label-custom {
    font-weight: 700;
    font-size: 0.9rem;
    color: #333333;
    margin-bottom: 6px;
  }
  .form-control-custom {
    width: 100%;
    border: 1.5px solid #d5d5d5;
    border-radius: 10px;
    padding: 10px 16px;
    font-size: 0.95rem;
    outline: none;
    transition: border-color 0.2s;
  }
  .form-control-custom:focus {
    border-color: #105746;
    box-shadow: 0 0 0 3px rgba(16,87,70,0.1);
  }

  .btn-save-profile {
    background: #105746;
    color: #ffffff;
    border: none;
    border-radius: 12px;
    padding: 11px 26px;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s;
  }
  .btn-save-profile:hover {
    background: #0d4538;
    color: #ffffff;
  }
</style>
@endsection

@section('content')
<div class="profile-page">

  {{-- BREADCRUMB --}}
  <div class="container breadcrumb-wrap">
    <div class="breadcrumb-custom">
      <a href="{{ route('home') }}">Home</a> &rsaquo;
      <span>Profil Saya</span>
    </div>
  </div>

  <div class="container" style="max-width: 1060px;">
    <h1 class="page-main-title">Pengaturan Akun &amp; Profil</h1>

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
      {{-- SIDEBAR KIRI: KARTU IDENTITAS USER --}}
      <div class="col-lg-4">
        <div class="custom-panel-card text-center">
          @if(Auth::user()->profile_photo)
            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="avatar-display" alt="{{ Auth::user()->name }}">
          @else
            <div class="avatar-fallback">
              {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
          @endif

          <h3 class="fw-bold mb-1 fs-5 text-dark">{{ Auth::user()->name }}</h3>
          <p class="text-muted small mb-2">{{ Auth::user()->email }}</p>
          <div>
            <span class="role-pill-badge">
              {{ Auth::user()->role === 'buyer' ? 'Pembeli / Pelanggan' : (Auth::user()->role === 'seller' ? 'Mitra UMKM' : 'Administrator') }}
            </span>
          </div>
        </div>

        <div class="custom-panel-card p-3">
          <a href="{{ route('profile') }}" class="profile-nav-link active">
            <i class="fas fa-user-circle"></i> Edit Profil
          </a>
          <a href="{{ route('orders.index') }}" class="profile-nav-link">
            <i class="fas fa-shopping-bag"></i> Pesanan Saya
          </a>
          @if(Auth::user()->isSeller())
            <a href="{{ route('umkm.dashboard') }}" class="profile-nav-link">
              <i class="fas fa-store"></i> Dashboard Toko UMKM
            </a>
          @endif
          @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="profile-nav-link">
              <i class="fas fa-solar-panel"></i> Panel Administrator
            </a>
          @endif
        </div>
      </div>

       {{-- KONTEN KANAN: DASHBOARD, FORM EDIT PROFIL & UBAH PASSWORD --}}
       <div class="col-lg-8">
         <div class="row g-3 mb-4">
           @foreach([['Total Order', $orderStats['total'], 'fa-receipt'], ['Order Aktif', $orderStats['active'], 'fa-truck'], ['Order Selesai', $orderStats['completed'], 'fa-check-circle']] as [$label, $value, $icon])
             <div class="col-md-4">
               <div class="custom-panel-card text-center h-100 p-3">
                 <i class="fas {{ $icon }} fs-3 mb-2" style="color:#105746;"></i>
                 <div class="text-muted small">{{ $label }}</div>
                 <div class="fs-3 fw-bold" style="color:#105746;">{{ $value }}</div>
               </div>
             </div>
           @endforeach
         </div>

         <div class="custom-panel-card mb-4">
           <div class="d-flex justify-content-between align-items-center mb-3">
             <h2 class="fs-4 fw-bold mb-0" style="color:#105746;">Order Aktif</h2>
             <a href="{{ route('orders.index') }}" class="small">Lihat semua</a>
           </div>
           @forelse($activeOrders as $order)
             <div class="d-flex justify-content-between align-items-center border-bottom py-2">
               <div>
                 <strong>#{{ $order->order_number }}</strong>
                 <div class="small text-muted">{{ $order->items->count() }} produk · Rp {{ number_format($order->total, 0, ',', '.') }}</div>
               </div>
               <div class="text-end">
                 <span class="badge bg-warning">{{ \App\Models\Order::paymentStatusLabel($order->payment_status) }}</span>
                 <a href="{{ route('orders.show', $order->id) }}" class="d-block small mt-1">Detail</a>
               </div>
             </div>
           @empty
             <p class="text-muted mb-0">Belum ada order aktif.</p>
           @endforelse
         </div>

         <div class="custom-panel-card mb-4">
           <h2 class="fs-4 fw-bold mb-3" style="color:#105746;">Notifikasi Terbaru</h2>
           @forelse($notifications as $notification)
             <div class="small border-bottom py-2">{{ $notification->data['message'] ?? 'Notifikasi baru' }}</div>
           @empty
             <p class="text-muted mb-0">Belum ada notifikasi.</p>
           @endforelse
         </div>
        {{-- EDIT PROFIL --}}
        <div class="custom-panel-card">
          <h2 class="fs-4 fw-bold mb-4" style="color:#105746;">Informasi Pribadi</h2>
          <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label-custom">Nama Lengkap</label>
              <input type="text" name="name" class="form-control-custom @error('name') is-invalid @enderror" value="{{ old('name', Auth::user()->name) }}" required>
              @error('name') <div class="text-danger small mt-1 fw-bold">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label class="form-label-custom">Alamat Email</label>
              <input type="email" name="email" class="form-control-custom @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email) }}" required>
              @error('email') <div class="text-danger small mt-1 fw-bold">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label class="form-label-custom">Nomor Telepon / WhatsApp</label>
              <input type="tel" name="phone" class="form-control-custom @error('phone') is-invalid @enderror" value="{{ old('phone', Auth::user()->phone) }}" placeholder="08xxxxxxxxxx">
              @error('phone') <div class="text-danger small mt-1 fw-bold">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label class="form-label-custom">Alamat Domisili Pengiriman</label>
              <textarea name="address" class="form-control-custom @error('address') is-invalid @enderror" rows="3" placeholder="Alamat lengkap...">{{ old('address', Auth::user()->address) }}</textarea>
              @error('address') <div class="text-danger small mt-1 fw-bold">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
              <label class="form-label-custom">Ganti Foto Profil</label>
              <input type="file" name="profile_photo" class="form-control-custom @error('profile_photo') is-invalid @enderror" accept="image/*">
              @error('profile_photo') <div class="text-danger small mt-1 fw-bold">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn-save-profile">
              Simpan Perubahan
            </button>
          </form>
        </div>

        {{-- UBAH PASSWORD --}}
        <div class="custom-panel-card">
          <h2 class="fs-4 fw-bold mb-4" style="color:#105746;">Keamanan Kata Sandi</h2>
          <form method="POST" action="{{ route('profile.password') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label-custom">Kata Sandi Saat Ini</label>
              <input type="password" name="current_password" class="form-control-custom @error('current_password') is-invalid @enderror" required>
              @error('current_password') <div class="text-danger small mt-1 fw-bold">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
              <label class="form-label-custom">Kata Sandi Baru</label>
              <input type="password" name="new_password" class="form-control-custom @error('new_password') is-invalid @enderror" placeholder="Minimal 6 karakter" required>
              @error('new_password') <div class="text-danger small mt-1 fw-bold">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
              <label class="form-label-custom">Konfirmasi Kata Sandi Baru</label>
              <input type="password" name="new_password_confirmation" class="form-control-custom" placeholder="Ulangi kata sandi baru" required>
            </div>

            <button type="submit" class="btn-save-profile">
              Perbarui Kata Sandi
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
