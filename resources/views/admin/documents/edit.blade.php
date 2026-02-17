@extends('layouts.admin')

@section('title','Kelola Dokumen (PDF)')

@section('content')
<div class="container-fluid">
  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif

  <div class="card">
    <div class="card-header">Unggah Dokumen PDF</div>
    <div class="card-body">
      <form action="{{ route('admin.documents.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Profil Kepala Dinas (PDF)</label>
            <input type="file" name="profil_kepala_pdf" class="form-control" accept="application/pdf">
            @error('profil_kepala_pdf')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
            <div class="mt-2">
              @if($profilKepala)
                <a href="{{ asset('files/profil-kepala-dinas.pdf') }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
              @else
                <span class="text-muted small">Belum ada file</span>
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <label class="form-label">Struktur Organisasi (PDF) [opsional]</label>
            <input type="file" name="struktur_org_pdf" class="form-control" accept="application/pdf">
            @error('struktur_org_pdf')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
            <div class="mt-2">
              @if($strukturOrg)
                <a href="{{ asset('files/struktur-organisasi.pdf') }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat</a>
              @else
                <span class="text-muted small">Belum ada file</span>
              @endif
            </div>
          </div>
        </div>
        <div class="mt-3">
          <button class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection