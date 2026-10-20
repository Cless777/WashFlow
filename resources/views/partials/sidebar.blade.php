<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="{{ route('dashboard') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary">
                <i class="fa fa-tint me-2"></i>WashFlow
            </h3>
        </a>

        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt="{{ auth()->user()->name }}" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                <span>{{ auth()->user()->role->nama }}</span>
            </div>
        </div>

        <div class="navbar-nav w-100">

            @if(auth()->user()->role->nama === 'Kasir')

                {{-- ── MENU KHUSUS KASIR ── --}}
                <a href="{{ route('kasir.index') }}"
                   class="nav-item nav-link {{ request()->routeIs('kasir.*') ? 'active' : '' }}">
                    <i class="fa fa-cash-register me-2"></i>Kasir
                </a>

                <a href="{{ route('antrean.index') }}"
                   class="nav-item nav-link {{ request()->routeIs('antrean.index') ? 'active' : '' }}">
                    <i class="fa fa-list-ol me-2"></i>Antrean
                </a>

                <a href="{{ route('status.index') }}"
                   class="nav-item nav-link {{ request()->routeIs('status.index') ? 'active' : '' }}">
                    <i class="fa fa-spinner me-2"></i>Status Cucian
                </a>

                <a href="{{ route('pembayaran.index') }}"
                   class="nav-item nav-link {{ request()->routeIs('pembayaran.index') ? 'active' : '' }}">
                    <i class="fa fa-money-bill-wave me-2"></i>Pembayaran
                </a>

            @else

                {{-- ── MENU ADMIN / OWNER ── --}}
                <a href="{{ route('dashboard') }}"
                   class="nav-item nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                </a>

                <div class="nav-item nav-link text-uppercase small fw-bold" style="font-size:10px;letter-spacing:1px;opacity:.5;pointer-events:none;">
                    Data Master
                </div>

                <a href="{{ route('pelanggan.index') }}"
                   class="nav-item nav-link {{ request()->routeIs('pelanggan.index') ? 'active' : '' }}">
                    <i class="fa fa-users me-2"></i>Pelanggan
                </a>

                <a href="{{ route('paket.index') }}"
                   class="nav-item nav-link {{ request()->routeIs('paket.index') ? 'active' : '' }}">
                    <i class="fa fa-box-open me-2"></i>Paket Laundry
                </a>

                <a href="{{ route('layanan.index') }}"
                   class="nav-item nav-link {{ request()->routeIs('layanan.index') ? 'active' : '' }}">
                    <i class="fa fa-tags me-2"></i>Layanan
                </a>

                <a href="{{ route('contact-messages.index') }}"
                   class="nav-item nav-link {{ request()->routeIs('contact-messages.*') ? 'active' : '' }}">
                    <i class="fa fa-envelope me-2"></i>Pesan Masuk
                </a>

                @if(auth()->user()->role->nama !== 'Owner')
                    <a href="{{ route('pengguna.index') }}"
                       class="nav-item nav-link {{ request()->routeIs('pengguna.*') ? 'active' : '' }}">
                        <i class="fa fa-user-shield me-2"></i>Pengguna
                    </a>
                @endif

                <div class="nav-item nav-link text-uppercase small fw-bold" style="font-size:10px;letter-spacing:1px;opacity:.5;pointer-events:none;">
                    Operasional
                </div>

                @if(auth()->user()->role->nama !== 'Owner')
                    <a href="{{ route('kasir.index') }}"
                    class="nav-item nav-link {{ request()->routeIs('kasir.*') ? 'active' : '' }}">
                        <i class="fa fa-cash-register me-2"></i>Kasir
                    </a>
                @endif

                <a href="{{ route('order.index') }}"
                   class="nav-item nav-link {{ request()->routeIs('order.index') ? 'active' : '' }}">
                    <i class="fa fa-shopping-bag me-2"></i>Order Laundry
                </a>

                <a href="{{ route('antrean.index') }}"
                   class="nav-item nav-link {{ request()->routeIs('antrean.index') ? 'active' : '' }}">
                    <i class="fa fa-list-ol me-2"></i>Antrean
                </a>

                <a href="{{ route('status.index') }}"
                   class="nav-item nav-link {{ request()->routeIs('status.index') ? 'active' : '' }}">
                    <i class="fa fa-spinner me-2"></i>Status Cucian
                </a>

                <div class="nav-item nav-link text-uppercase small fw-bold" style="font-size:10px;letter-spacing:1px;opacity:.5;pointer-events:none;">
                    Keuangan
                </div>

                <a href="{{ route('pembayaran.index') }}"
                   class="nav-item nav-link {{ request()->routeIs('pembayaran.index') ? 'active' : '' }}">
                    <i class="fa fa-money-bill-wave me-2"></i>Pembayaran
                </a>

                <div class="nav-item nav-link text-uppercase small fw-bold" style="font-size:10px;letter-spacing:1px;opacity:.5;pointer-events:none;">
                    Laporan
                </div>

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
                       data-bs-toggle="dropdown">
                        <i class="fa fa-chart-bar me-2"></i>Laporan
                    </a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="{{ route('laporan.transaksi') }}"
                           class="dropdown-item {{ request()->routeIs('laporan.transaksi') ? 'active' : '' }}">
                            Laporan Transaksi
                        </a>
                        <a href="{{ route('laporan.pendapatan') }}"
                           class="dropdown-item {{ request()->routeIs('laporan.pendapatan') ? 'active' : '' }}">
                            Laporan Pendapatan
                        </a>
                        <a href="{{ route('laporan.pelanggan') }}"
                           class="dropdown-item {{ request()->routeIs('laporan.pelanggan') ? 'active' : '' }}">
                            Laporan Pelanggan
                        </a>
                    </div>
                </div>

                @if(auth()->user()->role->nama !== 'Owner')
                    <a href="{{ route('pengaturan.index') }}"
                       class="nav-item nav-link {{ request()->routeIs('pengaturan.index') ? 'active' : '' }}">
                        <i class="fa fa-cog me-2"></i>Pengaturan
                    </a>
                @endif

            @endif

        </div>
    </nav>
</div>
