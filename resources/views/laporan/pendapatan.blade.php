@extends('layout.app')
@section('title', 'Laporan Pendapatan | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    {{-- Header --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="text-white mb-1"><i class="fa fa-chart-line me-2 text-primary"></i>Laporan Pendapatan</h4>
                <small style="color:var(--light);">Rekap pendapatan laundry per periode</small>
            </div>
        </div>
    </div>

    {{-- Stat --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="bg-secondary rounded p-4 text-center dashboard-card">
                <small style="color:var(--light);">Total Pendapatan Bulan Ini</small>
                <h2 class="text-success mt-2 mb-0">Rp{{ number_format($bulanIni,0,',','.') }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-secondary rounded p-4 text-center dashboard-card">
                <small style="color:var(--light);">Pendapatan Hari Ini</small>
                <h2 class="text-primary mt-2 mb-0">Rp{{ number_format($hariIni,0,',','.') }}</h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-secondary rounded p-4 text-center dashboard-card">
                <small style="color:var(--light);">Rata-rata per Hari</small>
                <h2 class="text-warning mt-2 mb-0">Rp{{ number_format($rataPerHari,0,',','.') }}</h2>
                <small style="color:var(--light);">Bulan berjalan</small>
            </div>
        </div>
    </div>

    {{-- Grafik Pendapatan --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <h5 class="text-white mb-4"><i class="fa fa-chart-area me-2 text-primary"></i>Grafik Pendapatan Bulanan</h5>
        <canvas id="pendapatanChart" height="80"></canvas>
    </div>

    {{-- Pendapatan per Layanan & Metode --}}
    <div class="row g-4">
        <div class="col-md-6">
            <div class="bg-secondary rounded p-4">
                <h5 class="text-white mb-4"><i class="fa fa-tags me-2 text-primary"></i>Pendapatan per Layanan (Bulan Ini)</h5>
                @forelse($perLayanan as $l)
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <small style="color:var(--light);">{{ $l['nama'] }}</small>
                        <small class="text-white">Rp{{ number_format($l['pendapatan'],0,',','.') }} ({{ $l['pct'] }}%)</small>
                    </div>
                    <div class="progress" style="height:8px;background:rgba(255,255,255,.1);">
                        <div class="progress-bar bg-primary" style="width:{{ $l['pct'] }}%;"></div>
                    </div>
                </div>
                @empty
                <p style="color:var(--light);">Belum ada data pendapatan bulan ini.</p>
                @endforelse
            </div>
        </div>
        <div class="col-md-6">
            <div class="bg-secondary rounded p-4">
                <h5 class="text-white mb-4"><i class="fa fa-credit-card me-2 text-primary"></i>Pendapatan per Metode (Bulan Ini)</h5>
                @forelse($perMetode as $m)
                <div class="d-flex justify-content-between align-items-center bg-dark rounded p-3 mb-3">
                    <div>
                        <div class="fw-bold text-white">{{ $m['nama'] }}</div>
                        <small style="color:var(--light);">{{ $m['jml'] }} transaksi ({{ $m['pct'] }}%)</small>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-success">Rp{{ number_format($m['pendapatan'],0,',','.') }}</div>
                    </div>
                </div>
                @empty
                <p style="color:var(--light);">Belum ada data pendapatan bulan ini.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Chart(document.getElementById('pendapatanChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: {!! json_encode($grafikBulanan->pluck('label')) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($grafikBulanan->pluck('total')) !!},
                borderColor: '#198754',
                backgroundColor: 'rgba(25,135,84,.15)',
                fill: true, tension: 0.4,
                pointBackgroundColor: '#198754', pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 5,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { labels: { color: '#fff' } },
                tooltip: { callbacks: { label: ctx => 'Rp'+ctx.raw.toLocaleString('id-ID') } }
            },
            scales: {
                x: { ticks:{ color:'#6c7293' }, grid:{ color:'rgba(255,255,255,.05)' } },
                y: { ticks:{ color:'#6c7293' }, grid:{ color:'rgba(255,255,255,.05)' } }
            }
        }
    });
});
</script>
@endsection
