@extends('layout.app')
@section('title', 'Edit Paket Laundry | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    <div class="bg-secondary rounded p-4 mb-4">
        <h4 class="text-white mb-1"><i class="fa fa-box-open me-2 text-primary"></i>Edit Paket Laundry</h4>
        <small style="color:var(--light);">{{ $paket->nama }}</small>
    </div>

    <div class="bg-secondary rounded p-4" style="max-width:600px;">
        <form action="{{ route('paket.update', $paket) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Paket</label>
                <input type="text" name="nama" required value="{{ old('nama', $paket->nama) }}"
                       class="form-control bg-dark text-white border-0">
            </div>
            <div class="mb-3">
                <label class="form-label">Harga</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark text-white border-0">Rp</span>
                    <input type="number" name="harga" required min="0" value="{{ old('harga', $paket->harga) }}"
                           class="form-control bg-dark text-white border-0">
                    <span class="input-group-text bg-dark text-white border-0">/</span>
                    <input type="text" name="satuan" required value="{{ old('satuan', $paket->satuan) }}"
                           class="form-control bg-dark text-white border-0" style="max-width:80px;">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Estimasi Selesai (hari)</label>
                <input type="number" name="estimasi_hari" required min="1" value="{{ old('estimasi_hari', $paket->estimasi_hari) }}"
                       class="form-control bg-dark text-white border-0">
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control bg-dark text-white border-0" rows="2">{{ old('keterangan', $paket->keterangan) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select bg-dark text-white border-0">
                    <option {{ $paket->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option {{ $paket->status == 'Non-aktif' ? 'selected' : '' }}>Non-aktif</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Simpan Perubahan</button>
                <a href="{{ route('paket.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

</div>
@endsection