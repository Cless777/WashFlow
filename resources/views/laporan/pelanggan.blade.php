@extends('layout.app')
@section('title', 'Laporan Pelanggan | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    {{-- Header --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="text-white mb-1"><i class="fa fa-users me-2 text-primary"></i>Laporan Pelanggan</h4>
                <small style="color:var(--light);">Analisis pelanggan dan kebiasaan order</small>
            </div>
        </div>
    </div>

    {{-- Stat --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="bg-secondary rounded p-4 text-center dashboard-card">
                <small style="color:var(--light);">Total Pelanggan</small>
                <h2 class="text-primary mt-2 mb-0">{{ $totalPelanggan }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-secondary rounded p-4 text-center dashboard-card">
                <small style="color:var(--light);">Pelanggan Aktif</small>
                <h2 class="text-success mt-2 mb-0">{{ $pelangganAktif }}</h2>
                <small style="color:var(--light);">
                    {{ $totalPelanggan > 0 ? round(($pelangganAktif / $totalPelanggan) * 100) : 0 }}% dari total
                </small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-secondary rounded p-4 text-center dashboard-card">
                <small style="color:var(--light);">Pelanggan Baru</small>
                <h2 class="text-info mt-2 mb-0">{{ $pelangganBaru }}</h2>
                <small style="color:var(--light);">Bulan {{ now()->translatedFormat('F') }}</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-secondary rounded p-4 text-center dashboard-card">
                <small style="color:var(--light);">Rata-rata Order/Pelanggan</small>
                <h2 class="text-warning mt-2 mb-0">{{ $rataOrder }}x</h2>
            </div>
        </div>
    </div>

    {{-- Top Pelanggan --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <h5 class="text-white mb-4"><i class="fa fa-trophy me-2 text-warning"></i>Top 5 Pelanggan Terbanyak Order</h5>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pelanggan</th>
                        <th>No. HP</th>
                        <th>Total Order</th>
                        <th>Total Pengeluaran</th>
                        <th>Layanan Favorit</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topPelanggan as $i => $t)
                    <tr>
                        <td>
                            @if($i < 3)
                                <span style="font-size:1.4rem;">{{ ['🥇','🥈','🥉'][$i] }}</span>
                            @else
                                <span class="fw-bold" style="color:var(--light);">#{{ $i + 1 }}</span>
                            @endif
                        </td>
                        <td>{{ $t['nama'] }}</td>
                        <td>{{ $t['hp'] }}</td>
                        <td><span class="badge rounded-pill" style="background:rgba(13,110,253,.2);color:#6ea8fe;">{{ $t['order'] }} order</span></td>
                        <td class="fw-bold text-success">Rp{{ number_format($t['total'],0,',','.') }}</td>
                        <td>{{ $t['fav'] ?? '-' }}</td>
                        <td><span class="badge bg-{{ $t['status'] === 'Aktif' ? 'success' : 'secondary' }} rounded-pill">{{ $t['status'] }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4" style="color:var(--light);">Belum ada data order.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
