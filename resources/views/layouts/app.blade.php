<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - Platform Digital Budaya Tanjungpinang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root { --primary: #105746; --secondary: #C18A32; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; background-color: #FFF7E2; }
    .navbar { background: #105746 !important; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .navbar-brand { font-weight: 700; font-size: 1.5rem; color: white !important; }
    .nav-link { color: rgba(255,255,255,0.9) !important; transition: color 0.3s; }
    .nav-link:hover { color: var(--secondary) !important; }
    .hero { background: linear-gradient(135deg, var(--primary) 0%, #1a7a62 100%); color: white; padding: 100px 0; text-align: center; }
    .hero h1 { font-size: 3rem; font-weight: 700; margin-bottom: 20px; }
    .hero p { font-size: 1.3rem; margin-bottom: 30px; opacity: 0.95; }
    .btn-primary { background: #105746 !important; border-color: #105746 !important; color: #fff !important; }
    .btn-primary:hover { background: #0d4538 !important; border-color: #0d4538 !important; }
    .card { border: none; background-color: #ffffff; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
    .section-title { color: var(--primary); font-weight: 700; font-size: 2rem; margin-bottom: 40px; }
    footer { background: var(--primary); color: white; padding: 40px 0; }
    .rating { color: #FFB81C; }
  </style>
  @yield('styles')
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
      <a class="navbar-brand" href="{{ route('home') }}"><i class="fas fa-landmark me-1"></i>Budaya Tanjungpinang</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('cultures') }}">Budaya</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('tourisms') }}">Wisata</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('marketplace') }}">Marketplace</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('events') }}">Event</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('map') }}">Peta</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Tentang</a></li>
        </ul>
        <ul class="navbar-nav ms-auto align-items-center">
           @auth
             <li class="nav-item dropdown">
               <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-label="Notifikasi">
                 <i class="fas fa-bell"></i>
                 @if(Auth::user()->unreadNotifications()->count())
                   <span class="badge bg-danger">{{ Auth::user()->unreadNotifications()->count() }}</span>
                 @endif
               </a>
               <ul class="dropdown-menu dropdown-menu-end">
                 @forelse(Auth::user()->notifications()->latest()->limit(5)->get() as $notification)
                   <li><span class="dropdown-item-text small">{{ $notification->data['message'] }}</span></li>
                 @empty
                   <li><span class="dropdown-item-text small text-muted">Belum ada notifikasi.</span></li>
                 @endforelse
                 <li><hr class="dropdown-divider"></li>
                 <li><a class="dropdown-item text-center" href="{{ route('notifications') }}">Lihat semua notifikasi</a></li>
               </ul>
             </li>
             <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
              <ul class="dropdown-menu dropdown-menu-end">
                @if(Auth::user()->isAdmin())
                  <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
                @elseif(Auth::user()->isSeller())
                  <li><a class="dropdown-item" href="{{ route('umkm.dashboard') }}">Dashboard UMKM</a></li>
                @endif
                <li><a class="dropdown-item" href="{{ route('profile') }}">Profil</a></li>
                <li><a class="dropdown-item" href="{{ route('orders.index') }}">Pesanan Saya</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><form method="POST" action="{{ route('logout') }}" style="display:inline;">@csrf<button type="submit" class="dropdown-item">Logout</button></form></li>
              </ul>
            </li>
          @else
            <li class="nav-item me-1">
              <a class="nav-link btn btn-outline-light btn-sm px-3" href="{{ route('login') }}" style="border-radius:6px;">Masuk</a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-sm px-3" href="{{ route('register') }}" style="background:#C18A32;color:#fff;border-radius:6px;">Daftar</a>
            </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  @if($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
      {{ $message }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  @if($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
      {{ $message }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @yield('content')

  <footer class="mt-5">
    <div class="container">
      <div class="row gy-4">
        <div class="col-md-4">
          <h5 class="fw-bold mb-2"><i class="fas fa-landmark me-1"></i> Budaya Tanjungpinang</h5>
          <p class="text-white-50" style="font-size:0.9rem;">Platform digital budaya, wisata, dan UMKM Kota Tanjungpinang. Melestarikan warisan Melayu untuk generasi mendatang.</p>
        </div>
        <div class="col-md-2">
          <h6 class="fw-bold mb-2">Navigasi</h6>
          <ul class="list-unstyled" style="font-size:0.9rem;">
            <li><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Home</a></li>
            <li><a href="{{ route('cultures') }}" class="text-white-50 text-decoration-none">Budaya</a></li>
            <li><a href="{{ route('tourisms') }}" class="text-white-50 text-decoration-none">Wisata</a></li>
            <li><a href="{{ route('events') }}" class="text-white-50 text-decoration-none">Event</a></li>
            <li><a href="{{ route('map') }}" class="text-white-50 text-decoration-none">Peta</a></li>
            <li><a href="{{ route('marketplace') }}" class="text-white-50 text-decoration-none">Marketplace</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h6 class="fw-bold mb-2">Kontak</h6>
          <ul class="list-unstyled text-white-50" style="font-size:0.9rem;">
            <li><i class="fas fa-envelope me-2"></i>info@budayatanjungpinang.id</li>
            <li class="mt-1"><i class="fas fa-phone me-2"></i>+62 771 123 456</li>
            <li class="mt-1"><i class="fas fa-map-marker-alt me-2"></i>Tanjungpinang, Kepulauan Riau</li>
          </ul>
        </div>
        <div class="col-md-3">
          <h6 class="fw-bold mb-2">Ikuti Kami</h6>
          <div class="d-flex gap-3" style="font-size:1.3rem;">
            <a href="#" class="text-white-50"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-white-50"><i class="fab fa-facebook"></i></a>
            <a href="#" class="text-white-50"><i class="fab fa-youtube"></i></a>
            <a href="#" class="text-white-50"><i class="fab fa-tiktok"></i></a>
          </div>
        </div>
      </div>
      <hr style="border-color:rgba(255,255,255,0.15);margin-top:32px;">
      <div class="text-center text-white-50" style="font-size:0.85rem;">
        <p class="mb-0">&copy; 2026 Platform Digital Budaya Tanjungpinang. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @yield('scripts')
</body>
</html>
