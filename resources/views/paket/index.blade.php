@extends('layout.app')

@section('title', 'Paket Laundry | WashFlow')

@section('content')

<div class="container-fluid pt-4 px-4">

    {{-- =========================
        ALERT SUCCESS
    ========================== --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- =========================
        HEADER
    ========================== --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h4 class="text-white mb-1">
                    <i class="fa fa-box-open me-2 text-primary"></i>
                    Paket Laundry
                </h4>

                <small style="color:var(--light);">
                    Kelola paket dan harga layanan laundry
                </small>
            </div>

            {{-- Admin + Owner boleh tambah --}}
            @if(Auth::user()->role && in_array(Auth::user()->role->nama, ['Admin', 'Owner']))
                <button class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalTambahPaket">
                    <i class="fa fa-plus me-2"></i>
                    Tambah Paket
                </button>
            @endif

        </div>
    </div>


    {{-- =========================
        CARD PAKET
    ========================== --}}
    <div class="row g-4 mb-4">

        @forelse($paket as $p)

            <div class="col-xl-4 col-md-6">

                <div class="bg-secondary rounded p-4 dashboard-card h-100">

                    {{-- Icon + Status --}}
                    <div class="d-flex justify-content-between align-items-start mb-3">

                        <div style="
                            width:56px;
                            height:56px;
                            background:rgba(13,110,253,.15);
                            border-radius:16px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                        ">
                            <i class="fa {{ $p->icon }} fa-lg text-{{ $p->warna }}"></i>
                        </div>

                        <span class="badge rounded-pill bg-{{ $p->status === 'Aktif' ? 'success' : 'secondary' }}">
                            {{ $p->status }}
                        </span>

                    </div>


                    {{-- Nama --}}
                    <h5 class="text-white fw-bold mb-1">
                        {{ $p->nama }}
                    </h5>


                    {{-- Keterangan --}}
                    <p style="color:var(--light);font-size:.85rem;" class="mb-3">
                        {{ $p->keterangan }}
                    </p>


                    {{-- Harga + Estimasi --}}
                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <div class="fw-bold text-primary fs-5">
                                {{ $p->harga_format }}
                            </div>

                            <small style="color:var(--light);">
                                <i class="fa fa-clock me-1"></i>
                                Est. {{ $p->estimasi_format }}
                            </small>

                        </div>


                        {{-- =========================
                            AKSI ADMIN + OWNER
                        ========================== --}}
                        @if(Auth::user()->role && in_array(Auth::user()->role->nama, ['Admin', 'Owner']))

                            <div class="d-flex gap-2">

                                {{-- EDIT --}}
                                <a href="{{ route('paket.edit', $p) }}"
                                   class="btn btn-sm btn-warning"
                                   title="Edit">

                                    <i class="fa fa-edit"></i>

                                </a>


                                {{-- DELETE --}}
                                <form action="{{ route('paket.destroy', $p) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin hapus paket {{ $p->nama }}?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            title="Hapus">

                                        <i class="fa fa-trash"></i>

                                    </button>

                                </form>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="bg-secondary rounded p-4 text-center"
                     style="color:var(--light);">

                    Belum ada paket laundry.
                    Klik "Tambah Paket" untuk menambahkan.

                </div>

            </div>

        @endforelse

    </div>


    {{-- =========================
        MODAL TAMBAH PAKET
    ========================== --}}
    @if(Auth::user()->role && in_array(Auth::user()->role->nama, ['Admin', 'Owner']))

        <div class="modal fade"
             id="modalTambahPaket"
             tabindex="-1"
             aria-hidden="true">

            <div class="modal-dialog">

                <div class="modal-content bg-secondary">

                    <form action="{{ route('paket.store') }}"
                          method="POST">

                        @csrf


                        {{-- MODAL HEADER --}}
                        <div class="modal-header border-0">

                            <h5 class="modal-title text-white">
                                Tambah Paket Laundry
                            </h5>

                            <button type="button"
                                    class="btn-close btn-close-white"
                                    data-bs-dismiss="modal">
                            </button>

                        </div>


                        {{-- MODAL BODY --}}
                        <div class="modal-body">

                            {{-- NAMA --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Nama Paket
                                </label>

                                <input type="text"
                                       name="nama"
                                       required
                                       class="form-control bg-dark text-white border-0"
                                       placeholder="Nama Paket Laundry">

                            </div>


                            {{-- HARGA --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Harga
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-dark text-white border-0">
                                        Rp
                                    </span>

                                    <input type="number"
                                           name="harga"
                                           required
                                           min="0"
                                           class="form-control bg-dark text-white border-0"
                                           placeholder="0">

                                    <span class="input-group-text bg-dark text-white border-0">
                                        /
                                    </span>

                                    <input type="text"
                                           name="satuan"
                                           required
                                           value="kg"
                                           class="form-control bg-dark text-white border-0"
                                           style="max-width:80px;">

                                </div>

                            </div>


                            {{-- ESTIMASI --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Estimasi Selesai (hari)
                                </label>

                                <input type="number"
                                       name="estimasi_hari"
                                       required
                                       min="1"
                                       class="form-control bg-dark text-white border-0"
                                       placeholder="1">

                            </div>


                            {{-- KETERANGAN --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Keterangan
                                </label>

                                <textarea name="keterangan"
                                          class="form-control bg-dark text-white border-0"
                                          rows="2"
                                          placeholder="Deskripsi paket..."></textarea>

                            </div>


                            {{-- STATUS --}}
                            <div class="mb-3">

                                <label class="form-label">
                                    Status
                                </label>

                                <select name="status"
                                        class="form-select bg-dark text-white border-0">

                                    <option value="Aktif">
                                        Aktif
                                    </option>

                                    <option value="Non-aktif">
                                        Non-aktif
                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- MODAL FOOTER --}}
                        <div class="modal-footer border-0">

                            <button type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">

                                Batal

                            </button>

                            <button type="submit"
                                    class="btn btn-primary">

                                <i class="fa fa-save me-2"></i>
                                Simpan

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    @endif

</div>

@endsection