@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-body p-5">
          <h3 class="card-title text-center mb-4">Daftar Akun</h3>
          @if($errors->any())
            <div class="alert alert-danger">
              @foreach($errors->all() as $err)
                <p class="mb-0">{{ $err }}</p>
              @endforeach
            </div>
          @endif
          <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label">Nama Lengkap</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
              @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
              @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Role</label>
              <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                <option value="">Pilih Role</option>
                <option value="buyer">Pembeli</option>
                <option value="seller">UMKM/Penjual</option>
              </select>
              @error('role')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
              @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Daftar</button>
          </form>
          <p class="text-center mt-3">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
