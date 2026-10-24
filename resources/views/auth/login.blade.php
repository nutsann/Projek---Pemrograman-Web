<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Platform Digital Budaya Tanjungpinang</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * { box-sizing: border-box; }
    body, html {
      height: 100%;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #ffffff;
    }
    .auth-wrapper {
      display: flex;
      min-height: 100vh;
      width: 100%;
    }
    /* PANEL KIRI (45% LEBAR) */
    .auth-side-green {
      width: 45%;
      background: #105746;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 48px;
      color: #ffffff;
    }
    .brand-logo-white {
      font-size: 1.4rem;
      font-weight: 700;
      color: #ffffff;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 10px;
    }

    /* PANEL KANAN (55% LEBAR) */
    .auth-side-form {
      width: 55%;
      background: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 24px;
    }
    .auth-form-inner {
      width: 100%;
      max-width: 440px;
    }

    /* TABS */
    .auth-nav-tabs {
      display: flex;
      border-bottom: 2px solid #e5e5e5;
      margin-bottom: 36px;
    }
    .auth-tab-item {
      flex: 1;
      text-align: center;
      padding-bottom: 12px;
      font-size: 1.35rem;
      font-weight: 700;
      color: #999999;
      text-decoration: none;
      position: relative;
      transition: color 0.2s;
    }
    .auth-tab-item.active {
      color: #1a1a1a;
    }
    .auth-tab-item.active::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 100%;
      height: 4px;
      background: #105746;
      border-radius: 4px;
    }

    /* HEADINGS */
    .auth-title {
      font-size: 1.85rem;
      font-weight: 800;
      color: #1a1a1a;
      text-align: center;
      margin-bottom: 8px;
    }
    .auth-subtitle {
      font-size: 0.95rem;
      color: #777777;
      text-align: center;
      margin-bottom: 32px;
    }

    /* INPUT FIELDS */
    .form-group-custom {
      margin-bottom: 18px;
    }
    .form-group-custom label {
      display: block;
      font-size: 0.95rem;
      font-weight: 700;
      color: #1a1a1a;
      margin-bottom: 8px;
    }
    .form-control-custom {
      width: 100%;
      height: 48px;
      border: 1.5px solid #d5d5d5;
      border-radius: 8px;
      padding: 0 16px;
      font-size: 0.92rem;
      outline: none;
      transition: border-color 0.2s;
      color: #333;
    }
    .form-control-custom:focus {
      border-color: #105746;
    }
    .form-control-custom::placeholder {
      color: #a8a8a8;
      font-size: 0.88rem;
    }

    /* FORGOT PASSWORD LINK */
    .forgot-link-wrap {
      text-align: right;
      margin-top: -6px;
      margin-bottom: 24px;
    }
    .forgot-link {
      color: #105746;
      font-size: 0.88rem;
      font-weight: 700;
      text-decoration: none;
    }
    .forgot-link:hover {
      text-decoration: underline;
    }

    /* SUBMIT BUTTON */
    .btn-auth-submit {
      width: 100%;
      height: 50px;
      background: #105746;
      color: #ffffff;
      border: none;
      border-radius: 10px;
      font-size: 1.1rem;
      font-weight: 700;
      cursor: pointer;
      transition: background 0.2s;
    }
    .btn-auth-submit:hover {
      background: #0d4538;
    }

    /* DIVIDER */
    .auth-divider {
      display: flex;
      align-items: center;
      text-align: center;
      margin: 24px 0;
      color: #888888;
      font-size: 0.85rem;
    }
    .auth-divider::before, .auth-divider::after {
      content: '';
      flex: 1;
      border-bottom: 1px solid #e0e0e0;
    }
    .auth-divider span {
      padding: 0 14px;
    }

    /* SOCIAL BUTTONS */
    .social-btn-row {
      display: flex;
      gap: 16px;
    }
    .btn-social {
      flex: 1;
      height: 46px;
      background: #ffffff;
      border: 1.5px solid #d5d5d5;
      border-radius: 10px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      font-size: 0.95rem;
      font-weight: 700;
      color: #333333;
      text-decoration: none;
      cursor: pointer;
      transition: background 0.15s, border-color 0.15s;
    }
    .btn-social:hover {
      border-color: #105746;
      background: #fafafa;
    }

    @media (max-width: 860px) {
      .auth-side-green { display: none; }
      .auth-side-form { width: 100%; min-height: 100vh; }
    }
  </style>
</head>
<body>

<div class="auth-wrapper">

  {{-- PANEL KIRI: HIJAU TUA (45%) --}}
  <div class="auth-side-green">
    <div>
      <a href="{{ route('home') }}" class="brand-logo-white">
        <i class="fas fa-landmark"></i> Budaya Tanjungpinang
      </a>
    </div>
    <div>
      <h2 style="font-size:2rem; font-weight:800; line-height:1.3; margin-bottom:12px;">Warisan Melayu,<br>Pesona Masa Depan.</h2>
      <p style="opacity:0.85; font-size:1rem; margin:0;">Platform digital budaya, wisata, dan UMKM lokal Kota Tanjungpinang.</p>
    </div>
    <div style="font-size:0.85rem; opacity:0.7;">
      &copy; {{ date('Y') }} Budaya Tanjungpinang. All rights reserved.
    </div>
  </div>

  {{-- PANEL KANAN: PUTIH (55%) --}}
  <div class="auth-side-form">
    <div class="auth-form-inner">

      {{-- TAB LOGIN & DAFTAR --}}
      <div class="auth-nav-tabs">
        <a href="{{ route('login') }}" class="auth-tab-item active">Login</a>
        <a href="{{ route('register') }}" class="auth-tab-item">Daftar</a>
      </div>

      {{-- HEADER FORM --}}
      <h1 class="auth-title">Masuk ke Akun Anda</h1>
      <p class="auth-subtitle">Lanjutkan perjalanan Budaya bersama Kami!</p>

      {{-- ALERT NOTIFIKASI --}}
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
          @foreach($errors->all() as $err)
            <div>{{ $err }}</div>
          @endforeach
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      {{-- FORM LOGIN --}}
      <form method="POST" action="{{ route('login.post') }}">
        @csrf

        {{-- EMAIL / USERNAME --}}
        <div class="form-group-custom">
          <label>Email atau Username</label>
          <input
            type="text"
            name="identifier"
            class="form-control-custom @error('identifier') is-invalid @enderror"
            placeholder="Masukkan email atau username"
            value="{{ old('identifier') }}"
            required
            autofocus
          >
        </div>

        {{-- PASSWORD --}}
        <div class="form-group-custom">
          <label>Password</label>
          <input
            type="password"
            name="password"
            class="form-control-custom"
            placeholder="Masukkan password"
            required
          >
        </div>

        {{-- LUPA PASSWORD --}}
        <div class="forgot-link-wrap">
          <a href="{{ route('password.request') }}" class="forgot-link">
            Lupa Password?
          </a>
        </div>

        {{-- TOMBOL SUBMIT --}}
        <button type="submit" class="btn-auth-submit">
          Masuk
        </button>
      </form>

      {{-- PEMISAH --}}
      <div class="auth-divider">
        <span>atau masuk dengan</span>
      </div>

      {{-- TOMBOL SOSIAL --}}
      <div class="social-btn-row">
        <button type="button" class="btn-social" onclick="alert('Autentikasi Google belum dikonfigurasi pada sistem.');">
          <i class="fab fa-google" style="color:#DB4437;"></i> Google
        </button>
        <button type="button" class="btn-social" onclick="alert('Autentikasi Facebook belum dikonfigurasi pada sistem.');">
          <i class="fab fa-facebook-f" style="color:#4267B2;"></i> Facebook
        </button>
      </div>

    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
