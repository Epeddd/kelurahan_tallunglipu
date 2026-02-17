@extends('layouts.frontend')
@section('title','Berita DISPERKIMTAN-LH Kab. Toraja Utara')
@section('content')
<div class="container py-4">
  <h3 class="mb-3 page-head">Berita</h3>
  <div class="row g-0">
    <div class="col-12">
      @foreach($beritas as $b)
      <div class="card shadow-sm border-0 mb-3">
        <div class="row g-0 align-items-center">
          <div class="col-8 col-md-9">
            <div class="p-3">
              <h6 class="mb-1">
                <a class="text-decoration-none text-primary fw-semibold" href="{{ route('berita.show',$b->slug) }}">{{ $b->title }}</a>
              </h6>
              <small class="text-muted d-block mb-1">{{ $b->published_at? $b->published_at->translatedFormat('l, d M Y') : '-' }}</small>
              <div class="text-dark small">{{ $b->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($b->content), 140) }}</div>
            </div>
          </div>
          <div class="col-4 col-md-3">
            <a href="{{ route('berita.show',$b->slug) }}" class="d-block h-100">
              <img src="{{ $b->thumbnail ? asset('storage/'.$b->thumbnail) : asset('images/BG1.jpg') }}" alt="{{ $b->title }}" class="w-100" style="height: 110px; object-fit: cover;">
            </a>
          </div>
        </div>
      </div>
      @endforeach
      <div class="mt-3">{{ $beritas->links() }}</div>
    </div>
  </div>
</div>
@endsection