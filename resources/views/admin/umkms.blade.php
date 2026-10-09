@extends('layouts.app')

@section('title', 'Kelola UMKM')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Kelola UMKM</h3>
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
              <th>Pemilik</th>
              <th>Telepon</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($umkms as $umkm)
              <tr>
                <td>{{ $umkm->name }}</td>
                <td>{{ $umkm->user->name ?? '-' }}<br><small class="text-muted">{{ $umkm->user->email ?? '' }}</small></td>
                <td>{{ $umkm->phone ?? '-' }}</td>
                <td>
                  <span class="badge bg-{{ $umkm->status === 'approved' ? 'success' : ($umkm->status === 'pending' ? 'warning' : 'danger') }}">
                    {{ ucfirst($umkm->status) }}
                  </span>
                </td>
                <td>
                  @if($umkm->status === 'pending')
                    <form method="POST" action="{{ route('admin.umkm.approve', $umkm->id) }}" style="display:inline">
                      @csrf @method('PUT')
                      <button type="submit" class="btn btn-sm btn-success">Approve</button>
                    </form>
                    <form method="POST" action="{{ route('admin.umkm.reject', $umkm->id) }}" style="display:inline">
                      @csrf @method('PUT')
                      <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak UMKM ini?')">Reject</button>
                    </form>
                  @else
                    <span class="text-muted small">-</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center text-muted">Belum ada data UMKM.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $umkms->links() }}
    </div>
  </div>
</div>
@endsection
