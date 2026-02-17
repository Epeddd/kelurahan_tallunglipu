@extends('layouts.frontend')

@section('title','Tugas dan Fungsi')

@section('content')
@php($items = $items ?? collect())
<section class="py-5">
  <div class="container">
    <h1 class="h3 fw-bold mb-3 page-head">Tugas dan Fungsi</h1>

    @forelse($items as $item)
      <div class="card glass-card mb-3">
        <div class="card-body">
          <h2 class="h5 fw-semibold">{{ $item->title }}</h2>
          @if(!empty($item->description))
            <div class="text-muted">{!! nl2br(e($item->description)) !!}</div>
          @endif
          @if($item->pdf_path)
            <div class="mt-2">
              <a href="{{ asset('storage/'.$item->pdf_path) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">Lihat File PDF</a>
            </div>
          @endif
        </div>
      </div>
    @empty
      <div class="card glass-card">
        <div class="card-body">
          <p class="mb-0 text-muted">Belum ada data Tugas dan Fungsi.</p>
        </div>
      </div>
    @endforelse

  </div>
</section>
@endsection