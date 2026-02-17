@extends('layouts.frontend')
@section('title','Beranda KELURAHAN TALLUNGLIPU')
@section('content')
<section class="hero">
  <div class="hero-ticker" role="marquee" aria-label="Pengumuman berjalan">
    <div class="ticker-inner">
      @php($titles = ($beritas ?? collect())->pluck('title')->filter()->values())
      @if($titles->isEmpty())
        <i class="bi bi-megaphone-fill"></i>
        Selamat datang di Kelurahan Tallunglipu
      @else
        @foreach($titles as $i => $t)
          <i class="bi bi-megaphone-fill"></i>
          {{ $t }}
          @if($i < $titles->count()-1)
            <span class="separator">•</span>
          @endif
        @endforeach
      @endif
    </div>
  </div>
  <div class="container">
    <div class="row align-items-start g-3">
      <div class="col-lg-7">
        <div class="mb-3 d-flex align-items-center">
          <img class="home-hero-logo" src="{{ asset('images/LOGO TORUT.png') }}" alt="TORUT">
          <img class="home-hero-logo" src="{{ asset('images/LOGO KKN.png') }}" alt="KKNUKI46">
        </div>
        <h1 class="fw-bold">Kelurahan Tallunglipu, Kecamatan Tallunglipu, Kabupaten Toraja Utara</h1>
        <p class="lead mb-4">Melayani masyarakat dengan pelayanan prima dan profesional. Kami berkomitmen memberikan layanan terbaik untuk kemajuan daerah.</p>
        <a href="{{ route('berita.index') }}" class="btn btn-light btn-sm">Selengkapnya <i class="bi bi-arrow-right-short ms-1"></i></a>
      </div>
      <div class="col-lg-5">
        <div class="row g-3">
          <div class="col-sm-6">
            <div class="card glass-card h-100">
              <div class="card-body">
                <h6 class="card-title">Kontak</h6>
                <ul class="list-unstyled mb-0 small">
                  <li class="icon-text"><i class="bi bi-geo-alt"></i><span><strong>Alamat</strong>: Jl. Poros Tallunglipu - Parinding</span></li>
                  <li class="icon-text"><i class="bi bi-envelope"></i><span><strong>Email</strong>: -</span></li>
                  <li class="icon-text"><i class="bi bi-telephone"></i><span><strong>Telepon</strong>: 0812-4268-4046</span></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="card glass-card h-100">
              <div class="card-body">
                <h6 class="card-title">Jam Pelayanan</h6>
                <ul class="list-unstyled mb-0 small">
                  <li class="icon-text"><i class="bi bi-calendar-week"></i><span><strong>Senin–Kamis</strong>: 08.00 – 16.00</span></li>
                  <li class="icon-text"><i class="bi bi-calendar-week"></i><span><strong>Jumat</strong>: 08.00 – 15.00</span></li>
                  <li class="icon-text"><i class="bi bi-calendar-x"></i><span><strong>Sabtu–Minggu</strong>: Tutup</span></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-0">
  <div class="container-fluid px-0">
    <div id="homeCarousel" class="carousel slide pro-carousel" data-bs-ride="carousel" data-bs-interval="{{ $carouselInterval ?? 4500 }}">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#homeCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner rounded-3 shadow">
        @php($slides = ($slides ?? collect()))
        @forelse($slides as $i => $slide)
          <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
            <img src="{{ asset('storage/'.$slide->image_path) }}" alt="{{ $slide->title ?? 'Slide '.($i+1) }}">
            @if($slide->title || $slide->caption)
              <div class="carousel-caption text-start">
                @if($slide->title)
                  <h5 class="mb-1">{{ $slide->title }}</h5>
                @endif
                @if($slide->caption)
                  <p class="mb-0 small">{{ $slide->caption }}</p>
                @endif
              </div>
            @endif
          </div>
        @empty
          <div class="carousel-item active">
            <img src="{{ asset('images/BG1.jpg') }}" alt="{{ config('app.name') }}">
          </div>
        @endforelse
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#homeCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Sebelumnya</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#homeCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Berikutnya</span>
      </button>
    </div>
  </div>
</section>

<!-- Section: Berita & Pimpinan -->
<section class="py-5">
  <div class="container">
    <div class="row g-4 align-items-start">
      <div class="col-md-4 d-flex align-items-start">
        <div class="w-100">
          <img src="{{ asset('images/BUPATI TORUT.png') }}" class="img-fluid rounded-3 shadow" alt="Bupati Toraja Utara">
          <h4 class="fw-bold text-dark text-center mt-3 mb-0 premium-title">Bupati &amp; Wakil Bupati Toraja Utara Periode 2025</h4>
        </div>
      </div>

      <div class="col-md-8">
        <div class="bg-white p-4 rounded-3 shadow-sm border">
            @php($latest = ($beritas ?? collect())->sortByDesc('published_at')->take(3))
            <div class="d-flex align-items-center justify-content-between mb-3">
              <div class="d-inline-flex align-items-center gap-2 mb-1">
                <i class="bi bi-newspaper" style="color: var(--brand-600);"></i>
                <h4 class="fw-bold mb-0 premium-section-title">BERITA &amp; INFORMASI TERKINI</h4>
              </div>
              <a href="{{ route('berita.index') }}" class="btn btn-sm btn-outline-success">Lihat Semua</a>
            </div>

            @if($latest->isEmpty())
              <div class="text-muted small mb-4">Belum ada berita.</div>
            @else
              <div class="row g-3">
                @foreach($latest as $b)
                  <div class="col-12">
                    <div class="d-flex gap-3 align-items-center">
                      <img src="{{ $b->thumbnail ? asset('storage/'.$b->thumbnail) : asset('images/BG1.jpg') }}" style="width:100px; height:70px; object-fit:cover; border-radius:8px;">
                      <div>
                        <h6 class="mb-1"><a href="{{ route('berita.show',$b->slug) }}" class="text-decoration-none text-dark fw-bold">{{ $b->title }}</a></h6>
                        <small class="text-muted">{{ $b->published_at? $b->published_at->format('d M Y') : '' }}</small>
                      </div>
                    </div>
                    <hr class="my-2">
                  </div>
                @endforeach
              </div>
            @endif
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-4">
  <div class="container">
    <div class="row g-3 align-items-stretch mb-5">
      <div class="col-lg-8">
        <h4 class="fw-bold text-dark mb-2">Data Penduduk Kelurahan Tallunglipu</h4>
        <div class="card glass-card h-100">
          <div class="card-body py-3">
            <canvas id="residentBar" height="140"></canvas>
            <hr class="my-3">
            <div>
              <h6 class="fw-semibold text-dark mb-2">Statistik Wilayah</h6>
              <div class="text-muted small">Data kependudukan real-time berdasarkan wilayah di Kelurahan Tallunglipu.</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <h6 class="fw-semibold text-dark mb-2">Persentase Penduduk Non-Permanent</h6>
        <div class="card glass-card mb-3">
          <div class="card-body py-3">
            <canvas id="residentPie" height="180" aria-label="Diagram lingkaran penduduk vs non-permanent"></canvas>
          </div>
        </div>
      </div>
    </div>

    <h4 class="fw-bold text-dark text-center my-5">Location</h4>
    <div class="card glass-card">
      <div class="card-body p-2">
        <div class="ratio ratio-16x9">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9946.374313912498!2d119.9009468080855!3d-2.95539504397733!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d93c26d16980c65%3A0xd0d989404134d76b!2sTallunglipu%2C%20Kec.%20Tallunglipu%2C%20Kabupaten%20Toraja%20Utara%2C%20Sulawesi%20Selatan!5e1!3m2!1sid!2sid!4v1770888355589!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function(){
    const labels = {!! json_encode(collect($residentBars)->pluck('label')) !!};
    const values = {!! json_encode(collect($residentBars)->pluck('value')) !!};
    const pie = {!! json_encode($residentPie) !!};

    const palette = ['#198754', '#0f5132', '#20c997', '#ffc107', '#fd7e14'];
    const barColors = labels.map((_, i) => palette[i % palette.length]);

    const ctxBar = document.getElementById('residentBar');
    if (ctxBar) {
      new Chart(ctxBar, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Jumlah',
            data: values,
            backgroundColor: barColors,
            borderColor: barColors,
            borderWidth: 1
          }]
        },
        options: {
          indexAxis: 'y',
          animation: { duration: 900 },
          scales: { x: { beginAtZero: true, ticks: { precision: 0 } } },
          plugins: { legend: { display: false } }
        }
      });
    }

    const ctxPie = document.getElementById('residentPie');
    if (ctxPie) {
      const drawPercent = window.drawPercentPlugin;
      const total = (Number(pie.tallunglipu)||0) + (Number(pie.non_permanent)||0);

      new Chart(ctxPie, {
        type: 'doughnut',
        data: {
          labels: ['Penduduk Tallunglipu', 'Penduduk Non-Permanent'],
          datasets: [{
            data: [Number(pie.tallunglipu)||0, Number(pie.non_permanent)||0],
            backgroundColor: ['#198754', '#ffc107'],
            borderWidth: 0
          }]
        },
        options: {
          cutout: '58%',
          plugins: {
            legend: { position: 'bottom' },
            tooltip: {
              callbacks: {
                label: function(ctx){
                  const val = Number(ctx.parsed) || 0;
                  const pct = total>0 ? (val/total*100).toFixed(1)+'%' : '0%';
                  return `${ctx.label}: ${val} (${pct})`;
                }
              }
            }
          },
          animation: { duration: 800 }
        },
        plugins: [drawPercent]
      });
    }
  });
</script>
@endsection
