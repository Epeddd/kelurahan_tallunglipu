@extends('layouts.admin')

@section('title','Tugas & Fungsi')

@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Tugas & Fungsi</h4>
    <a href="{{ route('admin.tugas.create') }}" class="btn btn-volt">Tambah</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle mb-0">
        <thead>
          <tr>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>PDF</th>
            <th width="160">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $item)
          <tr>
            <td class="fw-semibold">{{ $item->title }}</td>
            <td class="text-muted" style="max-width:480px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ \Illuminate\Support\Str::limit(strip_tags($item->description), 120) }}</td>
            <td>
              @if($item->pdf_path)
                <a href="{{ asset('storage/'.$item->pdf_path) }}" target="_blank" rel="noopener" class="link-primary">Lihat PDF</a>
              @else
                <span class="text-muted">-</span>
              @endif
            </td>
            <td>
              <a href="{{ route('admin.tugas.edit', $item) }}" class="btn btn-sm btn-volt-outline">Edit</a>
              <form action="{{ route('admin.tugas.destroy', $item) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus item ini?')">
                @csrf
                @method('DELETE')
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