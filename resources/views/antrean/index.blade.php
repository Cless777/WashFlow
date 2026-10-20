@extends('layout.app')
@section('title', 'Antrean | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    {{-- Header --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <h4 class="text-white mb-1"><i class="fa fa-list-ol me-2 text-primary"></i>Antrean Laundry</h4>
        <small style="color:var(--light);">Antrian laundry yang sedang diproses hari ini</small>
    </div>

    {{-- Nomor Antrean Sekarang --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="bg-secondary rounded p-4 text-center dashboard-card">
                <small style="color:var(--light);">Sedang Dilayani</small>
                <div class="my-3" style="font-size:5rem;font-weight:900;color:var(--primary);line-height:1;">
                    {{ $noSedangDilayani ? str_pad($noSedangDilayani, 3, '0', STR_PAD_LEFT) : '-' }}
                </div>
                <span class="badge bg-success px-3 py-2">{{ $noSedangDilayani ? 'Sedang Diproses' : 'Tidak Ada' }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-secondary rounded p-4 text-center dashboard-card">
                <small style="color:var(--light);">Antrean Berikutnya</small>
                <div class="my-3" style="font-size:5rem;font-weight:900;color:#ffc107;line-height:1;">
                    {{ $noAntreanBerikutnya ? str_pad($noAntreanBerikutnya, 3, '0', STR_PAD_LEFT) : '-' }}
                </div>
                <span class="badge bg-warning px-3 py-2">{{ $noAntreanBerikutnya ? 'Menunggu' : 'Tidak Ada' }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-secondary rounded p-4 text-center dashboard-card">
                <small style="color:var(--light);">Total Antrean Hari Ini</small>
                <div class="my-3" style="font-size:5rem;font-weight:900;color:#0dcaf0;line-height:1;">{{ $totalHariIni }}</div>
                <span class="badge bg-info px-3 py-2">Order Masuk</span>
            </div>
        </div>
    </div>

    {{-- Tabel Antrean --}}
    <div class="bg-secondary rounded p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="text-white mb-0"><i class="fa fa-clock me-2 text-primary"></i>Daftar Antrean</h5>
            <span class="badge bg-primary px-3 py-2">{{ date('d F Y') }}</span>
        </div>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>No. Antrean</th>
                        <th>No. Order</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Berat</th>
                        <th>Waktu Masuk</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Kelompokkan 6 status Order jadi 3 kategori tampilan
                        $kategori = [
                            'Menunggu'     => ['label' => 'Menunggu', 'badge' => 'warning', 'warna' => '#ffc107'],
                            'Dicuci'       => ['label' => 'Diproses', 'badge' => 'info',    'warna' => 'var(--primary)'],
                            'Dikeringkan'  => ['label' => 'Diproses', 'badge' => 'info',    'warna' => 'var(--primary)'],
                            'Disetrika'    => ['label' => 'Diproses', 'badge' => 'info',    'warna' => 'var(--primary)'],
                            'Siap Diambil' => ['label' => 'Diproses', 'badge' => 'info',    'warna' => 'var(--primary)'],
                            'Selesai'      => ['label' => 'Selesai',  'badge' => 'success', 'warna' => 'var(--light)'],
                        ];
                    @endphp
                    @forelse($orders as $i => $o)
                    @php $k = $kategori[$o->status] ?? $kategori['Menunggu']; @endphp
                    <tr>
                        <td>
                            <span style="font-size:1.4rem;font-weight:900;color:{{ $k['warna'] }};">
                                {{ str_pad($i + 1, 3, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td><span class="text-primary fw-bold">{{ $o->no_order }}</span></td>
                        <td>{{ $o->customer->nama ?? '-' }}</td>
                        <td>{{ $o->package->nama ?? '-' }}</td>
                        <td>{{ $o->berat }} Kg</td>
                        <td><i class="fa fa-clock me-1 text-warning"></i>{{ $o->created_at->format('H:i') }}</td>
                        <td><span class="badge bg-{{ $k['badge'] }} rounded-pill">{{ $k['label'] }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4" style="color:var(--light);">Belum ada order masuk hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection