@extends('layout.app')
@section('title', 'Order Laundry | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Header --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="text-white mb-1"><i class="fa fa-shopping-bag me-2 text-primary"></i>Order Laundry</h4>
                <small style="color:var(--light);">Kelola semua order laundry masuk</small>
            </div>
            @if(Auth::user()->role->nama === 'Admin' || Auth::user()->role->nama === 'Kasir')
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBuatOrder">
                <i class="fa fa-plus me-2"></i>Buat Order Baru
            </button>
            @endif
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-secondary rounded p-3 mb-4">
        <form method="GET" action="{{ route('order.index') }}" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control bg-dark text-white border-0" placeholder="Cari no. order atau pelanggan...">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select bg-dark text-white border-0">
                    <option {{ request('status') == '' ? 'selected' : '' }}>Semua Status</option>
                    @foreach(['Menunggu','Dicuci','Dikeringkan','Disetrika','Siap Diambil','Selesai'] as $st)
                        <option {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search me-1"></i>Cari</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('order.index') }}" class="btn btn-outline-secondary w-100"><i class="fa fa-redo me-1"></i>Reset</a>
            </div>
        </form>
    </div>

    {{-- Tabel Order --}}
    <div class="bg-secondary rounded p-4">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>No. Order</th>
                        <th>Pelanggan</th>
                        <th>No. HP</th>
                        <th>Layanan</th>
                        <th>Berat</th>
                        <th>Total</th>
                        <th>Tgl Masuk</th>
                        <th>Est. Selesai</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $statusBadge = [
                            'Menunggu' => 'warning', 'Dicuci' => 'info', 'Dikeringkan' => 'info',
                            'Disetrika' => 'danger', 'Siap Diambil' => 'primary', 'Selesai' => 'success',
                        ];
                    @endphp
                    @forelse($orders as $o)
                    <tr>
                        <td><span class="fw-bold text-primary">{{ $o->no_order }}</span></td>
                        <td>{{ $o->customer->nama ?? '-' }}</td>
                        <td><small>{{ $o->customer->no_hp ?? '-' }}</small></td>
                        <td>{{ $o->package->nama ?? '-' }}</td>
                        <td>{{ $o->berat }} Kg</td>
                        <td class="fw-bold">Rp{{ number_format($o->total,0,',','.') }}</td>
                        <td><small>{{ $o->tanggal_masuk->format('d/m/Y') }}</small></td>
                        <td><small>{{ $o->estimasi_selesai ? $o->estimasi_selesai->format('d/m/Y') : '-' }}</small></td>
                        <td><span class="badge bg-{{ $statusBadge[$o->status] ?? 'secondary' }} rounded-pill">{{ $o->status }}</span></td>
                        <td>
                            <a href="{{ route('order.edit', $o) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            @if(Auth::user()->role->nama === 'Admin' || Auth::user()->role->nama === 'Kasir')
                            <form action="{{ route('order.destroy', $o) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus order {{ $o->no_order }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4" style="color:var(--light);">Belum ada order.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Modal Buat Order --}}
<div class="modal fade" id="modalBuatOrder" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-secondary">
            <form action="{{ route('order.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white"><i class="fa fa-plus me-2"></i>Buat Order Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" required value="{{ date('Y-m-d') }}"
                                   class="form-control bg-dark text-white border-0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estimasi Selesai</label>
                            <input type="date" name="estimasi_selesai" class="form-control bg-dark text-white border-0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pelanggan</label>
                            <select name="customer_id" id="selectPelanggan" required
                                    class="form-select bg-dark text-white border-0" onchange="isiNoHp()">
                                <option value="">Pilih Pelanggan</option>
                                @foreach($customers as $c)
                                    <option value="{{ $c->id }}" data-hp="{{ $c->no_hp }}">{{ $c->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor HP</label>
                            <input type="text" class="form-control bg-dark text-white border-0" id="inputHP" readonly placeholder="Otomatis dari pelanggan">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Layanan / Paket</label>
                            <select name="package_id" id="selectPaket" required
                                    class="form-select bg-dark text-white border-0" onchange="hitungTotal()">
                                <option value="">Pilih Layanan</option>
                                @foreach($packages as $p)
                                    <option value="{{ $p->id }}" data-harga="{{ $p->harga }}">
                                        {{ $p->nama }} — Rp{{ number_format($p->harga,0,',','.') }}/{{ $p->satuan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Berat (Kg)</label>
                            <input type="number" name="berat" step="0.1" min="0.1" required
                                   class="form-control bg-dark text-white border-0" id="inputBerat" placeholder="0" oninput="hitungTotal()">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Total Harga</label>
                            <input type="text" class="form-control bg-dark text-success border-0 fw-bold" id="inputTotal" placeholder="Rp0" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Awal</label>
                            <select name="status" class="form-select bg-dark text-white border-0">
                                <option>Menunggu</option>
                                <option>Dicuci</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control bg-dark text-white border-0" rows="2" placeholder="Catatan tambahan (opsional)..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Simpan Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function isiNoHp() {
    const select = document.getElementById('selectPelanggan');
    const selected = select.options[select.selectedIndex];
    document.getElementById('inputHP').value = selected.getAttribute('data-hp') || '';
}
function hitungTotal() {
    const select = document.getElementById('selectPaket');
    const selected = select.options[select.selectedIndex];
    const harga = parseFloat(selected.getAttribute('data-harga')) || 0;
    const berat = parseFloat(document.getElementById('inputBerat').value) || 0;
    const total = harga * berat;
    document.getElementById('inputTotal').value = 'Rp' + total.toLocaleString('id-ID');
}
</script>
@endsection
