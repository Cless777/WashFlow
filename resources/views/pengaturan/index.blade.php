@extends('layout.app')
@section('title', 'Pengaturan | WashFlow')
@section('content')
<div class="container-fluid pt-4 px-4">

    {{-- Header --}}
    <div class="bg-secondary rounded p-4 mb-4">
        <h4 class="text-white mb-1"><i class="fa fa-cog me-2 text-primary"></i>Pengaturan Sistem</h4>
        <small style="color:var(--light);">Konfigurasi profil laundry dan sistem WashFlow</small>
    </div>

    <div class="row g-4">

        {{-- Profil Laundry --}}
        <div class="col-lg-8">
            <div class="bg-secondary rounded p-4 mb-4">
                <h5 class="text-white mb-4"><i class="fa fa-store me-2 text-primary"></i>Profil Laundry</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Laundry</label>
                        <input type="text" class="form-control bg-dark text-white border-0" value="WashFlow Laundry">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor WhatsApp</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-white border-0"><i class="fab fa-whatsapp"></i></span>
                            <input type="text" class="form-control bg-dark text-white border-0" value="+62 812-3456-7890">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat Laundry</label>
                        <textarea class="form-control bg-dark text-white border-0" rows="2">Jl. Laundry Bersih No. 12, Kota Baru, Indonesia</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Laundry</label>
                        <input type="email" class="form-control bg-dark text-white border-0" value="info@washflow.id">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Logo Laundry</label>
                        <input type="file" class="form-control bg-dark text-white border-0" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jam Buka</label>
                        <input type="time" class="form-control bg-dark text-white border-0" value="08:00">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jam Tutup</label>
                        <input type="time" class="form-control bg-dark text-white border-0" value="20:00">
                    </div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-primary"><i class="fa fa-save me-2"></i>Simpan Profil</button>
                </div>
            </div>

            {{-- Sistem --}}
            <div class="bg-secondary rounded p-4 mb-4">
                <h5 class="text-white mb-4"><i class="fa fa-sliders-h me-2 text-primary"></i>Pengaturan Sistem</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Bahasa</label>
                        <select class="form-select bg-dark text-white border-0">
                            <option selected>Bahasa Indonesia</option>
                            <option>English</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Zona Waktu</label>
                        <select class="form-select bg-dark text-white border-0">
                            <option selected>WIB (UTC+7)</option>
                            <option>WITA (UTC+8)</option>
                            <option>WIT (UTC+9)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Format Mata Uang</label>
                        <select class="form-select bg-dark text-white border-0">
                            <option selected>Rupiah (Rp)</option>
                            <option>USD ($)</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-primary"><i class="fa fa-save me-2"></i>Simpan Pengaturan</button>
                </div>
            </div>

            {{-- Pembayaran --}}
            <div class="bg-secondary rounded p-4">
                <h5 class="text-white mb-4"><i class="fa fa-credit-card me-2 text-primary"></i>Pengaturan Pembayaran</h5>
                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran Aktif</label>
                    <div class="d-flex gap-4 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="cash" checked>
                            <label class="form-check-label" for="cash"><i class="fa fa-money-bill me-1 text-success"></i>Cash</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="transfer" checked>
                            <label class="form-check-label" for="transfer"><i class="fa fa-university me-1 text-primary"></i>Transfer Bank</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="qris" checked>
                            <label class="form-check-label" for="qris"><i class="fa fa-qrcode me-1 text-warning"></i>QRIS</label>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pajak (%)</label>
                    <div class="input-group">
                        <input type="number" class="form-control bg-dark text-white border-0" value="0" placeholder="0 = tidak ada pajak">
                        <span class="input-group-text bg-dark text-white border-0">%</span>
                    </div>
                    <small style="color:var(--light);">Isi 0 jika tidak ada pajak tambahan</small>
                </div>
                <div class="mt-4">
                    <button class="btn btn-primary"><i class="fa fa-save me-2"></i>Simpan</button>
                </div>
            </div>
        </div>

        {{-- Sidebar Info --}}
        <div class="col-lg-4">
            <div class="bg-secondary rounded p-4 mb-4">
                <h5 class="text-white mb-4"><i class="fa fa-info-circle me-2 text-primary"></i>Info Sistem</h5>
                <div class="mb-3">
                    <small style="color:var(--light);">Versi Aplikasi</small>
                    <div class="text-white fw-bold">WashFlow v1.0.0</div>
                </div>
                <div class="mb-3">
                    <small style="color:var(--light);">Framework</small>
                    <div class="text-white fw-bold">Laravel</div>
                </div>
                <div class="mb-3">
                    <small style="color:var(--light);">Developer</small>
                    <div class="text-white fw-bold">Muhammad Gustian Alvaro</div>
                </div>
                <div class="mb-3">
                    <small style="color:var(--light);">Tahun</small>
                    <div class="text-white fw-bold">2026</div>
                </div>
                <hr style="border-color:rgba(255,255,255,.1);">
                <div class="d-flex gap-2">
                    <span class="badge bg-success px-3 py-2"><i class="fa fa-circle me-1"></i>Sistem Online</span>
                </div>
            </div>

            <div class="bg-secondary rounded p-4">
                <h5 class="text-white mb-4"><i class="fa fa-user-circle me-2 text-primary"></i>Profil Anda</h5>
                <div class="text-center mb-3">
                    <img src="{{ asset('img/user.jpg') }}" class="rounded-circle" style="width:80px;height:80px;border:3px solid var(--primary);">
                    <div class="mt-2">
                        <h6 class="text-white mb-0">Alvaro</h6>
                        <small style="color:var(--light);">Super Admin</small>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ganti Password</label>
                    <input type="password" class="form-control bg-dark text-white border-0 mb-2" placeholder="Password Lama">
                    <input type="password" class="form-control bg-dark text-white border-0 mb-2" placeholder="Password Baru">
                    <input type="password" class="form-control bg-dark text-white border-0" placeholder="Konfirmasi Password">
                </div>
                <button class="btn btn-primary w-100"><i class="fa fa-key me-2"></i>Ganti Password</button>
            </div>
        </div>

    </div>

</div>
@endsection
