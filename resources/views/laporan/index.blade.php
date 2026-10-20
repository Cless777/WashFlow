@extends('layout.app')

@section('title','Laporan')

@section('content')

<div class="container-fluid pt-4 px-4">

    <!-- Header -->
    <div class="bg-secondary rounded p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="text-white">
                    <i class="fa fa-chart-line me-2"></i>Laporan Penjualan
                </h4>
                <small>Rekap seluruh transaksi WashFlow</small>
            </div>

            <button class="btn btn-success">
                <i class="fa fa-file-excel me-2"></i>Export Excel
            </button>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row g-4 mb-4">

        <div class="col-md-3">
            <div class="bg-secondary rounded p-4 text-center">
                <h6>Total Pendapatan</h6>
                <h3 class="text-success">Rp12.500.000</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="bg-secondary rounded p-4 text-center">
                <h6>Total Transaksi</h6>
                <h3>245</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="bg-secondary rounded p-4 text-center">
                <h6>Produk Terjual</h6>
                <h3>1.280</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="bg-secondary rounded p-4 text-center">
                <h6>Rata-rata Transaksi</h6>
                <h3>Rp51.000</h3>
            </div>
        </div>

    </div>

    <!-- Filter -->
    <div class="bg-secondary rounded p-4 mb-4">

        <div class="row">

            <div class="col-md-3">
                <label>Tanggal Awal</label>
                <input type="date" class="form-control bg-dark text-white border-0">
            </div>

            <div class="col-md-3">
                <label>Tanggal Akhir</label>
                <input type="date" class="form-control bg-dark text-white border-0">
            </div>

            <div class="col-md-3">
                <label>Status</label>
                <select class="form-select bg-dark text-white border-0">
                    <option>Semua</option>
                    <option>Lunas</option>
                    <option>Pending</option>
                </select>
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100">
                    <i class="fa fa-search me-2"></i>Tampilkan
                </button>
            </div>

        </div>

    </div>

    <!-- Tabel -->
    <div class="bg-secondary rounded p-4">

        <div class="table-responsive">

            <table class="table table-dark table-hover">

                <thead>

                <tr>
                    <th>No</th>
                    <th>No Transaksi</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>

                </thead>

                <tbody>

                <tr>
                    <td>1</td>
                    <td>TRX001</td>
                    <td>03/08/2026</td>
                    <td>Alvaro</td>
                    <td>Rp125.000</td>
                    <td><span class="badge bg-success">Lunas</span></td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>TRX002</td>
                    <td>03/08/2026</td>
                    <td>Budi</td>
                    <td>Rp85.000</td>
                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>TRX003</td>
                    <td>03/08/2026</td>
                    <td>Siti</td>
                    <td>Rp210.000</td>
                    <td><span class="badge bg-success">Lunas</span></td>
                </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
