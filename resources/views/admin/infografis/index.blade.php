@extends('layouts.admin')

@section('title', 'Kelola Penduduk - Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
    <div class="d-block mb-4 mb-md-0">
        <h2 class="h4">Data Penduduk</h2>
        <p class="mb-0">Kelola data penduduk Kelurahan Tallunglipu.</p>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.infografis.create') }}" class="btn btn-sm btn-volt">
            <i class="bi bi-plus-lg"></i> Tambah Penduduk
        </a>
    </div>
</div>

<div class="card border-0 shadow mb-4">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-md-6">
                <form action="{{ route('admin.infografis.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari NIK atau No. KK..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-volt">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('admin.infografis.index') }}" class="btn btn-outline-secondary">Reset</a>
                    @endif
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0 rounded-start">Nama</th>
                        <th class="border-0">NIK</th>
                        <th class="border-0">No. KK</th>
                        <th class="border-0">Wilayah</th>
                        <th class="border-0">Status</th>
                        <th class="border-0 rounded-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                        <td class="fw-bold">{{ $item->name }}</td>
                        <td>{{ $item->nik }}</td>
                        <td>{{ $item->no_kk }}</td>
                        <td>{{ $item->wilayah }}</td>
                        <td>
                            <span class="badge {{ $item->status == 'Tallunglipu' ? 'bg-success' : 'bg-warning' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.infografis.edit', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.infografis.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
