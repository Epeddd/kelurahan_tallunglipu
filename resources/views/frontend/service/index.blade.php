@extends('layouts.frontend')

@section('title','Layanan Publik')

@section('content')
<section class="hero">
  <div class="container">
    <h1 class="display-6 page-head">Layanan Publik</h1>
    <p class="mb-0">Daftar layanan yang tersedia dan aktif.</p>
  </div>
</section>

<div class="container my-4">
  @foreach($categories as $cat)
    <div class="mb-4">
      <h4 class="mb-3">{{ $cat->name }}</h4>
      <div class="row g-3">
        @forelse($cat->services as $svc)
          <div class="col-md-6 col-lg-4">
            <div class="card h-100">
              <div class="card-body">
                <h5 class="card-title">{{ $svc->title }}</h5>
                <p class="card-text text-muted">{{ Str::limit($svc->description, 120) }}</p>
                <a class="btn btn-sm btn-success" href="{{ route('layanan.show', $svc->slug) }}">Detail</a>
                @if($svc->has_submission)
                  <a class="btn btn-sm btn-outline-secondary" href="{{ route('permohonan.form.service', $svc->slug) }}">Ajukan Permohonan</a>
                @else
                  @if($svc->requirements_pdf)
                    <a class="btn btn-sm btn-outline-primary" href="{{ asset('storage/'.$svc->requirements_pdf) }}" target="_blank">Lihat PDF</a>
                  @endif
                @endif
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <div class="alert alert-light border">Belum ada layanan aktif.</div>
          </div>
        @endforelse
      </div>
    </div>
  @endforeach
</div>
@endsection