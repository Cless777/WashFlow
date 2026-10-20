@extends('layout.app')
@section('title', 'Status Cucian | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Header --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <h4 class="text-white mb-1"><i class="fa fa-spinner me-2 text-primary"></i>Status Cucian</h4>
        <small style="color:var(--light);">Pantau dan ubah status cucian setiap order</small>
    </div>

    {{-- Alur Status --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <h5 class="text-white mb-4"><i class="fa fa-route me-2 text-primary"></i>Alur Status Cucian</h5>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            @php
            $alur = [
                ['status'=>'Menunggu',     'badge'=>'warning',  'icon'=>'fa-clock'],
                ['status'=>'Dicuci',       'badge'=>'info',     'icon'=>'fa-soap'],
                ['status'=>'Dikeringkan',  'badge'=>'primary',  'icon'=>'fa-wind'],
                ['status'=>'Disetrika',    'badge'=>'danger',   'icon'=>'fa-ruler'],
                ['status'=>'Siap Diambil', 'badge'=>'success',  'icon'=>'fa-check-circle'],
                ['status'=>'Selesai',      'badge'=>'secondary','icon'=>'fa-flag'],
            ];
            @endphp
            @foreach($alur as $i => $a)
                <span class="badge bg-{{ $a['badge'] }} px-3 py-2" style="font-size:.9rem;">
                    <i class="fa {{ $a['icon'] }} me-1"></i>{{ $a['status'] }}
                </span>
                @if(!$loop->last)
                    <i class="fa fa-arrow-right text-muted"></i>
                @endif
            @endforeach
        </div>
    </div>

    {{-- Tabel Status --}}
    <div class="bg-secondary rounded p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="text-white mb-0"><i class="fa fa-list me-2 text-primary"></i>Daftar Status Order</h5>
            <form method="GET" action="{{ route('status.index') }}" class="d-flex gap-2">
                <select name="status" class="form-select bg-dark text-white border-0 form-select-sm" onchange="this.form.submit()">
                    <option {{ request('status') == '' ? 'selected' : '' }}>Semua Status</option>
                    @foreach(['Menunggu','Dicuci','Dikeringkan','Disetrika','Siap Diambil','Selesai'] as $st)
                        <option {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>No. Order</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Berat</th>
                        <th>Tgl Masuk</th>
                        <th>Status Saat Ini</th>
                        <th width="200">Ubah Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $statusBadge = [
                            'Menunggu' => 'warning', 'Dicuci' => 'info', 'Dikeringkan' => 'primary',
                            'Disetrika' => 'danger', 'Siap Diambil' => 'success', 'Selesai' => 'secondary',
                        ];
                    @endphp
                    @forelse($items as $item)
                    <tr>
                        <td><span class="fw-bold text-primary">{{ $item->no_order }}</span></td>
                        <td>{{ $item->customer->nama ?? '-' }}</td>
                        <td>{{ $item->package->nama ?? '-' }}</td>
                        <td>{{ $item->berat }} Kg</td>
                        <td><small>{{ $item->tanggal_masuk->format('d/m/Y') }}</small></td>
                        <td><span class="badge bg-{{ $statusBadge[$item->status] ?? 'secondary' }} rounded-pill px-3">{{ $item->status }}</span></td>
                        <td>
                            <form action="{{ route('status.update', $item) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm bg-dark text-white border-0" onchange="this.form.submit()">
                                    @foreach(['Menunggu','Dicuci','Dikeringkan','Disetrika','Siap Diambil','Selesai'] as $st)
                                        <option {{ $item->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                                    @endforeach
                                </select>
                            </form>
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
@endsection