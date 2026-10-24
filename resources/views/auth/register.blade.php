<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar - Platform Digital Budaya Tanjungpinang</title>
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
    /* PANEL KIRI: HIJAU TUA (45%) */
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

    /* PANEL KANAN: PUTIH (55%) */
    .auth-side-form {
      width: 55%;
      background: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 50px 24px;
    }
    .auth-form-inner {
      width: 100%;
      max-width: 440px;
    }

    /* TABS */
    .auth-nav-tabs {
      display: flex;
      border-bottom: 2px solid #e5e5e5;
      margin-bottom: 40px;
    }
    .auth-tab-item {
      flex: 1;
      text-align: center;
      padding-bottom: 14px;
      font-size: 1.4rem;
      font-weight: 700;
      color: #8c8c8c;
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
      font-size: 2rem;
      font-weight: 800;
      color: #1a1a1a;
      text-align: center;
      margin-bottom: 8px;
    }
    .auth-subtitle {
      font-size: 0.95rem;
      color: #666666;
      text-align: center;
      margin-bottom: 34px;
    }

    /* INPUT FIELDS DENGAN JARAK KONSISTEN */
    .form-group-custom {
      margin-bottom: 20px;
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
      border-radius: 10px;
      padding: 0 16px;
      font-size: 0.92rem;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
      color: #333;
      background: #ffffff;
    }
    .form-control-custom:focus {
      border-color: #105746;
      box-shadow: 0 0 0 3px rgba(16,87,70,0.1);
    }
    .form-control-custom::placeholder {
      color: #a8a8a8;
      font-size: 0.88rem;
    }
    .form-control-custom.is-invalid {
      border-color: #dc3545;
    }
    .field-error-text {
      color: #dc3545;
      font-size: 0.82rem;
      margin-top: 5px;
      display: block;
      font-weight: 600;
    }

    /* SUBMIT BUTTON */
    .btn-auth-submit {
      width: 100%;
      height: 52px;
      background: #105746;
      color: #ffffff;
      border: none;
      border-radius: 10px;
      font-size: 1.15rem;
      font-weight: 700;
      cursor: pointer;
      transition: background 0.2s, transform 0.1s;
      margin-top: 14px;
    }
    .btn-auth-submit:hover {
      background: #0d4538;
    }

    @media (max-width: 860px) {
      .auth-side-green { display: none; }
      .auth-side-form { width: 100%; min-height: 100vh; padding: 40px 20px; }
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
      <h2 style="font-size:2rem; font-weight:800; line-height:1.3; margin-bottom:12px;">Bergabung Bersama Kami!</h2>
      <p style="opacity:0.85; font-size:1rem; margin:0;">Mulai jelajahi dan dukung budaya serta pelaku UMKM lokal Kota Tanjungpinang.</p>
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
        <a href="{{ route('login') }}" class="auth-tab-item">Login</a>
        <a href="{{ route('register') }}" class="auth-tab-item active">Daftar</a>
      </div>

      {{-- HEADER FORM --}}
      <h1 class="auth-title">Buat Akun</h1>
      <p class="auth-subtitle">Lanjutkan perjalanan Budaya bersama Kami!</p>

      {{-- FORM PENDAFTARAN --}}
      <form method="POST" action="{{ route('register.post') }}">
        @csrf

        {{-- USERNAME --}}
        <div class="form-group-custom">
          <label>Username</label>
          <input
            type="text"
            name="username"
            class="form-control-custom @error('username') is-invalid @enderror"
            placeholder="Masukkan username"
            value="{{ old('username') }}"
            required
            autofocus
          >
          @error('username')
            <span class="field-error-text">{{ $message }}</span>
          @enderror
        </div>

        {{-- EMAIL --}}
        <div class="form-group-custom">
          <label>Email</label>
          <input
            type="email"
            name="email"
            class="form-control-custom @error('email') is-invalid @enderror"
            placeholder="Masukkan Email"
            value="{{ old('email') }}"
            required
          >
          @error('email')
            <span class="field-error-text">{{ $message }}</span>
          @enderror
        </div>

        {{-- PASSWORD --}}
        <div class="form-group-custom">
          <label>Password</label>
          <input
            type="password"
            name="password"
            class="form-control-custom @error('password') is-invalid @enderror"
            placeholder="Masukkan password"
            required
          >
          @error('password')
            <span class="field-error-text">{{ $message }}</span>
          @enderror
        </div>

        {{-- KONFIRMASI PASSWORD --}}
        <div class="form-group-custom">
          <input
            type="password"
            name="password_confirmation"
            class="form-control-custom"
            placeholder="Konfirmasi Password"
            required
          >
        </div>

        {{-- TOMBOL DAFTAR --}}
        <button type="submit" class="btn-auth-submit">
          Daftar
        </button>
      </form>

    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
