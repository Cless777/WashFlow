@extends('layout.app')

@section('title', 'Dashboard | WashFlow')

@section('content')
<div class="container-fluid pt-4 px-4">

    {{-- ─── WELCOME HEADER ─────────────────────────────────────────────── --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="text-white mb-1">Welcome back, <span class="text-primary">{{ Auth::user()->name }}</span></h3>
                <p class="mb-0 text-light" style="opacity:.7;">Overview laundry hari ini — {{ date('l, d F Y') }}</p>
            </div>
            @if(Auth::user()->role->nama === 'Admin')
            <a href="{{ route('order.index') }}" class="btn btn-primary px-4">
                <i class="fa fa-plus me-2"></i>Buat Order Baru
            </a>
            @endif
        </div>
    </div>

    {{-- ─── STAT CARDS ─────────────────────────────────────────────────── --}}
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="bg-secondary rounded p-4 dashboard-card h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1" style="color:var(--light);font-size:.85rem;">Order Hari Ini</p>
                        <h2 class="text-white mb-1">{{ $orderHariIni }}</h2>
                        <small class="{{ $selisihOrder >= 0 ? 'text-success' : 'text-danger' }}">
                            <i class="fa fa-arrow-{{ $selisihOrder >= 0 ? 'up' : 'down' }} me-1"></i>
                            {{ $selisihOrder >= 0 ? '+' : '' }}{{ $selisihOrder }} dari kemarin
                        </small>
                    </div>
                    <div style="width:56px;height:56px;background:rgba(13,110,253,.15);border-radius:16px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa fa-shopping-bag fa-lg text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="bg-secondary rounded p-4 dashboard-card h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1" style="color:var(--light);font-size:.85rem;">Sedang Diproses</p>
                        <h2 class="text-white mb-1">{{ $sedangDiproses }}</h2>
                        <small style="color:var(--light);">Dalam antrian cucian</small>
                    </div>
                    <div style="width:56px;height:56px;background:rgba(255,193,7,.15);border-radius:16px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa fa-spinner fa-lg text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="bg-secondary rounded p-4 dashboard-card h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1" style="color:var(--light);font-size:.85rem;">Siap Diambil</p>
                        <h2 class="text-white mb-1">{{ $siapDiambil }}</h2>
                        <small style="color:#4fc3f7;">Menunggu pickup pelanggan</small>
                    </div>
                    <div style="width:56px;height:56px;background:rgba(13,202,240,.15);border-radius:16px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa fa-check-circle fa-lg text-info"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="bg-secondary rounded p-4 dashboard-card h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1" style="color:var(--light);font-size:.85rem;">Pendapatan Hari Ini</p>
                        <h2 class="text-success mb-1" style="font-size:1.5rem;">Rp{{ number_format($pendapatanHariIni,0,',','.') }}</h2>
                        <small class="{{ $persenPendapatan >= 0 ? 'text-success' : 'text-danger' }}">
                            <i class="fa fa-arrow-{{ $persenPendapatan >= 0 ? 'up' : 'down' }} me-1"></i>
                            {{ $persenPendapatan >= 0 ? '+' : '' }}{{ $persenPendapatan }}% dari kemarin
                        </small>
                    </div>
                    <div style="width:56px;height:56px;background:rgba(25,135,84,.15);border-radius:16px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa fa-money-bill-wave fa-lg text-success"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ─── GRAFIK + RINGKASAN ──────────────────────────────────────────── --}}
    <div class="row g-4 mb-4">

        {{-- Grafik --}}
        <div class="col-lg-8">
            <div class="bg-secondary rounded p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="text-white mb-0">
                        <i class="fa fa-chart-line me-2 text-primary"></i>Pendapatan 7 Hari Terakhir
                    </h5>
                    <span class="badge" style="background:rgba(13,110,253,.2);color:#6ea8fe;border-radius:50px;padding:6px 14px;">
                        Minggu ini
                    </span>
                </div>
                <canvas id="revenueChart" height="120"></canvas>
            </div>
        </div>

        {{-- Status Ringkasan --}}
        <div class="col-lg-4">
            <div class="bg-secondary rounded p-4 h-100">
                <h5 class="text-white mb-4">
                    <i class="fa fa-tasks me-2 text-primary"></i>Status Cucian
                </h5>
                @foreach($statuses as $s)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span style="width:32px;height:32px;background:rgba(var(--bs-{{ $s['color'] }}-rgb),.15);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa {{ $s['icon'] }} text-{{ $s['color'] }}" style="font-size:.8rem;"></i>
                        </span>
                        <small style="color:var(--light);">{{ $s['label'] }}</small>
                    </div>
                    <span class="badge bg-{{ $s['color'] }} rounded-pill">{{ $s['count'] }}</span>
                </div>
                @endforeach

                <hr style="border-color:rgba(255,255,255,.1);">
                <div class="text-center">
                    <a href="{{ route('status.index') }}" class="btn btn-outline-primary btn-sm w-100">
                        <i class="fa fa-eye me-2"></i>Lihat Semua Status
                    </a>
                </div>
            </div>
        </div>

    </div>

    {{-- ─── ORDER TERBARU ───────────────────────────────────────────────── --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="text-white mb-0">
                <i class="fa fa-list-alt me-2 text-primary"></i>Order Terbaru
            </h5>
            <a href="{{ route('order.index') }}" class="btn btn-primary btn-sm px-3">
                Lihat Semua <i class="fa fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>No. Order</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Berat</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $statusBadge = [
                            'Menunggu' => 'warning', 'Dicuci' => 'info', 'Dikeringkan' => 'primary',
                            'Disetrika' => 'danger', 'Siap Diambil' => 'success', 'Selesai' => 'secondary',
                        ];
                    @endphp
                    @forelse($orders as $o)
                    <tr>
                        <td><span class="fw-bold text-primary">{{ $o->no_order }}</span></td>
                        <td>{{ $o->customer->nama ?? '-' }}</td>
                        <td>{{ $o->package->nama ?? '-' }}</td>
                        <td>{{ $o->berat }} Kg</td>
                        <td class="fw-bold">Rp{{ number_format($o->total,0,',','.') }}</td>
                        <td><span class="badge bg-{{ $statusBadge[$o->status] ?? 'secondary' }} rounded-pill">{{ $o->status }}</span></td>
                        <td>
                            <a href="{{ route('order.index') }}" class="btn btn-sm btn-outline-primary" title="Detail">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4" style="color:var(--light);">Belum ada order.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Chart Script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($grafik->pluck('label')) !!},
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: {!! json_encode($grafik->pluck('total')) !!},
                borderColor: '#2E7D32',
                backgroundColor: 'rgba(46,125,50,.15)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#2E7D32',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { labels: { color: '#fff' } },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp' + ctx.raw.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                x: { ticks: { color: '#6c7293' }, grid: { color: 'rgba(255,255,255,.05)' } },
                y: {
                    ticks: {
                        color: '#6c7293',
                        callback: val => 'Rp' + (val/1000) + 'rb'
                    },
                    grid: { color: 'rgba(255,255,255,.05)' }
                }
            }
        }
    });
});
</script>
@endsection
