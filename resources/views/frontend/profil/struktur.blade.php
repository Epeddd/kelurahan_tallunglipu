@extends('layouts.frontend')

@section('title','Struktur Organisasi')

@section('content')
<section class="py-5">
  <div class="container">
    <h1 class="h3 fw-bold mb-3 page-head">Struktur Organisasi</h1>



    {{-- Tautan ke Profil Kepala Dinas (PDF) --}}
    <div class="mb-4">
      @php($kepalaPdf = asset('files/profil-kepala-dinas.pdf'))
      <a class="btn btn-outline-success btn-sm" href="{{ $kepalaPdf }}" target="_blank" download>
        <i class="bi bi-file-earmark-arrow-down"></i> Lihat/Download Profil Kepala Dinas (PDF)
      </a>
    </div>

    {{-- Gambar struktur di bawah konten --}}
    <div class="card glass-card">
      <div class="card-body">
        <p class="text-muted">Struktur organisasi DISPERKIMTAN-LH Kabupaten Toraja Utara.</p>
        <div class="text-center">
          <img src="{{ asset('images/BAGAN DISPERKIMTAN.jpg') }}" alt="Struktur Organisasi" class="img-fluid rounded shadow-sm" loading="lazy">
        </div>
      </div>
    </div>
  </div>
</section>
@endsection