@extends('layouts.app')

@section('title', 'Tambah Budaya')

@section('content')
<div class="container py-4">
  <div class="card">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Tambah Budaya Baru</h4>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.cultures.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
          <label class="form-label">Nama <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
          @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Slug (URL) <span class="text-danger">*</span></label>
          <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="contoh: batik-tanjungpinang" required>
          @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Kategori <span class="text-danger">*</span></label>
          <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
            <option value="">Pilih Kategori</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
          </select>
          @error('category_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Deskripsi Singkat <span class="text-danger">*</span></label>
          <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="3" required>{{ old('short_description') }}</textarea>
          @error('short_description')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
          <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description') }}</textarea>
          @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Sejarah</label>
          <textarea name="history" class="form-control" rows="4">{{ old('history') }}</textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Lokasi <span class="text-danger">*</span></label>
          <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" required>
          @error('location')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Latitude</label>
            <input type="number" step="any" name="latitude" class="form-control" value="{{ old('latitude') }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Longitude</label>
            <input type="number" step="any" name="longitude" class="form-control" value="{{ old('longitude') }}">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Gambar</label>
          <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
          @error('image')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3 form-check">
          <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
          <label class="form-check-label" for="is_featured">Tampilkan di Beranda (Featured)</label>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.cultures') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection