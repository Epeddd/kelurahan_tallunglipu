@extends('layouts.admin')
@section('title','Slides')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4">Slides</h1>
  <a href="{{ route('admin.slides.create') }}" class="btn btn-volt btn-sm">Tambah Slide</a>
</div>
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="table-responsive">
  <table class="table table-striped table-hover align-middle">
    <thead>
      <tr>
        <th>#</th>
        <th>Gambar</th>
        <th>Judul</th>
        <th>Status</th>
        <th>Urutan</th>
        <th>Interval (ms)</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($slides as $slide)
        <tr>
          <td>{{ $slide->id }}</td>
          <td style="width:140px">
            <img src="{{ asset('storage/'.$slide->image_path) }}" alt="" class="img-fluid rounded"/>
          </td>
          <td>{{ $slide->title }}</td>
          <td>
            <span class="badge {{ $slide->status === 'published' ? 'bg-success' : 'bg-secondary' }}">{{ $slide->status }}</span>
          </td>
          <td>{{ $slide->sort_order }}</td>
          <td>{{ $slide->interval_ms ?? '-' }}</td>
          <td>
            <a href="{{ route('admin.slides.edit', $slide) }}" class="btn btn-sm btn-volt-outline">Edit</a>
            <form action="{{ route('admin.slides.destroy', $slide) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus slide ini?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7" class="text-center text-muted">Belum ada slide</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
{{ $slides->links() }}
@endsection