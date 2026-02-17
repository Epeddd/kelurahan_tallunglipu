@extends('layouts.frontend')

@section('title', 'Infografis Kelurahan Tallunglipu')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold premium-title">Infografis Kelurahan Tallunglipu</h2>
        <p class="text-muted">Data Statistik Kependudukan Real-time</p>
        <div class="d-flex justify-content-center">
            <hr style="width: 50px; border-top: 3px solid var(--brand-600); opacity: 1;">
        </div>
    </div>

    <div class="row g-4">
        <!-- Bar Chart -->
        <div class="col-lg-8">
            <div class="card glass-card h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Distribusi Penduduk per Wilayah</h5>
                    <div style="height: 350px;">
                        <canvas id="residentBar"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-lg-4">
            <div class="card glass-card h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Status Kependudukan</h5>
                    <div style="height: 300px;">
                        <canvas id="residentPie"></canvas>
                    </div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="bi bi-circle-fill text-success me-2"></i> Penduduk Tetap</span>
                            <span class="fw-bold">{{ $residentPie['tallunglipu'] }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="bi bi-circle-fill text-warning me-2"></i> Non-Permanent</span>
                            <span class="fw-bold">{{ $residentPie['non_permanent'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            label: 'Jumlah Penduduk',
            data: values,
            backgroundColor: barColors,
            borderColor: barColors,
            borderWidth: 1
          }]
        },
        options: {
          indexAxis: 'y',
          maintainAspectRatio: false,
          animation: { duration: 900 },
          scales: { 
            x: { 
                beginAtZero: true, 
                ticks: { precision: 0 },
                grid: { display: false }
            },
            y: {
                grid: { display: false }
            }
          },
          plugins: { 
            legend: { display: false },
            tooltip: {
                padding: 10,
                backgroundColor: 'rgba(0,0,0,0.8)'
            }
          }
        }
      });
    }

    const ctxPie = document.getElementById('residentPie');
    if (ctxPie) {
      const total = (Number(pie.tallunglipu)||0) + (Number(pie.non_permanent)||0);

      new Chart(ctxPie, {
        type: 'doughnut',
        data: {
          labels: ['Penduduk Tetap', 'Non-Permanent'],
          datasets: [{
            data: [Number(pie.tallunglipu)||0, Number(pie.non_permanent)||0],
            backgroundColor: ['#198754', '#ffc107'],
            borderWidth: 0,
            hoverOffset: 10
          }]
        },
        options: {
          maintainAspectRatio: false,
          cutout: '70%',
          plugins: {
            legend: { display: false },
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
        }
      });
    }
  });
</script>
@endsection
