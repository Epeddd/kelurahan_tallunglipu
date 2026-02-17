@extends('layouts.frontend')

@section('title','Pencarian')

@section('content')
<section class="hero">
  <div class="container">
    <h1 class="display-6 page-head">Hasil Pencarian</h1>
    <p class="mb-0">Kata kunci: <strong>{{ $q }}</strong></p>
  </div>
</section>

<div class="container my-4">
  @if(!$q)
    <div class="alert alert-light border">Silakan masukkan kata kunci.</div>
  @else
    @php($grouped = $results->groupBy('type'))

    <div class="row g-4">
      <div class="col-12">
        <h5 class="mb-3">Berita</h5>
        @forelse($grouped->get('berita', collect()) as $item)
          <div class="mb-2">
            <a href="{{ route('berita.show', $item->id) }}" class="fw-semibold">{{ $item->title }}</a>
            <div class="small text-muted">{{ optional($item->date)->format('d M Y') }}</div>
          </div>
        @empty
          <div class="text-muted">Tidak ada hasil.</div>
        @endforelse
      </div>

      <div class="col-12">
        <h5 class="mb-3 mt-4">Layanan</h5>
        @forelse($grouped->get('layanan', collect()) as $item)
          <div class="mb-2">
            <a href="{{ route('layanan.show', $item->id) }}" class="fw-semibold">{{ $item->title }}</a>
          </div>
        @empty
          <div class="text-muted">Tidak ada hasil.</div>
        @endforelse
      </div>

      <div class="col-12">
        <h5 class="mb-3 mt-4">Agenda</h5>
        @forelse($grouped->get('agenda', collect()) as $item)
          <div class="mb-2">
            <a href="{{ route('agenda.show', $item->id) }}" class="fw-semibold">{{ $item->title }}</a>
            <div class="small text-muted">{{ optional($item->date)->format('d M Y H:i') }} · {{ $item->extra }}</div>
          </div>
        @empty
          <div class="text-muted">Tidak ada hasil.</div>
        @endforelse
      </div>
    </div>
  @endif
</div>
@endsection