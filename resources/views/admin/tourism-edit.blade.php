@extends('layouts.app')

@section('title', 'Edit Wisata')

@section('content')
<div class="container py-4">
  <div class="card">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Edit: {{ $tourism->name }}</h4>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.tourisms.update', $tourism->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
          <label class="form-label">Nama <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $tourism->name) }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Slug (URL) <span class="text-danger">*</span></label>
          <input type="text" name="slug" class="form-control" value="{{ old('slug', $tourism->slug) }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Kategori</label>
          <select name="category_id" class="form-select">
            <option value="">Pilih Kategori</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ $tourism->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Deskripsi Singkat <span class="text-danger">*</span></label>
          <textarea name="short_description" class="form-control" rows="3" required>{{ old('short_description', $tourism->short_description) }}</textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
          <textarea name="description" class="form-control" rows="5" required>{{ old('description', $tourism->description) }}</textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Lokasi <span class="text-danger">*</span></label>
          <input type="text" name="location" class="form-control" value="{{ old('location', $tourism->location) }}" required>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Latitude <span class="text-danger">*</span></label>
            <input type="number" step="any" name="latitude" class="form-control" value="{{ old('latitude', $tourism->latitude) }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Longitude <span class="text-danger">*</span></label>
            <input type="number" step="any" name="longitude" class="form-control" value="{{ old('longitude', $tourism->longitude) }}" required>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Jam Buka</label>
            <input type="time" name="open_time" class="form-control" value="{{ old('open_time', $tourism->open_time) }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">Jam Tutup</label>
            <input type="time" name="close_time" class="form-control" value="{{ old('close_time', $tourism->close_time) }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">Harga Tiket</label>
            <input type="number" name="ticket_price" class="form-control" value="{{ old('ticket_price', $tourism->ticket_price) }}" min="0">
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Gambar Saat Ini</label>
          @if($tourism->image)
            <div><img src="{{ asset('storage/'.$tourism->image) }}" alt="" style="max-width:200px;border-radius:4px;"></div>
          @else
            <span class="text-muted">Belum ada gambar</span>
          @endif
        </div>
        <div class="mb-3">
          <label class="form-label">Ganti Gambar</label>
          <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" {{ $tourism->is_featured ? 'checked' : '' }}>
          <label class="form-check-label" for="is_featured">Tampilkan di Beranda (Featured)</label>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.tourisms') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection
