@extends('layouts.admin')

@section('title', 'Kelola Budaya')

@section('admin_content')
<div class="page-header-box">
  <div>
    <h1 class="page-header-title">Kelola Budaya</h1>
    <p class="text-muted mb-0">Daftar warisan adat, tarian, dan tradisi lokal Tanjungpinang</p>
  </div>
  <a href="{{ route('admin.cultures.create') }}" class="btn-create-item">
    <i class="fas fa-plus"></i> Tambah Budaya Baru
  </a>
</div>

<div class="admin-table-card">
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Gambar</th>
          <th>Nama Budaya</th>
          <th>Kategori</th>
          <th>Wilayah / Lokasi</th>
          <th>Sorotan</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($cultures as $culture)
          <tr>
            <td>
              <img
                src="{{ $culture->image ? (str_starts_with($culture->image, 'http') ? $culture->image : asset('storage/'.$culture->image)) : 'https://via.placeholder.com/70x50?text=Budaya' }}"
                alt="{{ $culture->name }}"
                style="width: 70px; height: 48px; object-fit: cover; border-radius: 8px;"
              >
            </td>
            <td class="fw-bold">{{ $culture->name }}</td>
            <td><span class="badge bg-light text-dark border">{{ $culture->category->name ?? 'Umum' }}</span></td>
            <td>{{ Str::limit($culture->location, 30) }}</td>
            <td>
              @if($culture->is_featured)
                <span class="badge" style="background:#105746;">Featured</span>
              @else
                <span class="badge bg-secondary">Standar</span>
              @endif
            </td>
            <td class="text-end">
              <a href="{{ route('admin.cultures.edit', $culture->id) }}" class="btn btn-sm btn-outline-success me-1" style="border-radius:8px;">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form method="POST" action="{{ route('admin.cultures.destroy', $culture->id) }}" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus budaya ini?')" style="border-radius:8px;">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center py-4 text-muted">Belum ada data budaya tersimpan.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="d-flex justify-content-center mt-3">
    {{ $cultures->links() }}
  </div>
</div>
@endsection
