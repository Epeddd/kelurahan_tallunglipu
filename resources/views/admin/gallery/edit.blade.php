@extends('layouts.admin')
@section('title','Edit Foto Galeri')
@section('content')
<div class="container-fluid">
  <h4 class="mb-3">Edit Foto Galeri</h4>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
          <label class="form-label">Judul Foto</label>
          <input type="text" name="title" class="form-control" value="{{ old('title', $gallery->title) }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Tambah Foto Baru (bisa lebih dari satu)</label>
          <input type="file" name="new_images[]" class="form-control" accept="image/*" multiple>
        </div>
        <div class="mb-3">
          <label class="form-label">Foto Saat Ini</label>
          <div class="row g-2">
            @forelse($gallery->images as $img)
              <div class="col-6 col-md-3">
                <img src="{{ asset('storage/'.$img->image_path) }}" alt="{{ $gallery->title }}" class="img-thumbnail w-100" style="height:120px;object-fit:cover">
                <div class="form-check mt-1">
                  <input class="form-check-input" type="checkbox" name="delete_image_ids[]" value="{{ $img->id }}" id="del{{ $img->id }}">
                  <label class="form-check-label small" for="del{{ $img->id }}">Hapus</label>
                </div>
              </div>
            @empty
              <div class="text-muted">Belum ada foto.</div>
            @endforelse
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="published" @selected($gallery->status=='published')>Published</option>
            <option value="draft" @selected($gallery->status=='draft')>Draft</option>
          </select>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
</div>
@endsection