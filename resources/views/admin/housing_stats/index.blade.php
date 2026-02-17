@extends('layouts.admin')
@section('title','Data Rumah - Bar Chart')
@section('content')
<div class="container-fluid">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="mb-0">Data Rumah di Kab. Toraja Utara</h4>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-volt">Kembali Dashboard</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="row g-3">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-header bg-white fw-semibold">Kelola Data Batang</div>
        <div class="card-body">
          <form action="{{ route('admin.housing-stats.store') }}" method="POST" class="row g-2 align-items-end">
            @csrf
            <div class="col-md-5">
              <label class="form-label">Label</label>
              <input type="text" name="label" class="form-control" placeholder="Contoh: Jumlah Rumah" required />
            </div>
            <div class="col-md-4">
              <label class="form-label">Nilai</label>
              <input type="number" name="value" class="form-control" min="0" value="0" required />
            </div>
            <div class="col-md-2">
              <label class="form-label">Urutan</label>
              <input type="number" name="sort_order" class="form-control" min="0" value="0" />
            </div>
            <div class="col-md-auto">
              <button class="btn btn-volt d-inline-flex align-items-center text-nowrap"><i class="bi bi-plus-lg me-1"></i>Tambah</button>
            </div>
          </form>

          <hr />

          <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0 table-roomy">
              <thead>
                <tr>
                  <th>Label</th><th style="width:160px">Nilai</th><th style="width:110px">Urutan</th><th style="width:260px">Aksi</th>
                </tr>
              </thead>
              <tbody>
              @forelse($stats as $s)
                <tr>
                  <td>{{ $s->label }}</td>
                  <td>{{ number_format($s->value) }}</td>
                  <td>{{ $s->sort_order }}</td>
                  <td>
                    <div class="d-flex flex-wrap gap-2">
                      <form action="{{ route('admin.housing-stats.update', $s) }}" method="POST" class="d-inline">
                        @csrf @method('PATCH')
                        <input type="hidden" name="label" value="{{ $s->label }}">
                        <input type="hidden" name="value" value="{{ $s->value }}">
                        <input type="hidden" name="sort_order" value="{{ $s->sort_order }}">
                        <button class="btn btn-xs btn-volt-outline d-inline-flex align-items-center"><i class="bi bi-save me-1"></i>Simpan</button>
                      </form>
                      <button class="btn btn-xs btn-primary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#edit{{ $s->id }}"><i class="bi bi-pencil-square me-1"></i>Edit</button>
                      <form action="{{ route('admin.housing-stats.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-xs btn-danger d-inline-flex align-items-center"><i class="bi bi-trash me-1"></i>Hapus</button>
                      </form>
                    </div>

                    <div class="modal fade" id="edit{{ $s->id }}" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header"><h5 class="modal-title">Edit Data</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                          <form action="{{ route('admin.housing-stats.update', $s) }}" method="POST">
                            @csrf @method('PATCH')
                            <div class="modal-body">
                              <div class="mb-2">
                                <label class="form-label">Label</label>
                                <input type="text" name="label" class="form-control" value="{{ $s->label }}" required />
                              </div>
                              <div class="mb-2">
                                <label class="form-label">Nilai</label>
                                <input type="number" name="value" class="form-control" min="0" value="{{ $s->value }}" required />
                              </div>
                              <div class="mb-2">
                                <label class="form-label">Urutan</label>
                                <input type="number" name="sort_order" class="form-control" min="0" value="{{ $s->sort_order }}" />
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                              <button class="btn btn-volt">Simpan</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr><td colspan="4" class="text-center text-muted">Belum ada data</td></tr>
              @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card h-100">
        <div class="card-header bg-white fw-semibold">Catatan</div>
        <div class="card-body">
          <form action="{{ route('admin.housing-note.update') }}" method="POST">
            @csrf
            <textarea name="content" class="form-control" rows="6" placeholder="Tambahkan catatan...">{{ $note->content ?? '' }}</textarea>
            <div class="text-end mt-2">
              <button class="btn btn-volt">Simpan Catatan</button>
            </div>
          </form>
          <hr>
          <div class="fw-semibold mb-1">Presentase Layak vs Tidak Layak</div>
          <form action="{{ route('admin.housing-pie.update') }}" method="POST" class="row g-2">
            @csrf
            <div class="col-6">
              <label class="form-label small">Layak Huni</label>
              <input type="number" name="livable" class="form-control" min="0" step="0.01" value="{{ $pie->livable ?? 0 }}" />
            </div>
            <div class="col-6">
              <label class="form-label small">Tidak Layak Huni</label>
              <input type="number" name="unlivable" class="form-control" min="0" step="0.01" value="{{ $pie->unlivable ?? 0 }}" />
            </div>
            <div class="col-12 text-end">
              <button class="btn btn-volt">Simpan Diagram Lingkaran</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection