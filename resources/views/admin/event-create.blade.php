@extends('layouts.app')

@section('title', 'Tambah Event')

@section('content')
<div class="container py-4">
  <div class="card">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Tambah Event Baru</h4>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label class="form-label">Nama Event <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
          @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Slug (URL) <span class="text-danger">*</span></label>
          <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required>
          @error('slug')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
          <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description') }}</textarea>
          @error('description')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
            <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
            @error('start_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>
          <div class="col-md-6">
            <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
            <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
            @error('end_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
          </div>
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
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Kuota Peserta</label>
            <input type="number" name="max_participants" class="form-control" value="{{ old('max_participants') }}" min="1">
          </div>
          <div class="col-md-6">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-select" required>
              <option value="upcoming">Akan Datang</option>
              <option value="ongoing">Berlangsung</option>
              <option value="completed">Selesai</option>
              <option value="cancelled">Dibatalkan</option>
            </select>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Gambar</label>
          <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" name="is_registration_open" class="form-check-input" id="is_registration_open">
          <label class="form-check-label" for="is_registration_open">Buka Pendaftaran</label>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.events') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection
