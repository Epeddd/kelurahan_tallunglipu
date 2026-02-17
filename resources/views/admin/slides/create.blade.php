@extends('layouts.admin')
@section('title','Tambah Slide')
@section('content')
<h1 class="h4 mb-3">Tambah Slide</h1>
<form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data" class="card p-3">
  @csrf
  <div class="mb-3">
    <label class="form-label">Judul</label>
    <input type="text" name="title" class="form-control" value="{{ old('title') }}" maxlength="150">
  </div>
  <div class="mb-3">
    <label class="form-label">Caption</label>
    <input type="text" name="caption" class="form-control" value="{{ old('caption') }}" maxlength="255">
  </div>
  <div class="mb-3">
    <label class="form-label">Gambar</label>
    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
    @error('image')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="row g-3">
    <div class="col-md-4">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="draft">Draft</option>
        <option value="published">Published</option>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Urutan</label>
      <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', 0) }}">
    </div>
    <div class="col-md-4">
      <label class="form-label">Interval (ms)</label>
      <input type="number" name="interval_ms" class="form-control" min="1000" max="60000" value="{{ old('interval_ms') }}" placeholder="Kosongkan utk default">
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-success">Simpan</button>
    <a href="{{ route('admin.slides.index') }}" class="btn btn-secondary">Batal</a>
  </div>
</form>
@endsection