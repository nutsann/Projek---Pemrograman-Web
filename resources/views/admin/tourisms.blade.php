@extends('layouts.admin')

@section('title', 'Kelola Wisata')

@section('admin_content')
<div class="page-header-box">
  <div>
    <h1 class="page-header-title">Kelola Destinasi Wisata</h1>
    <p class="text-muted mb-0">Daftar objek wisata alam, sejarah, dan bahari Kota Tanjungpinang</p>
  </div>
  <a href="{{ route('admin.tourisms.create') }}" class="btn-create-item">
    <i class="fas fa-plus"></i> Tambah Wisata Baru
  </a>
</div>

<div class="admin-table-card">
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Gambar</th>
          <th>Nama Destinasi</th>
          <th>Kategori</th>
          <th>Lokasi</th>
          <th>Tiket</th>
          <th>Sorotan</th>
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($tourisms as $tourism)
          <tr>
            <td>
              <img
                src="{{ $tourism->image ? (str_starts_with($tourism->image, 'http') ? $tourism->image : asset('storage/'.$tourism->image)) : 'https://via.placeholder.com/70x50?text=Wisata' }}"
                alt="{{ $tourism->name }}"
                style="width: 70px; height: 48px; object-fit: cover; border-radius: 8px;"
              >
            </td>
            <td class="fw-bold">{{ $tourism->name }}</td>
            <td><span class="badge bg-light text-dark border">{{ $tourism->category->name ?? 'Wisata' }}</span></td>
            <td>{{ Str::limit($tourism->location, 30) }}</td>
            <td class="fw-bold" style="color:#C18A32;">
              {{ $tourism->ticket_price > 0 ? 'Rp '.number_format($tourism->ticket_price,0,',','.') : 'Gratis' }}
            </td>
            <td>
              @if($tourism->is_featured)
                <span class="badge" style="background:#105746;">Featured</span>
              @else
                <span class="badge bg-secondary">Standar</span>
              @endif
            </td>
            <td class="text-end">
              <a href="{{ route('admin.tourisms.edit', $tourism->id) }}" class="btn btn-sm btn-outline-success me-1" style="border-radius:8px;">
                <i class="fas fa-edit"></i> Edit
              </a>
              <form method="POST" action="{{ route('admin.tourisms.destroy', $tourism->id) }}" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus destinasi ini?')" style="border-radius:8px;">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7" class="text-center py-4 text-muted">Belum ada data destinasi wisata tersimpan.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="d-flex justify-content-center mt-3">
    {{ $tourisms->links() }}
  </div>
</div>
@endsection
