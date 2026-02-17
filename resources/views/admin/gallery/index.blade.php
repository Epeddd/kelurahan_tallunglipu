@extends('layouts.admin')
@section('title','Galeri')
@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Galeri</h4>
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-volt">Tambah Foto</a>
  </div>
  <div class="card">
    <div class="card-body">
      @if($items->isEmpty())
        <div class="text-muted">Belum ada data.</div>
      @else
        <div class="row g-3">
          @foreach($items as $g)
            <div class="col-md-3 col-sm-4 col-6">
              <div class="card h-100">
                @php($first = $g->images->first())
                @if($first)
                  <img src="{{ asset('storage/'.$first->image_path) }}" class="card-img-top" alt="{{ $g->title }}" style="object-fit:cover;height:160px">
                @else
                  <div class="bg-light" style="height:160px"></div>
                @endif
                <div class="card-body p-2">
                  <div class="fw-semibold mb-1" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $g->title }}</div>
                  <span class="badge bg-{{ $g->status=='published'?'success':'secondary' }}">{{ $g->status }}</span>
                  <div class="small text-muted">{{ $g->images->count() }} foto</div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                  <a href="{{ route('admin.gallery.edit', $g) }}" class="btn btn-sm btn-volt-outline">Edit</a>
                  <form action="{{ route('admin.gallery.destroy', $g) }}" method="POST" onsubmit="return confirm('Hapus item?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                  </form>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="mt-3">{{ $items->links() }}</div>
      @endif
    </div>
  </div>
</div>
@endsection