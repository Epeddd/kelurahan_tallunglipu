<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h4 class="mb-3">Login Admin</h4>
            @if($errors->any())
              <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            @if(session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form action="{{ route('admin.login.submit') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label class="form-label">ID / Email</label>
                <input type="text" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button class="btn btn-success w-100">Masuk</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>