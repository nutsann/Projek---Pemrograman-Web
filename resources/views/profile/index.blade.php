@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container py-5">
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body text-center">
          @if(Auth::user()->profile_photo)
            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
          @else
            <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px;">
              <i class="fas fa-user" style="font-size: 2rem; color: #ccc;"></i>
            </div>
          @endif
          <h5>{{ Auth::user()->name }}</h5>
          <p class="text-muted small">{{ Auth::user()->email }}</p>
          <p class="text-muted small">
            <span class="badge bg-primary">
              {{ Auth::user()->role === 'buyer' ? 'Pembeli' : (Auth::user()->role === 'seller' ? 'UMKM/Penjual' : 'Admin') }}
            </span>
          </p>
        </div>
      </div>

      <div class="card mt-3">
        <div class="card-body">
          <h6 class="card-title">Menu</h6>
          <a href="{{ route('profile') }}" class="btn btn-sm btn-outline-primary w-100 mb-2 active">Profil</a>
          <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary w-100 mb-2">Pesanan</a>
          @if(Auth::user()->isSeller())
            <a href="{{ route('umkm.dashboard') }}" class="btn btn-sm btn-outline-primary w-100 mb-2">Dashboard UMKM</a>
          @endif
          @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-primary w-100">Admin Panel</a>
          @endif
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card mb-4">
        <div class="card-header bg-light">
          <h5 class="mb-0">Edit Profil</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', Auth::user()->name) }}" required>
              @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email) }}" required>
              @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Nomor Telepon</label>
              <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', Auth::user()->phone) }}">
              @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Alamat</label>
              <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address', Auth::user()->address) }}</textarea>
              @error('address')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Foto Profil</label>
              <input type="file" name="profile_photo" class="form-control @error('profile_photo') is-invalid @enderror" accept="image/*">
              @error('profile_photo')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </form>
        </div>
      </div>

      <div class="card">
        <div class="card-header bg-light">
          <h5 class="mb-0">Ubah Password</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('profile.password') }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label class="form-label">Password Saat Ini</label>
              <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
              @error('current_password')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Password Baru</label>
              <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" required>
              @error('new_password')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Konfirmasi Password</label>
              <input type="password" name="new_password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Ubah Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
