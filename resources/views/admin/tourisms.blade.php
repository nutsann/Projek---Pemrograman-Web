@extends('layouts.app')

@section('title', 'Kelola Wisata')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Kelola Wisata</h3>
    <a href="{{ route('admin.tourisms.create') }}" class="btn btn-primary">Tambah Wisata</a>
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
              <th>Gambar</th>
              <th>Nama</th>
              <th>Kategori</th>
              <th>Lokasi</th>
              <th>Tiket</th>
              <th>Featured</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($tourisms as $tourism)
              <tr>
                <td>
                  <img src="{{ $tourism->image ? asset('storage/'.$tourism->image) : 'https://via.placeholder.com/60x40' }}" alt="" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                </td>
                <td>{{ $tourism->name }}</td>
                <td>{{ $tourism->category->name ?? '-' }}</td>
                <td>{{ Str::limit($tourism->location, 30) }}</td>
                <td>
                  {{ $tourism->ticket_price > 0 ? 'Rp '.number_format($tourism->ticket_price,0,',','.') : 'Gratis' }}
                </td>
                <td>
                  <span class="badge bg-{{ $tourism->is_featured ? 'success' : 'secondary' }}">
                    {{ $tourism->is_featured ? 'Ya' : 'Tidak' }}
                  </span>
                </td>
                <td>
                  <a href="{{ route('admin.tourisms.edit', $tourism->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                  <form method="POST" action="{{ route('admin.tourisms.destroy', $tourism->id) }}" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')">Hapus</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{ $tourisms->links() }}
    </div>
  </div>
</div>
@endsection