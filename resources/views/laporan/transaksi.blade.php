@extends('layout.app')
@section('title', 'Laporan Transaksi | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    {{-- Header --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="text-white mb-1"><i class="fa fa-chart-bar me-2 text-primary"></i>Laporan Transaksi</h4>
                <small style="color:var(--light);">Rekap seluruh transaksi order laundry WashFlow</small>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm"><i class="fa fa-print me-1"></i>Print</button>
            </div>
        </div>
    </div>

    {{-- Statistik --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="bg-secondary rounded p-4 text-center dashboard-card">
                <small style="color:var(--light);">Total Pendapatan</small>
                <h3 class="text-success mt-2 mb-0">Rp{{ number_format($totalPendapatan,0,',','.') }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-secondary rounded p-4 text-center dashboard-card">
                <small style="color:var(--light);">Total Transaksi</small>
                <h3 class="text-primary mt-2 mb-0">{{ $totalTransaksi }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-secondary rounded p-4 text-center dashboard-card">
                <small style="color:var(--light);">Total Order</small>
                <h3 class="text-info mt-2 mb-0">{{ $totalOrder }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-secondary rounded p-4 text-center dashboard-card">
                <small style="color:var(--light);">Rata-rata Transaksi</small>
                <h3 class="text-warning mt-2 mb-0">Rp{{ number_format($rataRata,0,',','.') }}</h3>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <form method="GET" action="{{ route('laporan.transaksi') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Tanggal Awal</label>
                <input type="date" name="dari" value="{{ request('dari') }}" class="form-control bg-dark text-white border-0">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="sampai" value="{{ request('sampai') }}" class="form-control bg-dark text-white border-0">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search me-2"></i>Tampilkan</button>
            </div>
        </form>
    </div>

    {{-- Grafik --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <h5 class="text-white mb-4"><i class="fa fa-chart-line me-2 text-primary"></i>Tren Transaksi 7 Hari</h5>
        <canvas id="laporanChart" height="80"></canvas>
    </div>

    {{-- Tabel --}}
    <div class="bg-secondary rounded p-4">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Transaksi</th>
                        <th>No Order</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $statusBadge = ['Lunas' => 'success', 'DP' => 'warning', 'Belum Bayar' => 'danger'];
                    @endphp
                    @forelse($transaksi as $i => $t)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><span class="text-primary fw-bold">{{ $t->no_transaksi }}</span></td>
                        <td>{{ $t->order->no_order ?? '-' }}</td>
                        <td><small>{{ $t->tanggal->format('d/m/Y') }}</small></td>
                        <td>{{ $t->order->customer->nama ?? '-' }}</td>
                        <td>{{ $t->order->package->nama ?? '-' }}</td>
                        <td class="fw-bold">Rp{{ number_format($t->jumlah_dibayar,0,',','.') }}</td>
                        <td>{{ $t->metode ?? '-' }}</td>
                        <td><span class="badge bg-{{ $statusBadge[$t->status] ?? 'secondary' }} rounded-pill">{{ $t->status }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4" style="color:var(--light);">Belum ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Chart(document.getElementById('laporanChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($grafik->pluck('label')) !!},
            datasets: [{
                label: 'Transaksi',
                data: {!! json_encode($grafik->pluck('jumlah')) !!},
                backgroundColor: 'rgba(13,110,253,.5)',
                borderColor: '#0d6efd',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { labels: { color: '#fff' } } },
            scales: {
                x: { ticks: { color: '#6c7293' }, grid: { color: 'rgba(255,255,255,.05)' } },
                y: { ticks: { color: '#6c7293' }, grid: { color: 'rgba(255,255,255,.05)' } }
            }
        }
    });
});
</script>
@endsection
