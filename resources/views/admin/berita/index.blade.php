@extends('layouts.admin')
@section('title','Data Berita')
@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between mb-3">
    <h4>Data Berita</h4>
    <a href="{{ route('admin.berita.create') }}" class="btn btn-volt">Tambah Berita</a>
  </div>
  <div class="card">
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle mb-0">
        <thead>
          <tr>
            <th>Judul</th>
            <th>Status</th>
            <th>Publikasi</th>
            <th width="160">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $item)
          <tr>
            <td>{{ $item->title }}</td>
            <td><span class="badge bg-{{ $item->status=='published'?'success':'secondary' }}">{{ $item->status }}</span></td>
            <td>{{ $item->published_at? $item->published_at->format('d M Y H:i'):'-' }}</td>
            <td>
              <a href="{{ route('admin.berita.edit',$item) }}" class="btn btn-sm btn-volt-outline">Edit</a>
              <form action="{{ route('admin.berita.destroy',$item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Hapus</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="4" class="text-center">Belum ada data</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">{{ $items->links() }}</div>
  </div>
</div>
@endsection