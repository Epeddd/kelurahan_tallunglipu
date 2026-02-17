@extends('layouts.admin')
@section('title','Data Program')
@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between mb-3">
    <h4>Data Program</h4>
    <a href="{{ route('admin.agenda.create') }}" class="btn btn-volt">Tambah Program</a>
  </div>
  <div class="card">
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle mb-0">
        <thead>
          <tr>
            <th style="width:90px">Lampiran</th>
            <th>Judul</th>
            <th>Mulai</th>
            <th>Lokasi</th>
            <th>Status</th>
            <th width="180">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $item)
          <tr>
            <td>
              @if($item->attachment)
                @php($ext = strtolower(pathinfo($item->attachment, PATHINFO_EXTENSION)))
                @if(in_array($ext, ['jpg','jpeg','png']))
                  <img src="{{ asset('storage/'.$item->attachment) }}" alt="Lampiran" style="max-width:80px; width:100%; height:auto; border-radius:6px;" />
                @elseif($ext === 'pdf')
                  <span class="badge bg-danger-subtle text-danger"><i class="bi bi-file-earmark-pdf"></i> PDF</span>
                @endif
              @else
                <span class="text-muted small">—</span>
              @endif
            </td>
            <td>{{ $item->title }}</td>
            <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d M Y H:i') }}</td>
            <td>{{ $item->location }}</td>
            <td><span class="badge bg-{{ $item->status=='published'?'success':'secondary' }}">{{ $item->status }}</span></td>
            <td>
              <a href="{{ route('admin.agenda.edit',$item) }}" class="btn btn-sm btn-volt-outline">Edit</a>
              <form action="{{ route('admin.agenda.destroy',$item) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Hapus</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center">Belum ada data</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="card-footer">{{ $items->links() }}</div>
  </div>
</div>
@endsection