@extends('layout.app')
@section('title', 'Pelanggan | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Header --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="text-white mb-1"><i class="fa fa-users me-2 text-primary"></i>Data Pelanggan</h4>
                <small style="color:var(--light);">Kelola data seluruh pelanggan WashFlow</small>
            </div>
            @if(Auth::user()->role->nama === 'Admin' || Auth::user()->role->nama === 'Kasir')
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fa fa-plus me-2"></i>Tambah Pelanggan
            </button>
            @endif
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <form method="GET" action="{{ route('pelanggan.index') }}" class="row g-3">
            <div class="col-md-5">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control bg-dark text-white border-0" placeholder="Cari nama atau nomor HP...">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select bg-dark text-white border-0">
                    <option {{ request('status') == '' ? 'selected' : '' }}>Semua Status</option>
                    <option {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search me-2"></i>Cari</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('pelanggan.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fa fa-redo me-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-secondary rounded p-4">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Nomor HP</th>
                        <th>Alamat</th>
                        <th>Total Order</th>
                        <th>Status</th>
                        <th width="130">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggan as $p)
                    <tr>
                        <td><span class="fw-bold text-primary">{{ $p->kode }}</span></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:36px;height:36px;background:rgba(13,110,253,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <i class="fa fa-user text-primary" style="font-size:.8rem;"></i>
                                </div>
                                {{ $p->nama }}
                            </div>
                        </td>
                        <td>{{ $p->no_hp }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td><span class="badge rounded-pill" style="background:rgba(13,110,253,.2);color:#6ea8fe;">{{ $p->total_order }} order</span></td>
                        <td>
                            <span class="badge rounded-pill bg-{{ $p->status === 'Aktif' ? 'success' : 'secondary' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('pelanggan.edit', $p) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            @if(Auth::user()->role->nama === 'Admin' || Auth::user()->role->nama === 'Kasir')
                            <form action="{{ route('pelanggan.destroy', $p) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus pelanggan {{ $p->nama }}?');">
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
                        <td colspan="7" class="text-center py-4" style="color:var(--light);">
                            Belum ada data pelanggan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-between align-items-center mt-3">
            <small style="color:var(--light);">
                Menampilkan {{ $pelanggan->count() }} dari {{ $pelanggan->total() }} pelanggan
            </small>
            {{ $pelanggan->links() }}
        </div>
    </div>

</div>

{{-- Modal Tambah Pelanggan --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <form action="{{ route('pelanggan.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white">Tambah Pelanggan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" required
                               class="form-control bg-dark text-white border-0" placeholder="Nama Pelanggan">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor HP</label>
                        <input type="tel" name="no_hp" required
                               class="form-control bg-dark text-white border-0" placeholder="08xxxxxxxxxx">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control bg-dark text-white border-0" rows="3"
                                  placeholder="Alamat lengkap"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select bg-dark text-white border-0">
                            <option>Aktif</option>
                            <option>Tidak Aktif</option>
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