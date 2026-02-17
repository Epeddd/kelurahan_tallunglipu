@extends('layouts.admin')
@section('title','Tambah Berita')
@section('content')
<div class="container-fluid">
  <h4 class="mb-3">Tambah Berita</h4>
  <div class="card">
    <div class="card-body">
      <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label class="form-label">Judul</label>
          <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Ringkasan</label>
          <input type="text" name="excerpt" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Konten</label>
          <textarea name="content" id="editor" class="form-control" rows="12"></textarea>
        </div>
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Thumbnail</label>
            <input type="file" name="thumbnail" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              <option value="draft">Draft</option>
              <option value="published">Published</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Tanggal Publikasi</label>
            <input type="datetime-local" name="published_at" class="form-control">
          </div>
        </div>
        <div class="mt-3">
          <button class="btn btn-success">Simpan</button>
          <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
  tinymce.init({
    selector:'#editor',
    height:500,
    menubar:'file edit view insert format tools table help',
    plugins:'link lists image table media code fullscreen autoresize',
    toolbar:'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link image media table | fullscreen code',
    convert_urls:false,
    images_upload_url: '{{ route('admin.berita.upload-image') }}',
    images_upload_credentials: true,
    images_upload_handler: function (blobInfo, progress) {
      return new Promise(function(resolve, reject){
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route('admin.berita.upload-image') }}');
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