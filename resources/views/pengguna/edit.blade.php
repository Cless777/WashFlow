@extends('layout.app')
@section('title', 'Edit Role | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    <div class="bg-secondary rounded p-4 mb-4">
        <h4 class="text-white mb-1"><i class="fa fa-user-tag me-2 text-primary"></i>Edit Role</h4>
        <small style="color:var(--light);">{{ $role->nama }}</small>
    </div>

    <div class="bg-secondary rounded p-4" style="max-width:600px;">
        <form action="{{ route('roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <label class="form-label">Nama Pengguna</label>
                <input type="text" name="nama_pengguna" required value="{{ old('nama_pengguna', $role->nama_pengguna) }}"
                       class="form-control bg-dark text-white border-0">
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Role</label>
                <input type="text" name="nama" required value="{{ old('nama', $role->nama) }}"
                       class="form-control bg-dark text-white border-0">
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control bg-dark text-white border-0" rows="2">{{ old('deskripsi', $role->deskripsi) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Warna Badge</label>
                <select name="warna_badge" class="form-select bg-dark text-white border-0">
                    @foreach(['danger'=>'Merah','warning'=>'Kuning','info'=>'Biru Muda','success'=>'Hijau','secondary'=>'Abu-abu'] as $val => $label)
                        <option value="{{ $val }}" {{ $role->warna_badge == $val ? 'selected' : '' }}>{{ $label }} ({{ $val }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Preview</label>
                <div><span class="badge bg-{{ $role->warna_badge }} rounded-pill">{{ $role->nama }}</span></div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save me-2"></i>Simpan Perubahan</button>
                <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

</div>
@endsection
