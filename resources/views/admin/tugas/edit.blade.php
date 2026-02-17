@extends('layouts.admin')

@section('title','Edit Tugas & Fungsi')

@section('content')
<div class="container-fluid">
  <h4 class="mb-3">Edit Tugas & Fungsi</h4>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.tugas.update', $tugas) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
      <label class="form-label">Judul</label>
      <input type="text" name="title" value="{{ old('title', $tugas->title) }}" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea name="description" rows="6" class="form-control">{{ old('description', $tugas->description) }}</textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">File PDF (opsional)</label>
      @if($tugas->pdf_path)
        <div class="mb-2">
          <a href="{{ asset('storage/'.$tugas->pdf_path) }}" target="_blank" class="link-primary">Lihat PDF Saat Ini</a>
        </div>
      @endif
      <input type="file" name="pdf" accept="application/pdf" class="form-control">
      <div class="form-text">Unggah untuk mengganti PDF (maks 10MB)</div>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.tugas.index') }}" class="btn btn-light">Batal</a>
      <button class="btn btn-volt">Update</button>
    </div>
  </form>
</div>
@endsection