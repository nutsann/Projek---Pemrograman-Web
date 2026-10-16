@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow">
        <div class="card-body p-5">
          <h3 class="card-title text-center mb-4">Login</h3>
          @if($errors->any())
            <div class="alert alert-danger">
              @foreach($errors->all() as $err)
                <p class="mb-0">{{ $err }}</p>
              @endforeach
            </div>
          @endif
          <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
              @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
              @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>
          <p class="text-center mt-3">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
