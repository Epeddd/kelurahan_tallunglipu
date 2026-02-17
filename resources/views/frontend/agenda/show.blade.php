@extends('layouts.frontend')

@section('title', $agenda->title)

@section('content')
<section class="hero">
  <div class="container">
    <h1 class="display-6 page-head">{{ $agenda->title }}</h1>
    <p class="mb-0">Detail agenda</p>
  </div>
</section>

<div class="container my-4">
  <style>
    /* Style gambar di deskripsi agar responsif dan tidak terlalu besar */
    .content img{ max-width:720px; width:100%; height:auto; display:block; margin:8px auto; }
  </style>
  <div class="card">
    @if($agenda->attachment)
      <div style="max-height:380px; overflow:hidden; background:#f8f9fa;" class="d-flex align-items-center justify-content-center">
        @php($ext = strtolower(pathinfo($agenda->attachment, PATHINFO_EXTENSION)))
        @if(in_array($ext, ['jpg','jpeg','png']))
          <img src="{{ asset('storage/'.$agenda->attachment) }}" alt="Lampiran" style="width:100%; height:100%; object-fit:cover;">
        @elseif($ext === 'pdf')
          <iframe src="{{ asset('storage/'.$agenda->attachment) }}" title="PDF Lampiran" style="width:100%; height:380px; border:0;"></iframe>
        @endif
      </div>
    @endif
    <div class="card-body">
      <p class="text-muted small mb-2">
        {{ $agenda->start_date->format('d M Y H:i') }}
        @if($agenda->end_date)
          - {{ $agenda->end_date->format('d M Y H:i') }}
        @endif
        @if($agenda->location)
          · {{ $agenda->location }}
        @endif
      </p>
      <div class="content">{!! $agenda->description !!}</div>
      @if($agenda->attachment)
        <a href="{{ asset('storage/'.$agenda->attachment) }}" target="_blank" class="btn btn-outline-secondary btn-sm">Buka Lampiran</a>
      @endif
    </div>
  </div>
</div>
@endsection