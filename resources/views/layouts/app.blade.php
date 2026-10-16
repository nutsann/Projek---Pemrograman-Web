<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') - Platform Digital Budaya Tanjungpinang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root { --primary: #8B4513; --secondary: #D4A574; --accent: #2E5090; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; }
    .navbar { background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%); box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .navbar-brand { font-weight: 700; font-size: 1.5rem; color: white !important; }
    .nav-link { color: rgba(255,255,255,0.9) !important; transition: color 0.3s; }
    .nav-link:hover { color: var(--secondary) !important; }
    .hero { background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%); color: white; padding: 100px 0; text-align: center; }
    .hero h1 { font-size: 3rem; font-weight: 700; margin-bottom: 20px; }
    .hero p { font-size: 1.3rem; margin-bottom: 30px; opacity: 0.95; }
    .btn-primary { background: var(--primary); border: none; }
    .btn-primary:hover { background: #6B3410; }
    .card { border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s; }
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
      <a class="navbar-brand" href="{{ route('home') }}"><i class="fas fa-landmark"></i> Budaya Tanjungpinang</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('cultures') }}">Budaya</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('tourisms') }}">Wisata</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('events') }}">Event</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('map') }}">Peta</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('marketplace') }}">Marketplace</a></li>
          @auth
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
              <ul class="dropdown-menu">
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
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
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
      <div class="row">
        <div class="col-md-4">
          <h5>Budaya Tanjungpinang</h5>
          <p>Platform digital budaya, wisata, dan UMKM Tanjungpinang</p>
        </div>
        <div class="col-md-4">
          <h5>Menu</h5>
          <ul class="list-unstyled">
            <li><a href="{{ route('cultures') }}" class="text-white-50">Budaya</a></li>
            <li><a href="{{ route('tourisms') }}" class="text-white-50">Wisata</a></li>
            <li><a href="{{ route('events') }}" class="text-white-50">Event</a></li>
            <li><a href="{{ route('marketplace') }}" class="text-white-50">Marketplace</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h5>Kontak</h5>
          <p class="text-white-50">Email: info@budayatanjungpinang.id<br>Phone: +62 123 456 7890</p>
        </div>
      </div>
      <hr class="bg-white-50">
      <div class="text-center text-white-50">
        <p>&copy; 2026 Platform Digital Budaya Tanjungpinang. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @yield('scripts')
</body>
</html>
