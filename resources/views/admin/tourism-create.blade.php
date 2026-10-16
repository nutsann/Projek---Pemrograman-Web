@extends('layouts.app')

@section('title', 'Tambah Wisata')

@section('content')
<div class="container py-4">
  <div class="card">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Tambah Wisata Baru</h4>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.tourisms.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label class="form-label">Nama <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
          @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Slug (URL) <span class="text-danger">*</span></label>
          <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required>
          @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Kategori</label>
          <select name="category_id" class="form-select">
            <option value="">Pilih Kategori</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
          </select>
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
          <label class="form-label">Lokasi <span class="text-danger">*</span></label>
          <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" required>
          @error('location')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Latitude <span class="text-danger">*</span></label>
            <input type="number" step="any" name="latitude" class="form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude') }}" required>
            @error('latitude')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Longitude <span class="text-danger">*</span></label>
            <input type="number" step="any" name="longitude" class="form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude') }}" required>
            @error('longitude')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Jam Buka</label>
            <input type="time" name="open_time" class="form-control" value="{{ old('open_time') }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">Jam Tutup</label>
            <input type="time" name="close_time" class="form-control" value="{{ old('close_time') }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">Harga Tiket</label>
            <input type="number" name="ticket_price" class="form-control" value="{{ old('ticket_price', 0) }}" min="0">
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Gambar</label>
          <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured">
          <label class="form-check-label" for="is_featured">Tampilkan di Beranda (Featured)</label>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.tourisms') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection
