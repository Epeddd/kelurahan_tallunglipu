@extends('layouts.admin')
@section('title','Edit Layanan Publik')
@section('content')
<div class="container-fluid">
  <h4 class="mb-3">Edit Layanan Publik</h4>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.services.update',$service) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Judul</label>
            <input type="text" name="title" class="form-control" value="{{ old('title',$service->title) }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Kategori</label>
            <select name="category_id" class="form-select" required>
              @foreach($categories as $cat)
              <option value="{{ $cat->id }}" @selected($service->category_id==$cat->id)>{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="mb-3 mt-3">
          <label class="form-label">Deskripsi</label>
          <textarea name="description" class="form-control" rows="6">{{ old('description',$service->description) }}</textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Persyaratan (satu per baris)</label>
          <textarea class="form-control" rows="5" oninput="syncReq(this)" id="req_text"></textarea>
          <input type="hidden" name="requirements" id="req_hidden">
        </div>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Tautan Eksternal</label>
            <input type="url" name="external_link" class="form-control" value="{{ old('external_link',$service->external_link) }}" placeholder="https://...">
          </div>
          <div class="col-md-3">
            <label class="form-label d-block">Memiliki Pengajuan?</label>
            <select name="has_submission" class="form-select">
              <option value="1" @selected(old('has_submission',$service->has_submission))>Ya (ada proses pengajuan)</option>
              <option value="0" @selected(!old('has_submission',$service->has_submission))>Tidak (hanya pemberitahuan)</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              <option value="active" @selected($service->status=='active')>Aktif</option>
              <option value="inactive" @selected($service->status=='inactive')>Nonaktif</option>
            </select>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Lampiran Persyaratan (PDF)</label>
          <input type="file" name="requirements_pdf" accept="application/pdf" class="form-control">
          @if($service->requirements_pdf)
            <div class="mt-2">
              <a href="{{ asset('storage/'.$service->requirements_pdf) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat PDF saat ini</a>
            </div>
          @endif
          <div class="form-text">Opsional. Maksimal 5 MB. Mengunggah file baru akan mengganti file sebelumnya.</div>
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
 const initialReq = @json($service->requirements ?? []);
 document.getElementById('req_text').value = initialReq.join('\n');
 document.getElementById('req_hidden').value = JSON.stringify(initialReq);
 function syncReq(el){
   const lines = el.value.split('\n').filter(Boolean);
   document.getElementById('req_hidden').value = JSON.stringify(lines);
 }
</script>
@endpush