@extends('layouts.app')

@section('title', 'Kelola Budaya')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Kelola Budaya</h3>
    <a href="{{ route('admin.cultures.create') }}" class="btn btn-primary">Tambah Budaya</a>
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
              <th>Featured</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($cultures as $culture)
              <tr>
                <td>
                  <img src="{{ $culture->image ? asset('storage/'.$culture->image) : 'https://via.placeholder.com/60x40' }}" alt="" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                </td>
                <td>{{ $culture->name }}</td>
                <td>{{ $culture->category->name ?? '-' }}</td>
                <td>{{ Str::limit($culture->location, 30) }}</td>
                <td>
                  <span class="badge bg-{{ $culture->is_featured ? 'success' : 'secondary' }}">
                    {{ $culture->is_featured ? 'Ya' : 'Tidak' }}
                  </span>
                </td>
                <td>
                  <a href="{{ route('admin.cultures.edit', $culture->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                  <form method="POST" action="{{ route('admin.cultures.destroy', $culture->id) }}" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')">Hapus</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{ $cultures->links() }}
    </div>
  </div>
</div>
@endsection