@extends('layouts.frontend')
@section('title','Galeri')
@section('content')
<section class="hero">
  <div class="container">
    <h1 class="display-6 page-head">Galeri</h1>
    <p class="mb-0">Kumpulan foto kegiatan dan dokumentasi DISPERKIMTAN-LH</p>
  </div>
</section>
<div class="container py-4">
  @if($items->isEmpty())
    <div class="text-muted">Belum ada foto.</div>
  @else
    <div class="row g-3">
      @foreach($items as $g)
        <div class="col-lg-4 col-md-6">
          <div class="card h-100">
            <div id="galCard{{ $g->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
              <div class="carousel-inner" style="height:220px; overflow:hidden; border-top-left-radius:.5rem; border-top-right-radius:.5rem;">
                @php($imgs = $g->images)
                @forelse($imgs as $i => $img)
                  <div class="carousel-item {{ $i===0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/'.$img->image_path) }}" alt="{{ $g->title }}" style="width:100%; height:220px; object-fit:cover;">
                  </div>
                @empty
                  <div class="carousel-item active">
                    <div class="bg-light" style="width:100%; height:220px"></div>
                  </div>
                @endforelse
              </div>
              @if($imgs->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#galCard{{ $g->id }}" data-bs-slide="prev" aria-label="Prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#galCard{{ $g->id }}" data-bs-slide="next" aria-label="Next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
              @endif
            </div>
            <div class="card-body">
              <h6 class="card-title mb-0">{{ $g->title }}</h6>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="mt-3">{{ $items->links() }}</div>
  @endif
</div>
@endsection