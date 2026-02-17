@extends('layouts.admin')
@section('title','Data Permohonan Layanan')
@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between mb-3">
    <h4 class="mb-0">Data Permohonan Layanan</h4>
  </div>
  <div class="card">
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle mb-0">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Layanan</th>
            <th>Nama</th>
            <th>Status</th>
            <th width="160">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $item)
          <tr>
            <td>{{ $item->created_at->format('d M Y H:i') }}</td>
            <td>{{ $item->service?->title }}</td>
            <td>{{ $item->applicant_name }}</td>
            <td><span class="badge bg-secondary">{{ $item->status }}</span></td>
            <td>
              <a href="{{ route('admin.service-requests.show',$item) }}" class="btn btn-sm btn-volt-outline">Detail</a>
              <form action="{{ route('admin.service-requests.destroy',$item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Hapus</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center">Belum ada data</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">{{ $items->links() }}</div>
  </div>
</div>
@endsection