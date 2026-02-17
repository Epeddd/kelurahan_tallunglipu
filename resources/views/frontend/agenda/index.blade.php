@extends('layouts.frontend')

@section('title','Program & Kegiatan | DISPERKIMTAN-LH Kab. Toraja Utara')

@section('content')
<section class="hero">
  <div class="container">
    <h1 class="display-6 page-head">Program & Kegiatan</h1>
    <p class="mb-0">Program dan Kegiatan Terbaru.</p>
  </div>
</section>

<div class="container my-4">
  <div class="row g-3">
    @forelse($agendas as $item)
      <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          @if($item->attachment)
            <div class="text-center bg-light">
              @php($ext = strtolower(pathinfo($item->attachment, PATHINFO_EXTENSION)))
              @if(in_array($ext, ['jpg','jpeg','png']))
                <img src="{{ asset('storage/'.$item->attachment) }}" alt="Lampiran" style="max-width:640px; width:100%; height:auto; display:block; margin:0 auto;">
              @elseif($ext === 'pdf')
                <div class="p-3">
                  <i class="bi bi-file-earmark-pdf" style="font-size:2rem; color:#dc3545"></i>
                  <div class="small">PDF terlampir</div>
                </div>
              @endif
            </div>
          @endif
          <div class="card-body">
            <h5 class="card-title">{{ $item->title }}</h5>
            <p class="card-text small text-muted mb-1">
              {{ $item->start_date->format('d M Y H:i') }}
              @if($item->end_date)
                - {{ $item->end_date->format('d M Y H:i') }}
              @endif
            </p>
            <p class="card-text">{{ Str::limit(strip_tags($item->description), 120) }}</p>
            <div class="d-flex gap-2">
              <a href="{{ route('agenda.show', $item->id) }}" class="btn btn-sm btn-success">Detail</a>
              @if($item->attachment)
                <a href="{{ asset('storage/'.$item->attachment) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Lihat Lampiran</a>
              @endif
            </div>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="alert alert-light border">Belum ada Program.</div>
      </div>
    @endforelse
  </div>

  <div class="mt-3">
    {{ $agendas->links() }}
  </div>
</div>
@endsection