<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','Admin - DISPERKIMTAN-LH')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('images/LOGO TORUT.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('images/LOGO TORUT.png') }}">
  <style>
    :root{
      --volt-primary: #6c63ff; /* Volt purple */
      --volt-primary-600: #5b54e6;
      --volt-primary-100: #f0efff;
      --volt-bg: #f8fafc; /* content background */
      --volt-text: #0f172a; /* slate-900 */
      --volt-muted: #64748b; /* slate-500 */
      --volt-card-border: #eef2f7;
      --volt-sidebar-grad-a: #2a2a72;
      --volt-sidebar-grad-b: #009ffd;
    }
    *{ box-sizing: border-box }
    body{ font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial; color: var(--volt-text); background: var(--volt-bg); }

    /* Sidebar */
    .volt-sidebar{
      position: fixed; inset: 0 auto 0 0; width: 260px; z-index: 1030;
      background: linear-gradient(160deg, var(--volt-sidebar-grad-a), var(--volt-sidebar-grad-b));
      color: #e5e7eb; /* slate-200 */
      box-shadow: 0 10px 30px rgba(0,0,0,.15);
      overflow-y: auto;
    }
    .volt-sidebar .brand{
      display:flex; align-items:center; gap:.6rem; padding: 1rem 1.25rem; color:#fff; text-decoration:none; font-weight: 700;
    }
    .volt-sidebar .brand img{ height:28px; width:auto }
    .volt-sidebar .nav-section{ padding: .5rem .5rem 1rem; }
    .volt-sidebar .nav-link{
      color: #f3f4f6; /* gray-100 */
      border-radius: .75rem; margin: .2rem .5rem; padding: .55rem .75rem; display:flex; align-items:center; gap:.6rem;
    }
    .volt-sidebar .nav-link:hover{ background: rgba(255,255,255,.12); color: #fff; }
    .volt-sidebar .nav-link.active{ background: rgba(255,255,255,.18); color: #fff; }

    /* Content area */
    .content-area{ margin-left: 260px; min-height: 100vh; background: var(--volt-bg); }

    /* Topbar */
    .volt-topbar{ position: sticky; top: 0; z-index: 1020; background: #fff; box-shadow: 0 6px 18px rgba(15,23,42,.06); }
    .volt-topbar .form-control{ border-radius: 999px; }

    /* Cards */
    .card{ border: 1px solid var(--volt-card-border); border-radius: 1rem; }
    .card-header{ border-bottom: 1px solid var(--volt-card-border); border-top-left-radius: 1rem; border-top-right-radius: 1rem; }

    /* Icon shape (Volt-like) */
    .icon-shape{ display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; border-radius: .85rem; }
    .icon-shape-primary{ background: rgba(108,99,255,.12); color: var(--volt-primary); }
    .icon-shape-success{ background: rgba(16,185,129,.12); color: #10b981; }
    .icon-shape-warning{ background: rgba(245,158,11,.12); color: #f59e0b; }
    .icon-shape-danger{ background: rgba(239,68,68,.12); color: #ef4444; }

    /* Buttons */
    .btn-volt{ background: var(--volt-primary); color:#fff; border:none; }
    .btn-volt:hover{ background: var(--volt-primary-600); color:#fff; }
    .btn-volt-outline{ background: transparent; color: var(--volt-primary); border: 1px solid var(--volt-primary); }
    .btn-volt-outline:hover{ background: var(--volt-primary); color:#fff; border-color: var(--volt-primary-600); }

    /* Extra small button utility */
    .btn-xs{ padding: .15rem .4rem; font-size: .75rem; border-radius: .2rem; }

    /* Roomier table rows for admin lists */
    .table-roomy thead th{ padding-top: .75rem; padding-bottom: .75rem; }
    .table-roomy tbody td{ padding-top: .9rem; padding-bottom: .9rem; }
    /* Ensure action buttons have enough gap even when forms wrap */
    .table-roomy .d-flex.gap-2 > *{ margin: 0; }

    /* Collapse sidebar on mobile */
    @media (max-width: 991.98px){
      .content-area{ margin-left: 0; }
      .volt-sidebar{ transform: translateX(-100%); transition: transform .25s ease; }
      body.sidebar-open .volt-sidebar{ transform: translateX(0); }
    }
  </style>
  @php($tinymceKey = config('services.tinymce.key'))
  @if(!empty($tinymceKey))
    <script src="https://cdn.tiny.cloud/1/{{ $tinymceKey }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  @else
    <!-- Fallback to TinyMCE community CDN (no key) to avoid API key warning -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
  @endif
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  @include('layouts.chart-plugins')
  @stack('head')
</head>
<body>
  <div class="volt-sidebar" id="voltSidebar">
    <a href="{{ route('admin.dashboard') }}" class="brand">
      <img src="{{ asset('images/LOGO TORUT.png') }}" alt="Logo">
      <span>KELURAHAN TALLUNGLIPU</span>
    </a>
    <div class="nav-section">
      <nav class="nav flex-column">
        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
          <i class="bi bi-speedometer2"></i> <span>Beranda</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.tugas.*') ? 'active' : '' }}" href="{{ route('admin.tugas.index') }}">
          <i class="bi bi-journal-text"></i> <span>Profil</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.infografis.*') ? 'active' : '' }}" href="{{ route('admin.infografis.index') }}">
          <i class="bi bi-bar-chart"></i> <span>Infografis</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}" href="{{ route('admin.berita.index') }}">
          <i class="bi bi-newspaper"></i> <span>Berita</span>
        </a>
        <a class="nav-link {{ request()->routeIs('admin.slides.*') ? 'active' : '' }}" href="{{ route('admin.slides.index') }}">
          <i class="bi bi-images"></i> <span>Carousel</span>
        </a>
      </nav>
    </div>
  </div>

  <div class="content-area">
    <nav class="volt-topbar navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
        <button class="btn btn-outline-secondary d-lg-none" id="sidebarToggle" type="button" aria-label="Toggle sidebar">
          <i class="bi bi-list"></i>
        </button>
        <form class="ms-2 d-none d-md-flex" role="search" onsubmit="return false;" style="max-width:340px; width:100%">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
            <input class="form-control border-start-0" type="search" placeholder="Cari…" aria-label="Cari">
          </div>
        </form>
        <div class="ms-auto d-flex align-items-center gap-3">
          <a class="btn btn-sm btn-outline-secondary" href="{{ route('home') }}" target="_blank">Lihat Website</a>
          <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-box-arrow-right me-1"></i> Logout</button>
          </form>
        </div>
      </div>
    </nav>

    <main class="p-3 p-md-4">
      @yield('content')
    </main>

    <footer class="text-center py-3 small text-muted">
      © {{ date('Y') }} KELURAHAN TALLUNGLIPU
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (function(){
      const toggle = document.getElementById('sidebarToggle');
      if(toggle){ toggle.addEventListener('click', ()=> document.body.classList.toggle('sidebar-open')); }
    })();
  </script>
  @stack('scripts')
</body>
</html>