@extends('layout.app')
@section('title', 'Edit Pelanggan | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    <div class="bg-secondary rounded p-4 mb-4">
        <h4 class="text-white mb-1"><i class="fa fa-user-edit me-2 text-primary"></i>Edit Pelanggan</h4>
        <small style="color:var(--light);">{{ $pelanggan->kode }} — {{ $pelanggan->nama }}</small>
    </div>

    <div class="bg-secondary rounded p-4" style="max-width:600px;">
        <form action="{{ route('pelanggan.update', $pelanggan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" required value="{{ old('nama', $pelanggan->nama) }}"
                       class="form-control bg-dark text-white border-0">
            </div>
            <div class="mb-3">
                <label class="form-label">Nomor HP</label>
                <input type="tel" name="no_hp" required value="{{ old('no_hp', $pelanggan->no_hp) }}"
                       class="form-control bg-dark text-white border-0">
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control bg-dark text-white border-0" rows="3">{{ old('alamat', $pelanggan->alamat) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select bg-dark text-white border-0">
                    <option {{ $pelanggan->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option {{ $pelanggan->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Simpan Perubahan</button>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

</div>
@endsection