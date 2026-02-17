@extends('layouts.admin')

@section('title','Dashboard Analisis')

@section('content')
<div class="container-fluid">
  <!-- Page header (Volt-like) -->
  <div class="d-flex align-items-center justify-content-between mb-3">
    <div>
      <h4 class="mb-0">Dashboard</h4>
      <div class="text-muted small">Ringkasan metrik dan aktivitas penduduk</div>
    </div>
    <div>
      <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-volt"><i class="bi bi-plus-lg me-1"></i>Tambah Berita</a>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <div class="text-muted small">Berita</div>
            <div class="fs-3 fw-bold">{{ $stats['berita'] }}</div>
          </div>
          <span class="icon-shape icon-shape-success"><i class="bi bi-newspaper fs-5"></i></span>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <div class="text-muted small">Total Penduduk</div>
            <div class="fs-3 fw-bold">{{ $stats['penduduk'] }}</div>
          </div>
          <span class="icon-shape icon-shape-primary"><i class="bi bi-people fs-5"></i></span>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3 mt-1">
    <div class="col-lg-7">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-semibold d-flex align-items-center justify-content-between">
          <span>Data Penduduk (Bar Horizontal)</span>
          <a href="{{ route('admin.infografis.index') }}" class="btn btn-sm btn-volt">
            <i class="bi bi-pencil-square me-1"></i>Kelola Data
          </a>
        </div>
        <div class="card-body py-3">
          <canvas id="adminResidentBar" height="140"></canvas>
          @php
            $labels = collect($residentBars)->pluck('label');
            $values = collect($residentBars)->pluck('value');
          @endphp

          <script>
            document.addEventListener('DOMContentLoaded', function(){
              const labels = {!! json_encode($labels) !!};
              const values = {!! json_encode($values) !!};
              const ctx = document.getElementById('adminResidentBar');
              const palette = ['#198754','#0f5132','#20c997','#ffc107','#fd7e14','#6f42c1','#0dcaf0','#6610f2'];
              const colors = labels.map((_,i)=>palette[i%palette.length]);
              if (!ctx) return;
              new Chart(ctx, {
                type: 'bar',
                data: {
                  labels: labels,
                  datasets: [{
                    label: 'Jumlah',
                    data: values,
                    backgroundColor: colors,
                    borderColor: colors,
                    borderWidth: 1,
                  }]
                },
                options: {
                  indexAxis: 'y',
                  animation: { duration: 800 },
                  scales: { x: { beginAtZero: true, ticks: { precision: 0 } } },
                  plugins: { legend: { display:false } }
                }
              });
            });
          </script>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-white fw-semibold d-flex align-items-center justify-content-between">
          <span>Presentase Penduduk - Penduduk Non-Permanent</span>
          <a href="{{ route('admin.infografis.index') }}" class="btn btn-sm btn-volt">
            <i class="bi bi-gear me-1"></i>Kelola Data
          </a>
        </div>
        <div class="card-body py-3">
          <canvas id="adminResidentPie" height="160"></canvas>
          <script>
            document.addEventListener('DOMContentLoaded', function(){
              const pie = {!! json_encode($residentPie) !!};
              const ctx = document.getElementById('adminResidentPie');
              if (!ctx) return;
              const total = (Number(pie.tallunglipu)||0) + (Number(pie.non_permanent)||0);
              const toPercent = (v) => total > 0 ? (v/total*100) : 0;

              // Use shared plugin defined in layouts.chart-plugins
              const drawPercent = window.drawPercentPlugin;

              new Chart(ctx, {
                type: 'doughnut',
                data: {
                  labels: ['Penduduk Tallunglipu', 'Penduduk Non-Permanent'],
                  datasets: [{ 
                    data: [Number(pie.tallunglipu)||0, Number(pie.non_permanent)||0], 
                    backgroundColor: ['#198754','#ffc107'], 
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
                          const pct = toPercent(val).toFixed(1)+'%';
                          return `${ctx.label}: ${val} (${pct})`;
                        }
                      }
                    }
                  },
                  animation: { duration: 700 }
                },
                plugins: [drawPercent]
              });
            });
          </script>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
