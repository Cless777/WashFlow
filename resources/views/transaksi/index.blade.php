@extends('layout.app')

@section('title', 'Transaksi')

@section('content')

<div class="container-fluid pt-4 px-4">

    <!-- Header -->
    <div class="bg-secondary rounded p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="text-white">
                    <i class="fa fa-cash-register me-2"></i>Transaksi
                </h4>
                <small>Kelola seluruh transaksi WashFlow</small>
            </div>

            <a href="#" class="btn btn-success">
                <i class="fa fa-plus me-2"></i>Transaksi Baru
            </a>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="bg-secondary rounded p-4">
                <h6>Total Hari Ini</h6>
                <h3 class="text-success">Rp2.450.000</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="bg-secondary rounded p-4">
                <h6>Jumlah Pesanan</h6>
                <h3>38</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="bg-secondary rounded p-4">
                <h6>Transaksi Selesai</h6>
                <h3 class="text-info">34</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="bg-secondary rounded p-4">
                <h6>Belum Dibayar</h6>
                <h3 class="text-warning">4</h3>
            </div>
        </div>

    </div>

    <!-- Search -->
    <div class="bg-secondary rounded p-4 mb-4">

        <div class="row">

            <div class="col-md-10">
                <input class="form-control bg-dark border-0 text-white"
                    placeholder="Cari nomor transaksi / pelanggan...">
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">
                    <i class="fa fa-search me-2"></i>Cari
                </button>
            </div>

        </div>

    </div>

    <!-- Table -->
    <div class="bg-secondary rounded p-4">

        <div class="table-responsive">

            <table class="table table-dark table-hover align-middle">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>No Transaksi</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Meja</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    <tr>
                        <td>1</td>
                        <td>TRX001</td>
                        <td>03/08/2026</td>
                        <td>Alvaro</td>
                        <td>M01</td>
                        <td>Rp125.000</td>
                        <td><span class="badge bg-success">Lunas</span></td>
                        <td>
                            <button class="btn btn-info btn-sm">
                                <i class="fa fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>TRX002</td>
                        <td>03/08/2026</td>
                        <td>Budi</td>
                        <td>M03</td>
                        <td>Rp86.000</td>
                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                        <td>
                            <button class="btn btn-info btn-sm">
                                <i class="fa fa-eye"></i>
                            </button>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
