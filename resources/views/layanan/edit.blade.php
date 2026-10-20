@extends('layout.app')
@section('title', 'Edit Layanan Laundry | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    <div class="bg-secondary rounded p-4 mb-4">
        <h4 class="text-white mb-1"><i class="fa fa-soap me-2 text-primary"></i>Edit Layanan Laundry</h4>
        <small style="color:var(--light);">{{ $layanan->nama }}</small>
    </div>

    <div class="bg-secondary rounded p-4" style="max-width:600px;">
        <form action="{{ route('layanan.update', $layanan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Layanan</label>
                <input type="text" name="nama" required value="{{ old('nama', $layanan->nama) }}"
                       class="form-control bg-dark text-white border-0">
            </div>
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-select bg-dark text-white border-0">
                    @foreach(['Cuci', 'Setrika', 'Dry Clean', 'Express', 'Sepatu', 'Karpet'] as $kat)
                        <option {{ $layanan->kategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark text-white border-0">Rp</span>
                    <input type="number" name="harga" required min="0" value="{{ old('harga', $layanan->harga) }}"
                           class="form-control bg-dark text-white border-0">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Satuan</label>
                <select name="satuan" class="form-select bg-dark text-white border-0">
                    @foreach(['per kg', 'per item', 'per pasang', 'per m2'] as $sat)
                        <option {{ $layanan->satuan == $sat ? 'selected' : '' }}>{{ $sat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control bg-dark text-white border-0" rows="2">{{ old('keterangan', $layanan->keterangan) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select bg-dark text-white border-0">
                    <option {{ $layanan->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option {{ $layanan->status == 'Non-aktif' ? 'selected' : '' }}>Non-aktif</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Simpan Perubahan</button>
                <a href="{{ route('layanan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

</div>
@endsection
