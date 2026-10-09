@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="container py-4">
  <div class="card">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Edit: {{ $event->name }}</h4>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.events.update', $event->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
          <label class="form-label">Nama Event <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $event->name) }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Slug (URL) <span class="text-danger">*</span></label>
          <input type="text" name="slug" class="form-control" value="{{ old('slug', $event->slug) }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
          <textarea name="description" class="form-control" rows="5" required>{{ old('description', $event->description) }}</textarea>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
            <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
            <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}" required>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Lokasi <span class="text-danger">*</span></label>
          <input type="text" name="location" class="form-control" value="{{ old('location', $event->location) }}" required>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Latitude</label>
            <input type="number" step="any" name="latitude" class="form-control" value="{{ old('latitude', $event->latitude) }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Longitude</label>
            <input type="number" step="any" name="longitude" class="form-control" value="{{ old('longitude', $event->longitude) }}">
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Kuota Peserta</label>
            <input type="number" name="max_participants" class="form-control" value="{{ old('max_participants', $event->max_participants) }}" min="1">
          </div>
          <div class="col-md-6">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-select" required>
              <option value="upcoming" {{ $event->status === 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
              <option value="ongoing" {{ $event->status === 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
              <option value="completed" {{ $event->status === 'completed' ? 'selected' : '' }}>Selesai</option>
              <option value="cancelled" {{ $event->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Gambar</label>
          <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" name="is_registration_open" class="form-check-input" id="is_registration_open" {{ $event->is_registration_open ? 'checked' : '' }}>
          <label class="form-check-label" for="is_registration_open">Buka Pendaftaran</label>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.events') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection
