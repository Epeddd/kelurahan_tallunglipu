@extends('layouts.admin')
@section('title','Tambah Kategori Layanan')
@section('content')
<div class="container-fluid">
  <h4 class="mb-3">Tambah Kategori Layanan</h4>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.service-categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div>
          <button class="btn btn-success">Simpan</button>
          <a href="{{ route('admin.service-categories.index') }}" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection