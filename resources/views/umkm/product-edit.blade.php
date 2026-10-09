@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container py-4">
  <div class="card">
    <div class="card-body">
      <h3>Edit: {{ $product->name }}</h3>
      <form method="POST" action="{{ route('umkm.products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
          <label>Nama</label>
          <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        <div class="mb-3">
          <label>Slug</label>
          <input type="text" name="slug" class="form-control" value="{{ $product->slug }}" required>
        </div>
        <div class="mb-3">
          <label>Kategori</label>
          <select name="category_id" class="form-control" required>
            @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach
          </select>
        </div>
        <div class="mb-3">
          <label>Harga</label>
          <input type="number" name="price" class="form-control" value="{{ (int)$product->price }}" required>
        </div>
        <div class="mb-3">
          <label>Stok</label>
          <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
        </div>
        <div class="mb-3">
          <label>Deskripsi</label>
          <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
        </div>
        <div class="mb-3">
          <label>Gambar Baru (Kosongkan jika tidak ganti)</label>
          <input type="file" name="image" class="form-control">
        </div>
        <div class="mb-3">
          <label>Status</label>
          <select name="status" class="form-control">
            <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $product->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </div>
</div>
@endsection