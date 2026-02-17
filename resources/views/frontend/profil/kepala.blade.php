@extends('layouts.frontend')

@section('title','Profil Kepala Dinas')

@section('content')
<section class="py-5">
  <div class="container">
    <h1 class="h3 fw-bold mb-3 page-head">Profil Kepala Dinas</h1>

    {{-- Link-only: Profil Kepala Dinas PDF --}}
    @php($kepalaPdf = asset('files/profil-kepala-dinas.pdf'))
    <a class="btn btn-outline-success" href="{{ $kepalaPdf }}" target="_blank" download>
      <i class="bi bi-file-earmark-arrow-down"></i> Lihat/Download Profil Kepala Dinas (PDF)
    </a>


  </div>
</section>
@endsection