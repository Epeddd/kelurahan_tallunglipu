@extends('layouts.admin')

@section('title','Tambah Tugas & Fungsi')

@section('content')
<div class="container-fluid">
  <h4 class="mb-3">Tambah Tugas & Fungsi</h4>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.tugas.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
      <label class="form-label">Judul</label>
      <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea name="description" rows="6" class="form-control">{{ old('description') }}</textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">File PDF (opsional)</label>
      <input type="file" name="pdf" accept="application/pdf" class="form-control">
      <div class="form-text">Format: PDF, maks 10MB</div>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.tugas.index') }}" class="btn btn-light">Batal</a>
      <button class="btn btn-volt">Simpan</button>
    </div>
  </form>
</div>
@endsection