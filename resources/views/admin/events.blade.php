@extends('layouts.admin')

@section('title', 'Kelola Event & Festival')

@section('admin_content')
<div class="page-header-box">
  <div>
    <h1 class="page-header-title">Kelola Event &amp; Festival</h1>
    <p class="text-muted mb-0">Jadwal festival budaya, bazar, pameran UMKM, dan workshop</p>
  </div>
  <a href="{{ route('admin.events.create') }}" class="btn-create-item">
    <i class="fas fa-plus"></i> Tambah Event Baru
  </a>
</div>

<div class="admin-table-card">
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Nama Event</th>
          <th>Jadwal Pelaksanaan</th>
          <th>Lokasi</th>
          <th>Status</th>
          <th>Pendaftaran</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($events as $event)
          <tr>
            <td class="fw-bold">{{ $event->name }}</td>
            <td>
              <i class="far fa-calendar text-muted me-1"></i>
              {{ $event->start_date->format('d M Y') }} s/d {{ $event->end_date->format('d M Y') }}
            </td>
            <td>{{ Str::limit($event->location, 30) }}</td>
            <td>
              <span class="badge" style="background:{{ $event->status === 'upcoming' ? '#105746' : ($event->status === 'ongoing' ? '#C18A32' : '#6c757d') }}">
                {{ ucfirst($event->status) }}
              </span>
            </td>
            <td>
              <span class="badge {{ $event->is_registration_open ? 'bg-success' : 'bg-secondary' }}">
                {{ $event->is_registration_open ? 'Dibuka' : 'Ditutup' }}
              </span>
            </td>
            <td class="text-end">
              <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-outline-success me-1" style="border-radius:8px;">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form method="POST" action="{{ route('admin.events.destroy', $event->id) }}" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus event ini?')" style="border-radius:8px;">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center py-4 text-muted">Belum ada agenda event tersimpan.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="d-flex justify-content-center mt-3">
    {{ $events->links() }}
  </div>
</div>
@endsection
