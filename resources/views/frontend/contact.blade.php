@extends('layouts.frontend')

@section('title','Kontak Kelurahan Tallunglipu')

@section('content')
<section class="hero">
  <div class="container">
    <h1 class="display-6 page-head">Kontak</h1>
    <p class="mb-0">Hubungi kami untuk pertanyaan dan informasi.</p>
  </div>
</section>

<div class="container my-4">
  <div class="row g-3">
    <div class="col-lg-6">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Informasi Kontak</h5>
          <p class="mb-1">Alamat: Jl. Poros Tallunglipu - Parinding.</p>
          <p class="mb-1">Email: -</p>
          <p class="mb-0">Telepon: 0812-4268-4046</p>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Ajukan Permohonan Layanan</h5>
          <p class="small text-muted">Pilih layanan dan isi data pada halaman permohonan.</p>
          <a class="btn btn-success" href="{{ route('permohonan.form') }}">Buka Form Permohonan</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection