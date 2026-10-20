<nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
    <a href="{{ route('dashboard') }}" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-tint"></i></h2>
    </a>

    <a href="#" class="sidebar-toggler shrink-0">
        <i class="fa fa-bars"></i>
    </a>
    <form class="d-none d-md-flex ms-4">
        <input class="form-control bg-dark border-0" type="search" placeholder="Cari order, pelanggan...">
    </form>
    <div class="navbar-nav align-items-center ms-auto">

        {{-- Notifikasi --}}
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-bell me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Notifikasi</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                <a href="#" class="dropdown-item">
                    <h6 class="fw-normal mb-0">Order LA005 siap diambil</h6>
                    <small>5 menit lalu</small>
                </a>
                <hr class="dropdown-divider">
                <a href="#" class="dropdown-item">
                    <h6 class="fw-normal mb-0">Pembayaran LA003 belum lunas</h6>
                    <small>30 menit lalu</small>
                </a>
                <hr class="dropdown-divider">
                <a href="#" class="dropdown-item">
                    <h6 class="fw-normal mb-0">Order baru dari Sinta</h6>
                    <small>1 jam lalu</small>
                </a>
                <hr class="dropdown-divider">
                <a href="#" class="dropdown-item text-center">Lihat semua notifikasi</a>
            </div>
        </div>

        {{-- Profile --}}
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img class="rounded-circle me-lg-2" src="{{ asset('img/user.jpg') }}" alt="Alvaro" style="width: 40px; height: 40px;">
                <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                <a href="#" class="dropdown-item">
                    <i class="fa fa-user me-2"></i>Profil Saya
                </a>
                <a href="{{ route('pengaturan.index') }}" class="dropdown-item">
                    <i class="fa fa-cog me-2"></i>Pengaturan
                </a>
                <hr class="dropdown-divider">
                <form action="{{ route('logout') }}" method="POST" class="dropdown-item text-danger">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger p-0">
                        <i class="fa fa-sign-out-alt me-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</nav>
