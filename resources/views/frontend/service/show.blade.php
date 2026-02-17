@extends('layouts.frontend')

@section('title', $service->title)

@section('content')
<section class="hero">
  <div class="container">
    <h1 class="display-6 page-head">{{ $service->title }}</h1>
    <p class="mb-0">Detail layanan publik</p>
  </div>
</section>

<div class="container my-4">
  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">Deskripsi</h5>
          <p class="card-text">{{ $service->description }}</p>

          @if($service->requirements && is_array($service->requirements))
            <h6>Persyaratan</h6>
            <ul>
              @foreach($service->requirements as $req)
                <li>{{ $req }}</li>
              @endforeach
            </ul>
          @endif

          @if($service->requirements_pdf)
            <div class="mt-3">
              <a class="btn btn-outline-primary" href="{{ asset('storage/'.$service->requirements_pdf) }}" target="_blank" rel="noopener">Lihat Lampiran Persyaratan (PDF)</a>
            </div>
          @endif

          @if(!empty($service->external_link))
            <div class="mt-2">
              <a class="btn btn-outline-secondary" href="{{ $service->external_link }}" target="_blank" rel="noopener">Buka Portal Luar</a>
            </div>
          @endif
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          @if($service->has_submission)
            <h6 class="card-title">Ajukan Permohonan</h6>
            <p class="small text-muted">Isi formulir permohonan untuk layanan ini.</p>
            <a class="btn btn-success w-100" href="{{ route('permohonan.form.service', $service->slug) }}">Mulai Ajukan</a>
          @else
            <h6 class="card-title">Informasi Persyaratan</h6>
            <p class="small text-muted">Layanan ini tidak memerlukan pengajuan melalui sistem. Silakan lihat persyaratan di bawah ini.</p>

          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection