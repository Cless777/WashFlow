@extends('layout.app')
@section('title', 'Layanan Laundry | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Header --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="text-white mb-1"><i class="fa fa-soap me-2 text-primary"></i>Layanan Laundry</h4>
                <small style="color:var(--light);">Kelola jenis layanan dan kategori laundry</small>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahLayanan">
                <i class="fa fa-plus me-2"></i>Tambah Layanan
            </button>
        </div>
    </div>

    {{-- Card Layanan --}}
    <div class="row g-4 mb-4">
        @forelse($layanan as $l)
        <div class="col-xl-4 col-md-6">
            <div class="bg-secondary rounded p-4 dashboard-card h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div style="width:56px;height:56px;background:rgba(13,110,253,.15);border-radius:16px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa {{ $l->icon }} fa-lg text-{{ $l->warna }}"></i>
                    </div>
                    <span class="badge rounded-pill bg-{{ $l->status === 'Aktif' ? 'success' : 'secondary' }}">
                        {{ $l->status }}
                    </span>
                </div>
                <h5 class="text-white fw-bold mb-1">{{ $l->nama }}</h5>
                <span class="badge bg-dark text-white-50 mb-2" style="font-weight:400;">{{ $l->kategori }}</span>
                <p style="color:var(--light);font-size:.85rem;" class="mb-3">{{ $l->keterangan }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold text-primary fs-5">{{ $l->harga_format }}</div>
                        <small style="color:var(--light);"><i class="fa fa-balance-scale me-1"></i>{{ $l->satuan }}</small>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('layanan.edit', $l) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('layanan.destroy', $l) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin hapus layanan {{ $l->nama }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="bg-secondary rounded p-4 text-center" style="color:var(--light);">
                Belum ada layanan laundry. Klik "Tambah Layanan" untuk menambahkan.
            </div>
        </div>
        @endforelse
    </div>

    {{-- Tabel List --}}
    {{-- <div class="bg-secondary rounded p-4">
        <h5 class="text-white mb-4"><i class="fa fa-list me-2 text-primary"></i>Daftar Layanan</h5>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Layanan</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Satuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($layanan as $i => $l)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><i class="fa {{ $l->icon }} me-2 text-{{ $l->warna }}"></i>{{ $l->nama }}</td>
                        <td>{{ $l->kategori }}</td>
                        <td class="fw-bold text-primary">{{ $l->harga_format }}</td>
                        <td>{{ $l->satuan }}</td>
                        <td><span class="badge bg-{{ $l->status === 'Aktif' ? 'success' : 'secondary' }}">{{ $l->status }}</span></td>
                        <td>
                            <a href="{{ route('layanan.edit', $l) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('layanan.destroy', $l) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus layanan {{ $l->nama }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4" style="color:var(--light);">Belum ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div> --}}

</div>

{{-- Modal Tambah Layanan --}}
<div class="modal fade" id="modalTambahLayanan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <form action="{{ route('layanan.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white">Tambah Layanan Laundry</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Layanan</label>
                        <input type="text" name="nama" required class="form-control bg-dark text-white border-0" placeholder="Nama Layanan Laundry">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select bg-dark text-white border-0">
                            <option>Cuci</option>
                            <option>Setrika</option>
                            <option>Dry Clean</option>
                            <option>Express</option>
                            <option>Sepatu</option>
                            <option>Karpet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-white border-0">Rp</span>
                            <input type="number" name="harga" required min="0" class="form-control bg-dark text-white border-0" placeholder="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Satuan</label>
                        <select name="satuan" class="form-select bg-dark text-white border-0">
                            <option>per kg</option>
                            <option>per item</option>
                            <option>per pasang</option>
                            <option>per m2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control bg-dark text-white border-0" rows="2" placeholder="Deskripsi layanan..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select bg-dark text-white border-0">
                            <option>Aktif</option>
                            <option>Non-aktif</option>
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
