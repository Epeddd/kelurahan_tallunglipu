@extends('layouts.admin')
@section('title','Edit Kategori Layanan')
@section('content')
<div class="container-fluid">
  <h4 class="mb-3">Edit Kategori Layanan</h4>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.service-categories.update',$category) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input type="text" name="name" class="form-control" value="{{ old('name',$category->name) }}" required>
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