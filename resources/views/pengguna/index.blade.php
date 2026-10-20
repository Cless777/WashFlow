@extends('layout.app')
@section('title', 'Roles | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Header --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="text-white mb-1"><i class="fa fa-user-tag me-2 text-primary"></i>Roles</h4>
                <small style="color:var(--light);">Kelola daftar peran/hak akses pengguna WashFlow</small>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahRole">
                <i class="fa fa-plus me-2"></i>Tambah Role
            </button>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="bg-secondary rounded p-4">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengguna</th>
                        <th>Nama Role</th>
                        <th>Deskripsi</th>
                        <th>Preview Badge</th>
                        <th>Status</th>
                        <th width="130">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $i => $role)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="fw-bold text-white">{{ $role->nama_pengguna }}</td>
                        <td class="fw-bold text-white">{{ $role->nama }}</td>
                        <td style="color:var(--light);">{{ $role->deskripsi ?? '-' }}</td>
                        <td><span class="badge bg-{{ $role->warna_badge }} rounded-pill">{{ $role->nama }}</span></td>
                        <td>
                            <span class="badge rounded-pill bg-{{ $role->status ? 'success' : 'secondary' }}">
                                {{ $role->status ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin hapus role {{ $role->nama }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4" style="color:var(--light);">
                            Belum ada role. Klik "Tambah Role" untuk menambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Modal Tambah Role --}}
<div class="modal fade" id="modalTambahRole" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-secondary">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white">Tambah Role</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <label class="form-label">Nama Pengguna</label>
                        <input type="text" name="nama_pengguna" required class="form-control bg-dark text-white border-0" placeholder="Contoh: Alvaro">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Role</label>
                        <input type="text" name="nama" required class="form-control bg-dark text-white border-0" placeholder="Contoh: Admin, Kasir">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control bg-dark text-white border-0" rows="2" placeholder="Deskripsi singkat hak akses role ini..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Warna Badge</label>
                        <select name="warna_badge" class="form-select bg-dark text-white border-0">
                            <option value="danger">Merah (danger)</option>
                            <option value="warning">Kuning (warning)</option>
                            <option value="info">Biru Muda (info)</option>
                            <option value="success">Hijau (success)</option>
                            <option value="secondary">Abu-abu (secondary)</option>
                        </select>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="status" value="1" id="statusBaru" checked>
                        <label class="form-check-label text-white" for="statusBaru">Aktif</label>
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
