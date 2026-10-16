@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="container py-4">
  <div class="card">
    <div class="card-body">
      <h3 class="mb-4">Tambah Produk</h3>
      <form method="POST" action="{{ route('umkm.products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label>Nama</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Slug</label>
          <input type="text" name="slug" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Kategori</label>
          <select name="category_id" class="form-control" required>
            @foreach($categories as $cat)<option value="{{ $cat->id }}">{{ $cat->name }}</option>@endforeach
          </select>
        </div>
        <div class="mb-3">
          <label>Harga</label>
          <input type="number" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Stok</label>
          <input type="number" name="stock" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Deskripsi</label>
          <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
          <label>Gambar</label>
          <input type="file" name="image" class="form-control">
        </div>
        <div class="mb-3">
          <label>Status</label>
          <select name="status" class="form-control"><option value="active">Active</option><option value="inactive">Inactive</option></select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </form>
    </div>
  </div>
</div>
@endsection