@extends('layouts.admin')
@section('title','Tambah Foto Galeri')
@section('content')
<div class="container-fluid">
  <h4 class="mb-3">Tambah Foto Galeri</h4>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label class="form-label">Judul Foto</label>
          <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Foto (bisa pilih lebih dari satu)</label>
          <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
        </div>
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="published">Published</option>
            <option value="draft">Draft</option>
          </select>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection