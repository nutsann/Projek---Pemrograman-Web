@extends('layouts.app')

@section('title', 'Setup UMKM')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">Setup Data UMKM Anda</h4>
        </div>
        <div class="card-body">
          <p class="alert alert-info">Lengkapi data UMKM Anda untuk mulai berjualan di marketplace.</p>
          
          <form method="POST" action="{{ route('umkm.setup.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
              <label class="form-label">Nama UMKM <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
              @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Slug (URL Friendly) <span class="text-danger">*</span></label>
              <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="contoh: umkm-saya-jaya" required>
              <small class="text-muted">Gunakan huruf kecil, angka, dan tanda hubung (-)</small>
              @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Deskripsi UMKM <span class="text-danger">*</span></label>
              <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description') }}</textarea>
              @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="mb-3">
              <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
              <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3" required>{{ old('address') }}</textarea>
              @error('address')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Email UMKM <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', Auth::user()->email) }}" required>
                @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label">Logo UMKM (Opsional)</label>
              <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
              <small class="text-muted">Format: JPG, PNG, GIF. Maks 2MB</small>
              @error('logo')<span class="invalid-feedback">{{ $message }}</span>@enderror
            </div>

            <div class="alert alert-warning">
              <strong>Catatan:</strong> Data UMKM akan direview oleh admin sebelum disetujui untuk tampil di marketplace.
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100">Simpan & Lanjutkan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
