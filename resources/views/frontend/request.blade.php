@extends('layouts.frontend')
@section('title','Permohonan Layanan')
@section('content')
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="card glass-card border-0">
          <div class="card-body">
            <h4 class="fw-bold mb-3 premium-section-title text-center">Form Permohonan Layanan</h4>
            <p class="text-muted small text-center mb-4">Silakan isi data berikut untuk mengajukan permohonan layanan. Pastikan data terisi dengan benar.</p>

            <form action="{{ route('permohonan.submit') }}" method="POST" enctype="multipart/form-data" novalidate>
              @csrf

              <div class="mb-3">
                <label for="service_id" class="form-label">Jenis Layanan</label>
                <select name="service_id" id="service_id" class="form-select @error('service_id') is-invalid @enderror" required>
                  <option value="" disabled {{ old('service_id', optional($service)->id) ? '' : 'selected' }}>-- pilih layanan --</option>
                  @foreach($services as $s)
                    <option value="{{ $s->id }}" {{ (string)old('service_id', optional($service)->id) === (string)$s->id ? 'selected' : '' }}>
                      {{ $s->title }}
                    </option>
                  @endforeach
                </select>
                @error('service_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="row g-3">
                <div class="col-md-6">
                  <label for="applicant_name" class="form-label">Nama Pemohon</label>
                  <input type="text" name="applicant_name" id="applicant_name" class="form-control @error('applicant_name') is-invalid @enderror" value="{{ old('applicant_name') }}" required>
                  @error('applicant_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                  @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="row g-3 mt-0">
                <div class="col-md-6">
                  <label for="phone" class="form-label">No. Telepon (opsional)</label>
                  <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                  @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label for="attachments" class="form-label">Lampiran (opsional, bisa beberapa file, masing-masing maks. 2MB)</label>
                  <input type="file" name="attachments[]" id="attachments" multiple class="form-control @error('attachments.*') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                  @error('attachments.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="mt-3">
                <label for="message" class="form-label">Pesan/Deskripsi (opsional)</label>
                <textarea name="message" id="message" rows="5" class="form-control @error('message') is-invalid @enderror" placeholder="Tuliskan detail permohonan Anda...">{{ old('message') }}</textarea>
                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="d-grid mt-4">
                <button type="submit" class="btn btn-success">Kirim Permohonan</button>
              </div>
            </form>
          </div>
        </div>

        <div class="text-center mt-3">
          <a href="{{ route('layanan.index') }}" class="btn btn-light btn-sm">Lihat Daftar Layanan</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection