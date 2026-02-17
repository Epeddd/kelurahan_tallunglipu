@extends('layouts.admin')
@section('title','Edit Agenda')
@section('content')
<div class="container-fluid">
  <h4 class="mb-3">Edit Agenda</h4>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.agenda.update',$agenda) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
          <label class="form-label">Judul</label>
          <input type="text" name="title" class="form-control" value="{{ old('title',$agenda->title) }}" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <textarea name="description" id="agenda-editor" class="form-control" rows="10">{{ old('description',$agenda->description) }}</textarea>
        </div>
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Mulai</label>
            <input type="datetime-local" name="start_date" class="form-control" value="{{ $agenda->start_date ? \Carbon\Carbon::parse($agenda->start_date)->format('Y-m-d\TH:i') : '' }}" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Selesai</label>
            <input type="datetime-local" name="end_date" class="form-control" value="{{ $agenda->end_date ? \Carbon\Carbon::parse($agenda->end_date)->format('Y-m-d\TH:i') : '' }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">Lokasi</label>
            <input type="text" name="location" class="form-control" value="{{ old('location',$agenda->location) }}">
          </div>
        </div>
        <div class="mt-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select">
            <option value="published" @selected($agenda->status=='published')>Published</option>
            <option value="draft" @selected($agenda->status=='draft')>Draft</option>
          </select>
        </div>
        <div class="mt-3">
          <label class="form-label">Lampiran (jpg, png, pdf, maks 5MB)</label>
          <input type="file" name="attachment" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
          @if($agenda->attachment)
            <div class="form-text">Lampiran saat ini: <a href="{{ asset('storage/'.$agenda->attachment) }}" target="_blank">Lihat</a></div>
          @endif
        </div>
        <div class="mt-3">
          <button class="btn btn-success">Simpan</button>
          <a href="{{ route('admin.agenda.index') }}" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
  tinymce.init({
    selector:'#agenda-editor',
    height:400,
    menubar:'file edit view insert format tools table help',
    plugins:'link lists image table media code fullscreen autoresize',
    toolbar:'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link image media table | fullscreen code',
    convert_urls:false,
    images_upload_url: '{{ route('admin.agenda.upload-image') }}',
    images_upload_credentials: true,
    images_upload_handler: function (blobInfo, progress) {
      return new Promise(function(resolve, reject){
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route('admin.agenda.upload-image') }}');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        xhr.upload.onprogress = function (e) {
          if (e.lengthComputable) progress(e.loaded / e.total * 100);
        };
        xhr.onload = function () {
          if (xhr.status < 200 || xhr.status >= 300) { reject('HTTP Error: ' + xhr.status); return; }
          try {
            const json = JSON.parse(xhr.responseText);
            if (!json || typeof json.location !== 'string') { reject('Invalid JSON: ' + xhr.responseText); return; }
            resolve(json.location);
          } catch(err){
            reject('Invalid JSON response');
          }
        };
        xhr.onerror = function () { reject('Image upload failed due to a XHR Transport error.'); };
        const formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
      });
    }
  });
</script>
@endpush