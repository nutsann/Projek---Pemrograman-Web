@extends('layouts.app')

@section('title', 'Kelola Event')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Kelola Event</h3>
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">Tambah Event</a>
  </div>
  <div class="card">
    <div class="card-body">
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Tanggal</th>
              <th>Lokasi</th>
              <th>Status</th>
              <th>Pendaftaran</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($events as $event)
              <tr>
                <td>{{ $event->name }}</td>
                <td>{{ $event->start_date->format('d M Y') }} - {{ $event->end_date->format('d M Y') }}</td>
                <td>{{ Str::limit($event->location, 30) }}</td>
                <td><span class="badge bg-info">{{ ucfirst($event->status) }}</span></td>
                <td>
                  <span class="badge bg-{{ $event->is_registration_open ? 'success' : 'secondary' }}">
                    {{ $event->is_registration_open ? 'Terbuka' : 'Tutup' }}
                  </span>
                </td>
                <td>
                  <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                  <form method="POST" action="{{ route('admin.events.destroy', $event->id) }}" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')">Hapus</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{ $events->links() }}
    </div>
  </div>
</div>
@endsection
