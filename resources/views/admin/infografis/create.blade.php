@extends('layouts.admin')

@section('title', 'Tambah Penduduk - Admin')

@section('content')
<div class="py-4">
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
        <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.infografis.index') }}">Infografis</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Penduduk</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Tambah Penduduk</h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-xl-8">
        <div class="card card-body border-0 shadow mb-4">
            <form action="{{ route('admin.infografis.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name">Nama Penduduk</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="nik">NIK</label>
                    <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" id="nik" value="{{ old('nik') }}" required>
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="no_kk">No. KK</label>
                    <input type="text" name="no_kk" class="form-control @error('no_kk') is-invalid @enderror" id="no_kk" value="{{ old('no_kk') }}" required>
                    @error('no_kk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="wilayah">Wilayah Tempat Tinggal</label>
                    <select name="wilayah" id="wilayah" class="form-select @error('wilayah') is-invalid @enderror" required>
                        <option value="">Pilih Wilayah</option>
                        <option value="Bo'ne Limbong" {{ old('wilayah') == "Bo'ne Limbong" ? 'selected' : '' }}>Bo'ne Limbong</option>
                        <option value="Bo'ne Matampu' Selatan" {{ old('wilayah') == "Bo'ne Matampu' Selatan" ? 'selected' : '' }}>Bo'ne Matampu' Selatan</option>
                        <option value="Bo'ne Matampu' Utara" {{ old('wilayah') == "Bo'ne Matampu' Utara" ? 'selected' : '' }}>Bo'ne Matampu' Utara</option>
                        <option value="Bo'ne Randanan" {{ old('wilayah') == "Bo'ne Randanan" ? 'selected' : '' }}>Bo'ne Randanan</option>
                    </select>
                    @error('wilayah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="status">Status Penduduk</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="">Pilih Status</option>
                        <option value="Tallunglipu" {{ old('status') == "Tallunglipu" ? 'selected' : '' }}>Penduduk Tallunglipu</option>
                        <option value="Non-Permanent" {{ old('status') == "Non-Permanent" ? 'selected' : '' }}>Penduduk Non-Permanent</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-volt">Simpan</button>
                    <a href="{{ route('admin.infografis.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
