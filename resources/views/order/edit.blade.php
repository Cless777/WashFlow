@extends('layout.app')
@section('title', 'Edit Order Laundry | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    <div class="bg-secondary rounded p-4 mb-4">
        <h4 class="text-white mb-1"><i class="fa fa-edit me-2 text-primary"></i>Edit Order</h4>
        <small style="color:var(--light);">{{ $order->no_order }} — {{ $order->customer->nama ?? '-' }}</small>
    </div>

    <div class="bg-secondary rounded p-4" style="max-width:700px;">
        <form action="{{ route('order.update', $order) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" required
                           value="{{ old('tanggal_masuk', $order->tanggal_masuk->format('Y-m-d')) }}"
                           class="form-control bg-dark text-white border-0">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Estimasi Selesai</label>
                    <input type="date" name="estimasi_selesai"
                           value="{{ old('estimasi_selesai', $order->estimasi_selesai?->format('Y-m-d')) }}"
                           class="form-control bg-dark text-white border-0">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pelanggan</label>
                    <select name="customer_id" required class="form-select bg-dark text-white border-0">
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}" {{ $order->customer_id == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Layanan / Paket</label>
                    <select name="package_id" required class="form-select bg-dark text-white border-0">
                        @foreach($packages as $p)
                            <option value="{{ $p->id }}" {{ $order->package_id == $p->id ? 'selected' : '' }}>
                                {{ $p->nama }} — Rp{{ number_format($p->harga,0,',','.') }}/{{ $p->satuan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Berat (Kg)</label>
                    <input type="number" name="berat" step="0.1" min="0.1" required
                           value="{{ old('berat', $order->berat) }}"
                           class="form-control bg-dark text-white border-0">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select bg-dark text-white border-0">
                        @foreach(['Menunggu','Dicuci','Dikeringkan','Disetrika','Siap Diambil','Selesai'] as $st)
                            <option {{ $order->status == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" class="form-control bg-dark text-white border-0" rows="2">{{ old('catatan', $order->catatan) }}</textarea>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Simpan Perubahan</button>
                <a href="{{ route('order.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

</div>
@endsection
