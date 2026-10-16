@extends('layouts.app')

@section('title', 'Kelola Produk')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Produk Saya</h3>
    <a href="{{ route('umkm.products.create') }}" class="btn btn-primary">Tambah Produk</a>
  </div>
  
  <div class="card">
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $product)
            <tr>
              <td>{{ $product->name }}</td>
              <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
              <td>{{ $product->stock }}</td>
              <td><span class="badge bg-{{ $product->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($product->status) }}</span></td>
              <td>
                <a href="{{ route('umkm.products.edit', $product->id) }}" class="btn btn-sm btn-info text-white">Edit</a>
                <form method="POST" action="{{ route('umkm.products.destroy', $product->id) }}" style="display:inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      {{ $products->links() }}
    </div>
  </div>
</div>
@endsection