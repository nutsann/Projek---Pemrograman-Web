@extends('layouts.admin')

@section('title', 'Kelola Ulasan')

@section('admin_content')
<div class="page-header-box">
  <div>
    <h1 class="page-header-title">Kelola Ulasan Produk</h1>
    <p class="text-muted mb-0">Pantau pengalaman pelanggan terhadap produk UMKM</p>
  </div>
</div>

<div class="admin-table-card">
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Produk</th>
          <th>Pelanggan</th>
          <th>Rating</th>
          <th>Ulasan</th>
          <th>Tanggal</th>
          <th>Pesanan</th>
        </tr>
      </thead>
      <tbody>
        @forelse($reviews as $review)
          <tr>
            <td class="fw-bold">{{ $review->product->name ?? 'Produk dihapus' }}</td>
            <td>{{ $review->user->name ?? 'Pengguna dihapus' }}</td>
            <td style="color:#C18A32; white-space:nowrap;">
              @for($star = 1; $star <= 5; $star++)
                <i class="fas fa-star" style="opacity:{{ $star <= $review->rating ? '1' : '.2' }}"></i>
              @endfor
            </td>
            <td>{{ Str::limit($review->comment ?: 'Tanpa komentar', 80) }}</td>
            <td class="text-muted small">{{ $review->created_at->format('d M Y') }}</td>
            <td class="text-muted small">#{{ $review->order_id }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center py-4 text-muted">Belum ada ulasan.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="d-flex justify-content-center mt-3">
    {{ $reviews->links() }}
  </div>
</div>
@endsection
