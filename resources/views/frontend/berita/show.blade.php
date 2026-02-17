@extends('layouts.frontend')
@section('title',$berita->title)
@section('breadcrumbs')
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
    <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Berita</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ \Illuminate\Support\Str::limit($berita->title, 40) }}</li>
  </ol>
@endsection

@section('content')
<div class="container py-4">
  <div class="row g-4">
    <!-- Konten utama -->
    <div class="col-lg-8">
      <article class="card border-0 shadow-sm">
        @if($berita->thumbnail)
          <!-- Responsive 16:9 cover image -->
          <div class="ratio ratio-16x9">
            <img src="{{ asset('storage/'.$berita->thumbnail) }}" alt="thumbnail" class="w-100" style="object-fit: cover;">
          </div>
        @endif
        <div class="card-body">
          <h1 class="card-title h4 fw-bold mb-1 page-head">{{ $berita->title }}</h1>
          <div class="text-muted small mb-3">{{ $berita->published_at? $berita->published_at->format('d M Y') : '-' }}</div>
          <div class="content">{!! $berita->content !!}</div>
        </div>
      </article>
    </div>

    <!-- Sidebar: Berita lainnya -->
    <div class="col-lg-4">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <h6 class="mb-0">Berita lainnya</h6>
        <a class="small" href="{{ route('berita.index') }}">Lihat semua</a>
      </div>
      <div class="row g-2">
        @forelse(($others ?? collect()) as $o)
          <div class="col-12">
            <a href="{{ route('berita.show', $o->slug) }}" class="text-decoration-none">
              <div class="card border-0 shadow-sm h-100">
                <div class="row g-0 align-items-center">
                  <div class="col-4">
                    <img src="{{ $o->thumbnail ? asset('storage/'.$o->thumbnail) : asset('images/BG1.jpg') }}" alt="{{ $o->title }}" class="w-100" style="height:60px;object-fit:cover;border-top-left-radius:.375rem;border-bottom-left-radius:.375rem;">
                  </div>
                  <div class="col-8">
                    <div class="p-2">
                      <div class="small fw-semibold text-dark" style="line-height:1.1;">{{ \Illuminate\Support\Str::limit($o->title, 60) }}</div>
                      <div class="text-muted xsmall">{{ $o->published_at? $o->published_at->format('d M Y') : '' }}</div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>
        @empty
          <div class="text-muted small">Belum ada berita lainnya.</div>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection