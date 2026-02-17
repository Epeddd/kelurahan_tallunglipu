@extends('layouts.admin')
@section('title','Tambah Layanan Publik')
@section('content')
<div class="container-fluid">
  <h4 class="mb-3">Tambah Layanan Publik</h4>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-select" required>
              <option value="">-- Pilih --</option>
              @foreach($categories as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="mb-3 mt-3">
          <label class="form-label">Deskripsi</label>
          <textarea name="description" class="form-control" rows="6"></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Persyaratan (satu per baris)</label>
          <textarea name="requirements[]" class="form-control" rows="5" placeholder="KTP\nKK\nFormulir ..." oninput="syncReq(this)"></textarea>
          <input type="hidden" name="requirements" id="req_hidden">
        </div>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Tautan Eksternal</label>
            <input type="url" name="external_link" class="form-control" placeholder="https://...">
          </div>
          <div class="col-md-3">
            <label class="form-label d-block">Memiliki Pengajuan?</label>
            <select name="has_submission" class="form-select">
              <option value="1">Ya (ada proses pengajuan)</option>
              <option value="0">Tidak (hanya pemberitahuan)</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              <option value="active">Aktif</option>
              <option value="inactive">Nonaktif</option>
            </select>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Lampiran Persyaratan (PDF)</label>
          <input type="file" name="requirements_pdf" accept="application/pdf" class="form-control">
          <div class="form-text">Opsional. Maksimal 5 MB. Ditampilkan ke pengguna sebagai dokumen persyaratan.</div>
        </div>
        <div class="mt-3">
          <button class="btn btn-success">Simpan</button>
          <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
 function syncReq(el){
   const lines = el.value.split('\n').filter(Boolean);
   document.getElementById('req_hidden').value = JSON.stringify(lines);
 }
</script>
@endpush