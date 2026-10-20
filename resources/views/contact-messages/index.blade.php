@extends('layout.app')

@section('title', 'Pesan Masuk | WashFlow')

@section('content')
<div class="container-fluid pt-4 px-4">

    {{-- Judul halaman --}}
    <div class="bg-secondary rounded p-4 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h3 class="text-white mb-1">Pesan Masuk</h3>
            <small style="color:var(--light);">
                Kelola pesan yang dikirim melalui halaman Hubungi Kami.
            </small>
        </div>

        <span class="badge bg-primary fs-6">
            Total: {{ $contactMessages->count() }} pesan
        </span>
    </div>

    {{-- Notifikasi berhasil --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close"
                data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    {{-- Notifikasi error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tabel pesan masuk --}}
    <div class="bg-secondary rounded p-4">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Pengirim</th>
                            <th>Kontak</th>
                            <th>Subjek</th>
                            <th>Isi Pesan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($contactMessages as $contactMessage)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <strong>{{ $contactMessage->nama }}</strong>
                                </td>

                                <td>
                                    <div>
                                        <i class="fa fa-envelope me-1"></i>
                                        {{ $contactMessage->email }}
                                    </div>
                                    <div class="text-muted small mt-1">
                                        <i class="fa fa-phone me-1"></i>
                                        {{ $contactMessage->no_hp }}
                                    </div>
                                </td>

                                <td>{{ $contactMessage->subjek }}</td>

                                <td style="min-width: 200px; max-width: 300px;">
                                    {{ $contactMessage->pesan }}
                                </td>

                                <td>
                                    {{ $contactMessage->created_at->format('d/m/Y') }}
                                    <div class="text-muted small">
                                        {{ $contactMessage->created_at->format('H:i') }}
                                    </div>
                                </td>

                                <td>
                                    @if ($contactMessage->status === 'Baru')
                                        <span class="badge bg-danger">Baru</span>
                                    @elseif ($contactMessage->status === 'Dibaca')
                                        <span class="badge bg-warning text-dark">Dibaca</span>
                                    @else
                                        <span class="badge bg-success">Selesai</span>
                                    @endif
                                </td>

                                <td style="min-width: 180px;">
                                    {{-- Ubah status pesan --}}
                                    <form
                                        action="{{ route('contact-messages.update', $contactMessage) }}"
                                        method="POST"
                                        class="mb-2">

                                        @csrf
                                        @method('PUT')

                                        <select name="status"
                                            class="form-select form-select-sm mb-2"
                                            required>
                                            <option value="Baru"
                                                @selected($contactMessage->status === 'Baru')>
                                                Baru
                                            </option>

                                            <option value="Dibaca"
                                                @selected($contactMessage->status === 'Dibaca')>
                                                Dibaca
                                            </option>

                                            <option value="Selesai"
                                                @selected($contactMessage->status === 'Selesai')>
                                                Selesai
                                            </option>
                                        </select>

                                        <button type="submit"
                                            class="btn btn-primary btn-sm w-100">
                                            <i class="fa fa-save me-1"></i>
                                            Simpan Status
                                        </button>
                                    </form>

                                    {{-- Hapus pesan: khusus Admin --}}
                                    @if (Auth::check()
                                        && Auth::user()->role
                                        && Auth::user()->role->nama === 'Admin')

                                        <form
                                            action="{{ route('contact-messages.destroy', $contactMessage) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah kamu yakin ingin menghapus pesan ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn btn-danger btn-sm w-100">
                                                <i class="fa fa-trash me-1"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5>Belum Ada Pesan</h5>
                                    <p class="text-muted mb-0">
                                        Pesan dari pengunjung akan muncul di sini.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

    </div>
</div>
@endsection
