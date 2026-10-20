@extends('layout.app')
@section('title', 'Kasir | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Header --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <h4 class="text-white mb-1"><i class="fa fa-cash-register me-2 text-primary"></i>Kasir</h4>
        <small style="color:var(--light);">Selamat bertugas, {{ auth()->user()->name ?? 'Kasir' }}</small>
    </div>

    {{-- Ringkasan Cepat --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="bg-secondary rounded p-4 text-center">
                <i class="fa fa-receipt fa-2x text-primary mb-2"></i>
                <h3 class="text-white mb-0">{{ $orders->count() }}</h3>
                <small style="color:var(--light);">Transaksi Hari Ini</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-secondary rounded p-4 text-center">
                <i class="fa fa-money-bill-wave fa-2x text-success mb-2"></i>
                <h3 class="text-white mb-0">Rp{{ number_format($orders->sum('total'), 0, ',', '.') }}</h3>
                <small style="color:var(--light);">Pendapatan Hari Ini</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-secondary rounded p-4 text-center">
                <i class="fa fa-hourglass-half fa-2x text-warning mb-2"></i>
                <h3 class="text-white mb-0">{{ $orders->where('status', 'Menunggu')->count() }}</h3>
                <small style="color:var(--light);">Order Menunggu</small>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Form Transaksi --}}
        <div class="col-lg-5">
            <div class="bg-secondary rounded p-4">
                <h6 class="text-white mb-3">Transaksi Baru</h6>
                <form action="{{ route('kasir.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label d-flex justify-content-between align-items-center">
                            Pelanggan
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalPelangganBaru">
                                <i class="fa fa-plus"></i> Baru
                            </button>
                        </label>
                        <select name="customer_id" id="selectPelanggan" required
                                class="form-select bg-dark text-white border-0" onchange="isiNoHp()">
                            <option value="">Pilih Pelanggan</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}" data-hp="{{ $c->no_hp }}">{{ $c->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" class="form-control bg-dark text-white border-0" id="inputHP" readonly placeholder="Otomatis dari pelanggan">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Layanan / Paket</label>
                        <select name="package_id" id="selectPaket" required
                                class="form-select bg-dark text-white border-0" onchange="hitungTotal(); updateLabelSatuan();">
                            <option value="">Pilih Layanan</option>
                            @foreach($packages as $p)
                                <option value="{{ $p->id }}" data-harga="{{ $p->harga }}" data-satuan="{{ $p->satuan }}">
                                    {{ $p->nama }} — Rp{{ number_format($p->harga,0,',','.') }}/{{ $p->satuan }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label" id="labelJumlah">Berat (Kg)</label>
                            <input type="number" name="berat" step="0.1" min="0.1" required
                                class="form-control bg-dark text-white border-0" id="inputBerat" placeholder="0" oninput="hitungTotal()">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Total Harga</label>
                            <input type="text" class="form-control bg-dark text-success border-0 fw-bold" id="inputTotal" placeholder="Rp0" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Estimasi Selesai</label>
                        <input type="date" name="estimasi_selesai" class="form-control bg-dark text-white border-0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control bg-dark text-white border-0" rows="2" placeholder="Opsional..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100"><i class="fa fa-save me-2"></i>Simpan Transaksi</button>
                </form>
            </div>
        </div>

        {{-- Transaksi Hari Ini --}}
        <div class="col-lg-7">
            <div class="bg-secondary rounded p-4">
                <h6 class="text-white mb-3">Transaksi Hari Ini</h6>
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
                                <td class="fw-bold text-primary">{{ $o->no_order }}</td>
                                <td>{{ $o->customer->nama ?? '-' }}</td>
                                <td>{{ $o->package->nama ?? '-' }}</td>
                                <td>{{ $o->berat }} {{ $o->package->satuan ?? 'Kg' }}</td>
                                <td class="fw-bold">Rp{{ number_format($o->total,0,',','.') }}</td>
                                <td><span class="badge bg-{{ $statusBadge[$o->status] ?? 'secondary' }} rounded-pill">{{ $o->status }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4" style="color:var(--light);">Belum ada transaksi hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Pelanggan --}}
    <div class="modal fade" id="modalPelangganBaru" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-secondary">
                <form action="{{ route('kasir.customer.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0">
                        <h5 class="modal-title text-white">Tambah Pelanggan Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" required class="form-control bg-dark text-white border-0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. HP</label>
                            <input type="text" name="no_hp" required class="form-control bg-dark text-white border-0">
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
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
function updateLabelSatuan() {
    const select = document.getElementById('selectPaket');
    const selected = select.options[select.selectedIndex];
    const satuan = selected.getAttribute('data-satuan') || 'kg';
    const label = document.getElementById('labelJumlah');
    const input = document.getElementById('inputBerat');

    if (satuan === 'kg') {
        label.textContent = 'Berat (Kg)';
        input.step = '0.1';
        input.min = '0.1';
    } else {
        label.textContent = 'Jumlah (' + satuan + ')';
        input.step = '1';
        input.min = '1';
        // Bulatkan nilai yang udah keisi, kalau ada desimal
        if (input.value) {
            input.value = Math.round(parseFloat(input.value));
        }
    }
}
</script>
@endsection