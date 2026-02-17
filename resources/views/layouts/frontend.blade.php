<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kelurahan Tallunglipu')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO TORUT.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/LOGO TORUT.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/LOGO TORUT.png') }}">
    <style>
        html, body{
            font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, 'Apple Color Emoji', 'Segoe UI Emoji';
            /* Global background image */
            background: url('{{ asset('images/BG3.jpg') }}') center/cover no-repeat fixed;
            background-color: #ffffff; /* fallback */
        }
        @media (max-width: 576px){
            /* Mobile: keep plain background image */
            body{
                background: url('{{ asset('images/BG3.jpg') }}') center/cover no-repeat fixed;
                background-color: #ffffff;
            }
        }
        .navbar-brand{font-weight:700}
        /* Hero with background image and green overlay aligned in same section */
        .hero{
            position: relative;
            color:white;
            padding: 60px 0 100px; /* extra bottom space for ticker */
            background: url('{{ asset('images/BG1.jpg') }}') center/cover no-repeat;
        }
        .hero::before{
            content: "";
            position: absolute;
            inset: 0; /* top:0; right:0; bottom:0; left:0 */
            background: linear-gradient(120deg, rgba(15,81,50,.9), rgba(25,135,84,.9));
            pointer-events: none;
            z-index: 0; /* keep below navbar & dropdowns */
        }
        .hero > *{ position: relative; z-index: 1; }
        /* Hero ticker */
        .hero-ticker{
            position: absolute;
            left: 0; right: 0; bottom: 0;
            z-index: 900;
            background: #fd7e14; /* orange */
            color: #fff;
            height: 44px;
            overflow: hidden;
            display: flex; align-items: center;
            box-shadow: inset 0 1px 0 rgba(255,255,255,.2);
        }
        .hero-ticker .ticker-inner{
            white-space: nowrap;
            will-change: transform;
            display: inline-block;
            padding-left: 100%;
            animation: ticker-move 28s linear infinite; /* slower */
            font-weight: 600;
            letter-spacing: .2px;
        }
        .hero-ticker .separator{ opacity:.8; margin: 0 .75rem; }
        .hero-ticker .bi-megaphone-fill{ margin-right: .5rem; }
        @keyframes ticker-move{
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }
        .footer{background:#0f172a; color:#94a3b8}
        .footer a{color:#cbd5e1}
        .navbar-brand img.nav-logo{height:50px;width:auto;margin-right:8px}
        .navbar-right-logo{height:50px;width:auto}
        .navbar{padding-top:0.75rem;padding-bottom:0.75rem; position: relative; z-index: 2000}
        .dropdown-menu{ z-index: 2050; }
        .navbar-brand .brand-text{font-size:1.35rem;margin-right:.5rem}
        .home-hero-logo{height:60px;width:auto;margin-right:12px}
/* white circular background behind KemenLH logo */
.logo-circle{
    background:#fff;
    border-radius:50%;
    padding:8px;             /* space to create a visible white ring */
    box-shadow: 0 2px 6px rgba(0,0,0,.15); /* subtle lift */
}
@media (max-width: 576px){
    .home-hero-logo{height:50px}
    .logo-circle{padding:6px}
}


        /* Carousel styles */
        .pro-carousel .carousel-item{
            height: 380px;
        }
        .pro-carousel .carousel-item img{
            object-fit: cover; width: 100%; height: 100%;
            transition: transform .5s ease, filter .5s ease;
            filter: saturate(1) contrast(1);
        }
        .pro-carousel .carousel-item:hover img{
            transform: scale(1.03);
            filter: saturate(1.08) contrast(1.05);
        }
        .pro-carousel .carousel-caption{
            background: rgba(0,0,0,.45);
            backdrop-filter: blur(4px);
            padding: .5rem .75rem; border-radius: .5rem;
        }
        /* Premium headings */
        .premium-title, .premium-section-title{
            font-family: 'Sora', ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
            letter-spacing: .3px;
        }
        .premium-section-title{ font-weight:700; }

        /* Page head underline */
        .page-head {
            position: relative;
            display: inline-block;
            padding-bottom: .35rem;
        }
        .page-head::after{
            content: "";
            position: absolute;
            left: 0; bottom: 0;
            width: 1cm; /* requested length */
            height: 3px;
            background: #ff8c00; /* orange */
            border-radius: 2px;
        }

        .pro-carousel .carousel-indicators [data-bs-target]{
            width: 10px; height: 10px; border-radius: 50%;
            background-color: rgba(255,255,255,.7);
        }
        .pro-carousel .carousel-indicators .active{
            background-color: #fff;
        }
        .pro-carousel .carousel-control-prev, .pro-carousel .carousel-control-next{
            opacity:.85;
            transition: opacity .2s ease;
        }
        .pro-carousel .carousel-control-prev:hover, .pro-carousel .carousel-control-next:hover{
            opacity:1;
        }

        /* Press/scale animation for buttons and nav links */
        /* Restrict overflow:hidden to buttons/toggler only to avoid clipping dropdowns */
        .btn, .navbar-toggler, .btn-close {
            position: relative;
            overflow: hidden;
            transition: transform .08s ease, filter .2s ease;
        }
        .nav-link, .dropdown-item { transition: transform .08s ease, filter .2s ease; }
        .btn:active, .navbar-toggler:active, .btn-close:active {
            transform: scale(.97);
            filter: brightness(.95);
        }
        .nav-link:active, .dropdown-item:active{ transform: scale(.98); filter: brightness(.97); }

        /* Ripple effect */
        .ripple::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            opacity: .45;
            pointer-events: none;
            background: radial-gradient(circle, rgba(255,255,255,.6) 10%, rgba(255,255,255,0) 70%);
            width: var(--ripple-size, 20px);
            height: var(--ripple-size, 20px);
            left: calc(var(--ripple-x, 0px) - var(--ripple-size, 20px)/2);
            top: calc(var(--ripple-y, 0px) - var(--ripple-size, 20px)/2);
            animation: ripple .5s ease-out;
        }
        @keyframes ripple {
            to { transform: scale(6); opacity: 0; }
        }

        /* Apply ripple to common clickable items */
        .btn, .nav-link, .dropdown-item, .navbar-toggler { --ripple-size: 28px; }

        /* Glass premium cards with green brand accent */
        :root{
            --brand-700: #0f5132; /* darker green */
            --brand-600: #157347; /* bootstrap success-ish */
            --brand-500: #198754; /* bootstrap success */
            --brand-100: #d1e7dd; /* light tint */
        }
        .glass-card{
            background: rgba(255,255,255,.9); /* 90% opacity */
            color:#0f172a;
            border: 1px solid rgba(255,255,255,.55);
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0,0,0,.14), inset 0 1px 0 rgba(255,255,255,.6);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .glass-card .card-title{ color: var(--brand-700); letter-spacing:.2px }
        .glass-card hr{ border-color: rgba(25,135,84,.28); opacity: 1; }
        .glass-card .btn-outline-success{
            --bs-btn-color: var(--brand-600);
            --bs-btn-border-color: var(--brand-600);
            --bs-btn-hover-bg: var(--brand-600);
            --bs-btn-hover-border-color: var(--brand-600);
            --bs-btn-active-bg: var(--brand-700);
            --bs-btn-active-border-color: var(--brand-700);
            box-shadow: inset 0 -1px 0 rgba(255,255,255,.4);
        }
        .glass-card:hover{ transform: translateY(-2px); transition: transform .2s ease, box-shadow .2s ease; box-shadow: 0 14px 30px rgba(0,0,0,.2), inset 0 1px 0 rgba(255,255,255,.65); }
        .glass-card .list-unstyled li strong{ color: var(--brand-600); }
        .glass-card .card-body{ border-radius: 12px; background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(25,135,84,.03)); }
        .icon-text{ display:flex; gap:.5rem; align-items:flex-start; }
        .icon-text .bi{ color: var(--brand-600); font-size: 1rem; margin-top: .15rem; }
        .icon-text span{ display:inline-block; }

        /* Modern rating section - compact, premium */
        .rating-section{
            position: relative;
            border-radius: 16px;
            padding: .75rem .9rem; /* compact */
            color: #0f172a; /* dark text for better readability */
            background:
              linear-gradient(180deg, #ffffff, #f6fffb);
            border: 1px solid rgba(21,115,71,.2);
            box-shadow: 0 8px 22px rgba(16,185,129,.12);
            overflow: hidden;
        }
        .rating-section::after{
            /* subtle pattern glow */
            content:""; position:absolute; inset:auto -20% -40% -20%; height:140px;
            background: radial-gradient(closest-side, rgba(255,255,255,.18), transparent);
            filter: blur(12px);
        }
        .rating-section .rating-emoji{ color: var(--brand-600); font-size: 1.15rem; }
        .rating-section .rating-badge{
            background: var(--brand-600);
            color: #fff;
            padding: .2rem .5rem; border-radius: 999px;
            font-weight: 700; font-size: .82rem;
            box-shadow: 0 6px 16px rgba(21,115,71,.22);
        }
        .rating-section .rating-body{ margin-top: .35rem; }
        .rating-section .rating-stars i{
            font-size: 1.45rem; color: #f59e0b; cursor: pointer;
            transition: transform .12s ease, filter .2s ease; margin-right: .15rem;
            text-shadow: none;
        }
        .rating-section .rating-stars i:hover{ transform: translateY(-1px) scale(1.08); filter: brightness(1.05); }
        .rating-section .progress{ height: 10px; background: rgba(255,255,255,.35); }
        .rating-section .progress-bar{
            background: linear-gradient(90deg, #fff, #e7ffe7);
            box-shadow: 0 6px 16px rgba(0,0,0,.15), inset 0 1px 0 rgba(0,0,0,.05);
        }
        /* Donut chart styling */
        .rating-donut{ display:block; filter: drop-shadow(0 6px 14px rgba(16,185,129,.18)); }
        .rating-donut .ring-bg{ fill:none; stroke: rgba(21,115,71,.18); stroke-width:10; }
        .rating-donut .ring-fg{ fill:none; stroke: url(#ratingGrad); stroke-width:10; stroke-linecap:round; transform: rotate(-90deg); transform-origin: 50% 50%; stroke-dasharray: 339.292; stroke-dashoffset: 339.292; transition: stroke-dashoffset .7s cubic-bezier(.2,.8,.2,1); }
        .rating-donut .ring-label{ fill: var(--brand-700); font-weight:700; font-size: 18px; }

        /* Button theme - modern */
        .btn{
            border-radius: 6px; /* less rounded, rectangular with slight radius */
            font-weight: 600;
            letter-spacing: .2px;
            padding: .55rem 1rem;
            border: none;
            box-shadow: 0 8px 18px rgba(21,115,71,.12), 0 2px 6px rgba(0,0,0,.06);
            transition: background-color .25s ease, color .25s ease, border-color .25s ease, box-shadow .25s ease, transform .15s ease, filter .2s ease;
        }
        .btn:hover{ transform: translateY(-1px); box-shadow: 0 12px 24px rgba(21,115,71,.16), 0 4px 10px rgba(0,0,0,.08); }
        .btn:active{ transform: translateY(0); box-shadow: 0 6px 14px rgba(21,115,71,.12), 0 2px 6px rgba(0,0,0,.06); }
        .btn-success{
            background-image: linear-gradient(180deg, #1aa060, var(--brand-600));
            color:#fff;
        }
        .btn-light{
            background: linear-gradient(180deg, #ffffff, #f4f7f5);
            border: 1px solid rgba(0,0,0,.06);
        }
        .btn[class*="btn-outline-"]{
            border-width: 2px;
            box-shadow: inset 0 -1px 0 rgba(255,255,255,.35);
        }
        .btn-outline-success{
            --bs-btn-color: var(--brand-600);
            --bs-btn-border-color: var(--brand-600);
            --bs-btn-hover-bg: var(--brand-600);
            --bs-btn-hover-border-color: var(--brand-600);
            --bs-btn-active-bg: var(--brand-700);
            --bs-btn-active-border-color: var(--brand-700);
        }

        /* Floating scroll-to-top button */
        .scroll-top-btn{
            position: fixed; right: 18px; bottom: 18px;
            width: 48px; height: 48px; border-radius: 50%;
            display: none; align-items: center; justify-content: center;
            background: var(--brand-600); color:#fff; border: none;
            box-shadow: 0 10px 20px rgba(21,115,71,.28), 0 4px 10px rgba(0,0,0,.12);
            z-index: 1050; cursor: pointer;
        }
        .scroll-top-btn.show{ display: flex; }
        .scroll-top-btn:hover{ background: var(--brand-700); }
        .scroll-top-btn .bi{ font-size: 1.25rem; }

        /* Menu link color override */
        .navbar .navbar-nav .nav-link,
        .navbar .nav-link,
        .navbar .dropdown-toggle{ color:#fff !important; }
        .navbar .navbar-nav .nav-link:hover,
        .navbar .navbar-nav .nav-link:focus,
        .navbar .navbar-nav .nav-link.active,
        .navbar .navbar-nav .nav-link.show{ color:#fff !important; opacity:.95; }

        /* Search styling */
        .navbar .search-form{ min-width: 180px; }
        .navbar .search-form .form-control{
            background: rgba(255,255,255,.18);
            border: 1px solid rgba(255,255,255,.35);
            color:#fff;
            padding: .5rem 2.25rem .5rem .90rem; /* extra right space for icon */
            border-radius: 999px; /* pill */
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.25), 0 6px 12px rgba(0,0,0,.12);
            transition: width .2s ease, background .2s ease, box-shadow .2s ease;
            width: 180px;
        }
        .navbar .search-form .form-control::placeholder{ color: rgba(255,255,255,.9) }
        .navbar .search-form .form-control:focus{
            background: rgba(255,255,255,.26);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.35), 0 10px 20px rgba(0,0,0,.18);
            width: 240px; /* expand on focus */
        }
        @media (max-width: 992px){
            .navbar .search-form .form-control{ width: 100%; }
        }
        .navbar .search-form .search-icon{
            position: absolute;
            right: .65rem;
            top: 50%;
            transform: translateY(-50%);
            color: #fff;
            opacity: .95;
            pointer-events: none;
        }

        /* Preloader and smooth page enter (no fade, only movement) */
        body{ transform: translateY(6px); transition: transform .4s ease-out; }
        body.page-loaded{ transform:none; }
        /* Background bounce via background-position (no pseudo-element) */
        body.page-loaded{ animation: bg-bounce-in .65s cubic-bezier(.22,1.25,.36,1) both; }
        .preloader{ position:fixed; inset:0; display:flex; align-items:center; justify-content:center; background:#ffffff; z-index:2000; transition: opacity .3s ease; }
        .preloader.hide{ opacity:0; pointer-events:none; }
        @keyframes bg-bounce-in{
            0%{ background-position: center 24px; }
            60%{ background-position: center -8px; }
            100%{ background-position: center 0; }
        }

        /* Bounce-in on enter (no fade) */
        .bounce-child{ will-change: transform; }
        body.page-loaded .bounce-child{
            animation: bounce-in .65s cubic-bezier(.22,1.25,.36,1) both;
            animation-delay: var(--bounce-delay, 0s);
            transform-origin: center bottom;
        }
        @keyframes bounce-in{
            0%{ transform: translateY(18px) scale(.98); }
            60%{ transform: translateY(-6px) scale(1.01); }
            100%{ transform: translateY(0) scale(1); }
        }
        @media (prefers-reduced-motion: reduce){
            body{ transition: none !important; }
            .preloader{ transition: none !important; }
            body.page-loaded .bounce-child{ animation: none !important; opacity:1; transform:none; }
        }
        /* Make content images full width, not cropped */
        .content img{ width:100%; height:auto; max-width:100%; display:block; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @include('layouts.chart-plugins')
    @stack('head')
</head>
<body>
<div id="preloader" class="preloader" aria-label="Memuat.." role="status">
  <div class="spinner-border text-success" style="width:3rem;height:3rem" role="status">
    <span class="visually-hidden">Memuat...</span>
  </div>
</div>
<nav class="navbar navbar-expand-lg navbar-dark bg-success bounce-child" style="--bounce-delay: .05s; position: sticky; top: 0; z-index: 1100">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center bounce-child" style="--bounce-delay: .1s" href="{{ route('home') }}">
      <img class="nav-logo me-2" src="{{ asset('images/LOGO TORUT.png') }}" alt="Pemkab Torut">
      <span class="brand-text">KELURAHAN TALLUNGLIPU</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('berita.index') }}">Berita</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('profil.tugas') }}">Profil</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('pju.index') }}">Infografis</a></li>
        <li class="nav-item d-flex align-items-center ms-lg-3">
          <form action="{{ route('search') }}" method="GET" class="search-form position-relative" role="search">
            <input class="form-control form-control-sm" type="search" name="q" placeholder="Cari..." aria-label="Search" required>
            <span class="search-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85zm-5.242 1.156a5 5 0 1 1 0-10 5 5 0 0 1 0 10z"/>
              </svg>
            </span>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>


<div id="pageContent" class="bounce-child" style="--bounce-delay: .18s">
@yield('content')
</div>

<footer class="footer mt-5 pt-4 pb-0 bounce-child" style="--bounce-delay: .26s">
  <div class="container">
    <!-- Top connect strip -->
    <div class="border-bottom border-success-subtle pb-3 mb-4 d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
      <div class="mb-3 mb-md-0">
        <h5 class="mb-1">Tetap Terhubung</h5>
        <small>Ikuti kabar terbaru Kelurahan Tallunglipu.</small>
      </div>
      <div class="d-flex align-items-center gap-2">
        <a href="#" class="btn btn-light btn-sm"><i class="bi bi-facebook me-1"></i> Facebook</a>
        <a href="#" class="btn btn-light btn-sm"><i class="bi bi-instagram me-1"></i> Instagram</a>
        <a href="#" class="btn btn-light btn-sm"><i class="bi bi-youtube me-1"></i> YouTube</a>
        <a href="{{ route('kontak') }}" class="btn btn-success btn-sm">Kontak Kami</a>
      </div>
    </div>

    <!-- Main footer content -->
    <div class="row g-4">
      <!-- Brand & partners -->
      <div class="col-lg-4">
        <div class="d-flex align-items-start gap-3">
          <img src="{{ asset('images/LOGO TORUT.png') }}" alt="Logo Kabupaten Toraja Utara" style="width:52px;height:52px;object-fit:contain;" class="mt-1">
          <div>
            <h5 class="mb-1">Kelurahan Tallunglipu</h5>
            <p class="mb-2 small">Pelayanan prima, transparansi, dan keberlanjutan lingkungan untuk masyarakat Kelurahan Tallunglipu.</p>
            <div class="d-flex align-items-center gap-3 flex-wrap">
              <img src="{{ asset('images/LOGO TORUT.png') }}" alt="Toraja Utara" style="height:28px;width:auto;object-fit:contain;">
              <img src="{{ asset('images/LOGO KKN.png') }}" alt="KKNT-PM UKI TORAJA XLVI" style="height:28px;width:auto;object-fit:contain;">
            </div>
          </div>
        </div>
      </div>

      <!-- Quick links -->
      <div class="col-6 col-lg-2">
        <h6 class="text-uppercase small mb-3">Tautan Cepat</h6>
        <ul class="list-unstyled mb-0 small">
          <li class="mb-2"><a href="{{ route('home') }}">Beranda</a></li>
          <li class="mb-2"><a href="{{ route('profil.tugas') }}">Profil</a></li>
          <li class="mb-2"><a href="{{ route('pju.index') }}">Infografis</a></li>
          <li><a href="{{ route('berita.index') }}">Berita</a></li>
        </ul>
      </div>

      <!-- Contact & hours -->
      <div class="col-6 col-lg-3">
        <h6 class="text-uppercase small mb-3">Kontak & Jam Layanan</h6>
        <ul class="list-unstyled mb-3 small">
          <li class="icon-text mb-2"><i class="bi bi-geo-alt"></i><span>Jl. Poros Tallunglipu - Parinding</span></li>
          <li class="icon-text mb-2"><i class="bi bi-envelope"></i><span>-</span></li>
          <li class="icon-text mb-2"><i class="bi bi-telephone"></i><span>0812-4268-4046</span></li>
        </ul>
        <ul class="list-unstyled small mb-0">
          <li class="mb-1"><i class="bi bi-calendar-week me-1"></i> Senin–Kamis: 08.00–16.00</li>
          <li class="mb-1"><i class="bi bi-calendar-week me-1"></i> Jumat: 08.00–15.00</li>
          <li><i class="bi bi-calendar-x me-1"></i> Sabtu–Minggu: Tutup</li>
        </ul>
      </div>

      <!-- Downloads -->
      <div class="col-lg-3">
        <h6 class="text-uppercase small mb-3">Unduhan</h6>
        <ul class="list-unstyled small mb-0">
          <li class="mb-2"><a href="{{ asset('files/profil-kepala-dinas.pdf') }}" target="_blank" rel="noopener"><i class="bi bi-file-earmark-pdf me-1"></i> Profil Kepala Dinas (PDF)</a></li>
          <li class="mb-2"><a href="{{ asset('files/pju.csv') }}" target="_blank" rel="noopener"><i class="bi bi-filetype-csv me-1"></i> Data PJU (CSV)</a></li>
          <li><a href="{{ asset('files/REKAP PJU NON METERISASI 2020 - TORAJA UTARA 032021.xlsx') }}" target="_blank" rel="noopener"><i class="bi bi-file-earmark-spreadsheet me-1"></i> Rekap PJU 2020 (XLSX)</a></li>
        </ul>
      </div>
    </div>

    <!-- Bottom bar -->
    <div class="border-top border-success-subtle mt-4 py-3 small d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
      <div class="mb-2 mb-md-0">&copy; {{ date('Y') }} Kelurahan Tallunglipu.</div>
    </div>
  </div>
</footer>

<button id="scrollTopBtn" class="scroll-top-btn" aria-label="Kembali ke atas">
  <i class="bi bi-arrow-up"></i>
</button>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Simple in-page rating logic (localStorage only)
  (function(){
    const starWrap = document.getElementById('ratingStars');
    const percentEl = document.getElementById('ratingPercent'); // donut label
    const badgeEl = document.getElementById('ratingBadge');      // header badge
    const barEl = document.getElementById('ratingBar');
    if(starWrap){
      const KEY_SUM = 'site_rating_sum';
      const KEY_CNT = 'site_rating_count';
      const getNum = (k)=>parseInt(localStorage.getItem(k)||'0',10);
      const setNum = (k,v)=>localStorage.setItem(k, String(v));

      function updateUI(){
        const sum = getNum(KEY_SUM);
        const cnt = getNum(KEY_CNT);
        const avg = cnt>0 ? sum/cnt : 0;
        const pct = Math.round((avg/5)*100);
        if(percentEl) percentEl.textContent = pct + '%';
        if(badgeEl) badgeEl.textContent = pct + '%';
        if(barEl) barEl.style.width = pct + '%';
        const donut = document.getElementById('ratingDonut');
        if(donut){
          const CIRC = 339.292; // 2 * PI * r (r=54)
          const offset = CIRC * (1 - pct/100);
          donut.style.strokeDashoffset = String(offset);
        }
      }

      function setStarsActive(n){
        [...starWrap.querySelectorAll('i')].forEach((iEl, idx)=>{
          if(idx < n){ iEl.classList.remove('bi-star'); iEl.classList.add('bi-star-fill'); }
          else{ iEl.classList.remove('bi-star-fill'); iEl.classList.add('bi-star'); }
        });
      }

      starWrap.addEventListener('mouseover', (e)=>{
        const v = parseInt(e.target?.dataset?.value||'0',10);
        if(v>0){ setStarsActive(v); }
      });
      starWrap.addEventListener('mouseleave', ()=>{
        const sum = getNum(KEY_SUM); const cnt = getNum(KEY_CNT);
        const avgRound = cnt>0 ? Math.round(sum/cnt) : 0;
        setStarsActive(avgRound);
      });
      starWrap.addEventListener('click', (e)=>{
        const v = parseInt(e.target?.dataset?.value||'0',10);
        if(v>0){
          const sum = getNum(KEY_SUM)+v; const cnt = getNum(KEY_CNT)+1;
          setNum(KEY_SUM, sum); setNum(KEY_CNT, cnt);
          updateUI(); setStarsActive(Math.round(sum/cnt));
        }
      });

      updateUI();
      const sum = getNum(KEY_SUM); const cnt = getNum(KEY_CNT);
      setStarsActive(cnt>0 ? Math.round(sum/cnt) : 0);
    }
  })();
</script>
<script>
  // Attach ripple class and compute position for clicks
  (function(){
    const selectors = '.btn, .nav-link, .dropdown-item, .navbar-toggler';
    document.querySelectorAll(selectors).forEach(el => {
      el.classList.add('ripple');
      el.addEventListener('click', function(e){
        const rect = this.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        // force reflow to restart animation
        this.style.setProperty('--ripple-x', x + 'px');
        this.style.setProperty('--ripple-y', y + 'px');
        this.classList.remove('do-ripple');
        void this.offsetWidth; // reflow
        this.classList.add('do-ripple');
        // Remove the class after animation ends
        setTimeout(()=>this.classList.remove('do-ripple'), 500);
      });
    });
  })();
</script>
<script>
  // Scroll-to-top button visibility and behavior
  (function(){
    const btn = document.getElementById('scrollTopBtn');
    if(!btn) return;
    const toggle = () => {
      const y = window.scrollY || document.documentElement.scrollTop;
      if (y > 200) btn.classList.add('show'); else btn.classList.remove('show');
    };
    window.addEventListener('scroll', toggle, { passive: true });
    window.addEventListener('load', toggle);
    btn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
  })();
</script>
<script>
  // Preloader hide and smooth page enter
  (function(){
    const onLoaded = () => {
      document.body.classList.add('page-loaded');
      const pre = document.getElementById('preloader');
      if(pre){ pre.classList.add('hide'); setTimeout(()=>pre.remove(), 400); }
    };
    if(document.readyState === 'complete') onLoaded();
    else window.addEventListener('load', onLoaded);
  })();
</script>
</body>
</html>