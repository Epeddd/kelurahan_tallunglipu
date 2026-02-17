@extends('layouts.admin')
@section('title','Detail Permohonan')
@section('content')
<div class="container-fluid">
  <h4 class="mb-3">Detail Permohonan</h4>
  <div class="card">
    <div class="card-body">
      <dl class="row mb-0">
        <dt class="col-sm-3">Tanggal</dt><dd class="col-sm-9">{{ $item->created_at->format('d M Y H:i') }}</dd>
        <dt class="col-sm-3">Layanan</dt><dd class="col-sm-9">{{ $item->service?->title }}</dd>
        <dt class="col-sm-3">Nama Pemohon</dt><dd class="col-sm-9">{{ $item->applicant_name }}</dd>
        <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $item->email }}</dd>
        <dt class="col-sm-3">Telepon</dt><dd class="col-sm-9">{{ $item->phone }}</dd>
        <dt class="col-sm-3">Pesan</dt><dd class="col-sm-9">{{ $item->message }}</dd>
        <dt class="col-sm-3">Lampiran</dt>
        <dd class="col-sm-9">
          @php($atts = $item->attachments)
          @if(($atts && $atts->count()) || $item->attachment_path)
            <ul class="mb-0">
              @foreach($atts as $a)
                <li><a href="{{ asset('storage/'.$a->path) }}" target="_blank">Unduh</a></li>
              @endforeach
              @if($item->attachment_path)
                <li><a href="{{ asset('storage/'.$item->attachment_path) }}" target="_blank">Unduh (legacy)</a></li>
              @endif
            </ul>
          @else
            -
          @endif
        </dd>
        <dt class="col-sm-3">Status</dt><dd class="col-sm-9"><span class="badge bg-secondary">{{ $item->status }}</span></dd>
      </dl>
      <hr>
      <form action="{{ route('admin.service-requests.update-status',$item) }}" method="POST" class="d-flex gap-2">
        @csrf @method('PATCH')
        <select name="status" class="form-select" style="max-width:240px">
          <option value="submitted" @selected($item->status=='submitted')>Submitted</option>
          <option value="in_review" @selected($item->status=='in_review')>In Review</option>
          <option value="completed" @selected($item->status=='completed')>Completed</option>
          <option value="rejected" @selected($item->status=='rejected')>Rejected</option>
        </select>
        <button class="btn btn-success">Update Status</button>
      </form>
    </div>
  </div>
</div>
@endsection