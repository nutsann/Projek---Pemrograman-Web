@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Kelola Pengguna</h3>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Email</th>
              <th>Role</th>
              <th>Terdaftar</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $user)
              <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'seller' ? 'info' : 'secondary') }}">{{ ucfirst($user->role) }}</span></td>
                <td>{{ $user->created_at->format('d M Y') }}</td>
              </tr>
            @empty
              <tr><td colspan="4" class="text-center text-muted">Belum ada pengguna.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $users->links() }}
    </div>
  </div>
</div>
@endsection
