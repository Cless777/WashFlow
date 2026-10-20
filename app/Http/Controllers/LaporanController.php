<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function transaksi(Request $request)
    {
        $query = Payment::with(['order.customer', 'order.package']);

        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }

        $transaksi = $query->latest('tanggal')->get();

        $totalPendapatan = $transaksi->sum('jumlah_dibayar');
        $totalTransaksi  = $transaksi->count();
        $totalOrder      = Order::count();
        $rataRata        = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;

        // Data grafik: jumlah transaksi per hari, 7 hari terakhir
        $grafik = collect(range(6, 0))->map(function ($i) {
            $tanggal = today()->subDays($i);
            return [
                'label' => $tanggal->translatedFormat('D'),
                'jumlah' => Payment::whereDate('tanggal', $tanggal)->count(),
            ];
        });

        return view('laporan.transaksi', compact(
            'transaksi', 'totalPendapatan', 'totalTransaksi', 'totalOrder', 'rataRata', 'grafik'
        ));
    }

    public function pendapatan(Request $request)
    {
        $bulanIni = Payment::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('jumlah_dibayar');

        $hariIni = Payment::whereDate('tanggal', today())->sum('jumlah_dibayar');

        $rataPerHari = now()->day > 0 ? $bulanIni / now()->day : 0;

        // Pendapatan per layanan (package), bulan ini
        $perLayanan = Payment::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->with('order.package')
            ->get()
            ->groupBy(fn($p) => $p->order->package->nama ?? 'Lainnya')
            ->map(fn($group, $nama) => [
                'nama' => $nama,
                'pendapatan' => $group->sum('jumlah_dibayar'),
            ])
            ->sortByDesc('pendapatan')
            ->values();

        $totalUntukPersen = $perLayanan->sum('pendapatan') ?: 1;
        $perLayanan = $perLayanan->map(function ($item) use ($totalUntukPersen) {
            $item['pct'] = round(($item['pendapatan'] / $totalUntukPersen) * 100);
            return $item;
        });

        // Pendapatan per metode, bulan ini
        $perMetode = Payment::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->get()
            ->groupBy('metode')
            ->map(fn($group, $metode) => [
                'nama' => $metode ?? '-',
                'jml' => $group->count(),
                'pendapatan' => $group->sum('jumlah_dibayar'),
            ])
            ->values();

        $totalTrxUntukPersen = $perMetode->sum('jml') ?: 1;
        $perMetode = $perMetode->map(function ($item) use ($totalTrxUntukPersen) {
            $item['pct'] = round(($item['jml'] / $totalTrxUntukPersen) * 100);
            return $item;
        });

        // Grafik pendapatan bulanan, 6 bulan terakhir
        $grafikBulanan = collect(range(5, 0))->map(function ($i) {
            $bulan = now()->subMonths($i);
            return [
                'label' => $bulan->translatedFormat('M'),
                'total' => Payment::whereMonth('tanggal', $bulan->month)
                    ->whereYear('tanggal', $bulan->year)
                    ->sum('jumlah_dibayar'),
            ];
        });

        return view('laporan.pendapatan', compact(
            'bulanIni', 'hariIni', 'rataPerHari', 'perLayanan', 'perMetode', 'grafikBulanan'
        ));
    }

    public function pelanggan()
    {
        $totalPelanggan  = Customer::count();
        $pelangganAktif  = Customer::where('status', 'Aktif')->count();
        $pelangganBaru   = Customer::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $rataOrder       = $totalPelanggan > 0
            ? round(Order::count() / $totalPelanggan, 1)
            : 0;

        // Top 5 pelanggan berdasarkan jumlah order
        $topPelanggan = Order::with(['customer', 'package'])
            ->get()
            ->groupBy('customer_id')
            ->map(function ($orders) {
                $customer = $orders->first()->customer;
                $favorit = $orders->groupBy(fn($o) => $o->package->nama ?? '-')
                    ->sortByDesc(fn($g) => $g->count())
                    ->keys()
                    ->first();

                return [
                    'nama'  => $customer->nama ?? '-',
                    'hp'    => $customer->no_hp ?? '-',
                    'order' => $orders->count(),
                    'total' => $orders->sum('total'),
                    'fav'   => $favorit,
                    'status'=> $customer->status ?? '-',
                ];
            })
            ->sortByDesc('order')
            ->take(5)
            ->values();

        return view('laporan.pelanggan', compact(
            'totalPelanggan', 'pelangganAktif', 'pelangganBaru', 'rataOrder', 'topPelanggan'
        ));
    }
}
