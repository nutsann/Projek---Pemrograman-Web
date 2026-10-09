@extends('layouts.app')

@section('title', 'Edit Budaya')

@section('content')
<div class="container py-4">
  <div class="card">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Edit: {{ $culture->name }}</h4>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.cultures.update', $culture->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        
        <div class="mb-3">
          <label class="form-label">Nama <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $culture->name) }}" required>
          @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Slug (URL) <span class="text-danger">*</span></label>
          <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $culture->slug) }}" required>
          @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Kategori <span class="text-danger">*</span></label>
          <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
            <option value="">Pilih Kategori</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ $culture->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
          </select>
          @error('category_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Deskripsi Singkat <span class="text-danger">*</span></label>
          <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="3" required>{{ old('short_description', $culture->short_description) }}</textarea>
          @error('short_description')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
          <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description', $culture->description) }}</textarea>
          @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Sejarah</label>
          <textarea name="history" class="form-control" rows="4">{{ old('history', $culture->history) }}</textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">Lokasi <span class="text-danger">*</span></label>
          <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $culture->location) }}" required>
          @error('location')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Latitude</label>
            <input type="number" step="any" name="latitude" class="form-control" value="{{ old('latitude', $culture->latitude) }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Longitude</label>
            <input type="number" step="any" name="longitude" class="form-control" value="{{ old('longitude', $culture->longitude) }}">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Gambar Saat Ini</label>
          @if($culture->image)
            <img src="{{ asset('storage/'.$culture->image) }}" alt="" style="max-width: 200px; border-radius: 4px;" class="mb-2">
          @else
            <span class="text-muted">Belum ada gambar</span>
          @endif
        </div>

        <div class="mb-3">
          <label class="form-label">Ganti Gambar (Kosongkan jika tidak diganti)</label>
          <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
          @error('image')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="mb-3 form-check">
          <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" {{ old('is_featured', $culture->is_featured) ? 'checked' : '' }}>
          <label class="form-check-label" for="is_featured">Tampilkan di Beranda (Featured)</label>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.cultures') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection