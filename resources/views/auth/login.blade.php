@extends('layouts.frontend')
@section('title', 'Login Admin')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card glass-card">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/LOGO TORUT.png') }}" alt="Logo" style="height: 80px;" class="mb-3">
                        <h4 class="fw-bold premium-title">Login Admin</h4>
                        <p class="text-muted small">Silahkan masuk ke panel administrasi</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger small">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-bold">Email / Username</label>
                            <input type="text" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection
