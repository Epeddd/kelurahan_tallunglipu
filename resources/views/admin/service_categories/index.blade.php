@extends('layouts.admin')
@section('title','Data Kategori Layanan')
@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between mb-3">
    <h4>Data Kategori Layanan</h4>
    <a href="{{ route('admin.service-categories.create') }}" class="btn btn-volt">Tambah Kategori</a>
  </div>
  <div class="card">
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle mb-0">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Slug</th>
            <th width="160">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $item)
          <tr>
            <td>{{ $item->name }}</td>
            <td><code>{{ $item->slug }}</code></td>
            <td>
              <a href="{{ route('admin.service-categories.edit',$item) }}" class="btn btn-sm btn-volt-outline">Edit</a>
              <form action="{{ route('admin.service-categories.destroy',$item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Hapus</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="3" class="text-center">Belum ada data</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">{{ $items->links() }}</div>
  </div>
</div>
@endsection