@extends('layout.app')
@section('title', 'Pembayaran | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Header --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="text-white mb-1"><i class="fa fa-money-bill-wave me-2 text-primary"></i>Pembayaran</h4>
                <small style="color:var(--light);">Kelola semua transaksi pembayaran laundry</small>
            </div>
            @if(Auth::user()->role->nama === 'Admin' || Auth::user()->role->nama === 'Kasir')
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBayar">
                <i class="fa fa-plus me-2"></i>Catat Pembayaran
            </button>
            @endif
        </div>
    </div>

    {{-- Stat Pembayaran --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="bg-secondary rounded p-4 dashboard-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p style="color:var(--light);font-size:.85rem;" class="mb-1">Total Lunas</p>
                        <h4 class="text-success mb-0">Rp{{ number_format($totalLunas,0,',','.') }}</h4>
                    </div>
                    <i class="fa fa-check-circle fa-2x text-success" style="opacity:.5;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-secondary rounded p-4 dashboard-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p style="color:var(--light);font-size:.85rem;" class="mb-1">DP / Cicilan</p>
                        <h4 class="text-warning mb-0">Rp{{ number_format($totalDp,0,',','.') }}</h4>
                    </div>
                    <i class="fa fa-hourglass-half fa-2x text-warning" style="opacity:.5;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-secondary rounded p-4 dashboard-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p style="color:var(--light);font-size:.85rem;" class="mb-1">Belum Bayar</p>
                        <h4 class="text-danger mb-0">Rp{{ number_format($totalBelumBayar,0,',','.') }}</h4>
                    </div>
                    <i class="fa fa-times-circle fa-2x text-danger" style="opacity:.5;"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-secondary rounded p-3 mb-4">
        <form method="GET" action="{{ route('pembayaran.index') }}" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control bg-dark text-white border-0" placeholder="Cari no. transaksi atau pelanggan...">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select bg-dark text-white border-0">
                    <option {{ request('status') == '' ? 'selected' : '' }}>Semua Status</option>
                    <option {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                    <option {{ request('status') == 'DP' ? 'selected' : '' }}>DP</option>
                    <option {{ request('status') == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="metode" class="form-select bg-dark text-white border-0">
                    <option {{ request('metode') == '' ? 'selected' : '' }}>Semua Metode</option>
                    <option {{ request('metode') == 'Cash' ? 'selected' : '' }}>Cash</option>
                    <option {{ request('metode') == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                    <option {{ request('metode') == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search me-1"></i>Filter</button>
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-secondary rounded p-4">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>No. Transaksi</th>
                        <th>No. Order</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Dibayar</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        @if(Auth::user()->role->nama === 'Admin' || Auth::user()->role->nama === 'Kasir')
                        <th width="100">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php
                        $statusBadge = ['Lunas' => 'success', 'DP' => 'warning', 'Belum Bayar' => 'danger'];
                    @endphp
                    @forelse($payments as $p)
                    <tr>
                        <td><span class="fw-bold text-primary">{{ $p->no_transaksi }}</span></td>
                        <td>{{ $p->order->no_order ?? '-' }}</td>
                        <td>{{ $p->order->customer->nama ?? '-' }}</td>
                        <td class="fw-bold">Rp{{ number_format($p->order->total ?? 0,0,',','.') }}</td>
                        <td>Rp{{ number_format($p->jumlah_dibayar,0,',','.') }}</td>
                        <td>
                            @if($p->metode === 'Cash')
                                <span class="badge" style="background:rgba(25,135,84,.2);color:#75b798;"><i class="fa fa-money-bill me-1"></i>Cash</span>
                            @elseif($p->metode === 'Transfer')
                                <span class="badge" style="background:rgba(13,110,253,.2);color:#6ea8fe;"><i class="fa fa-university me-1"></i>Transfer</span>
                            @elseif($p->metode === 'QRIS')
                                <span class="badge" style="background:rgba(111,66,193,.2);color:#b893e8;"><i class="fa fa-qrcode me-1"></i>QRIS</span>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </td>
                        <td><span class="badge bg-{{ $statusBadge[$p->status] ?? 'secondary' }} rounded-pill">{{ $p->status }}</span></td>
                        <td><small>{{ $p->tanggal->format('d/m/Y') }}</small></td>
                        @if(Auth::user()->role->nama === 'Admin' || Auth::user()->role->nama === 'Kasir')
                        <td>
                            <a href="{{ route('pembayaran.edit', $p) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4" style="color:var(--light);">Belum ada transaksi pembayaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Modal Catat Pembayaran --}}
<div class="modal fade" id="modalBayar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <form action="{{ route('pembayaran.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white">Catat Pembayaran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">No. Order</label>
                        <select name="order_id" required class="form-select bg-dark text-white border-0">
                            <option value="">Pilih Order</option>
                            @forelse($ordersBelumBayar as $o)
                                <option value="{{ $o->id }}">
                                    {{ $o->no_order }} — {{ $o->customer->nama ?? '-' }} — Rp{{ number_format($o->total,0,',','.') }}
                                </option>
                            @empty
                                <option value="" disabled>Semua order sudah dicatat pembayarannya</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Dibayar</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-white border-0">Rp</span>
                            <input type="number" name="jumlah_dibayar" required min="0" class="form-control bg-dark text-white border-0" placeholder="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode" value="Cash" id="cash" checked>
                                <label class="form-check-label" for="cash"><i class="fa fa-money-bill me-1"></i>Cash</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode" value="Transfer" id="transfer">
                                <label class="form-check-label" for="transfer"><i class="fa fa-university me-1"></i>Transfer</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metode" value="QRIS" id="qris">
                                <label class="form-check-label" for="qris"><i class="fa fa-qrcode me-1"></i>QRIS</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select bg-dark text-white border-0">
                            <option>Lunas</option>
                            <option>DP</option>
                            <option>Belum Bayar</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
