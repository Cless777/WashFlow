<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Card: Order Hari Ini 
        $orderHariIni = Order::whereDate('tanggal_masuk', today())->count();
        $orderKemarin = Order::whereDate('tanggal_masuk', today()->subDay())->count();
        $selisihOrder = $orderHariIni - $orderKemarin;

        // ── Card: Sedang Diproses & Siap Diambil 
        $sedangDiproses = Order::whereIn('status', ['Dicuci', 'Dikeringkan', 'Disetrika'])->count();
        $siapDiambil    = Order::where('status', 'Siap Diambil')->count();

        // ── Card: Pendapatan Hari Ini ─────────
        $pendapatanHariIni  = Payment::whereDate('tanggal', today())->sum('jumlah_dibayar');
        $pendapatanKemarin  = Payment::whereDate('tanggal', today()->subDay())->sum('jumlah_dibayar');
        $persenPendapatan   = $pendapatanKemarin > 0
            ? round((($pendapatanHariIni - $pendapatanKemarin) / $pendapatanKemarin) * 100)
            : 0;

        // ── Grafik: Pendapatan 7 hari terakhir 
        $grafik = collect(range(6, 0))->map(function ($i) {
            $tanggal = today()->subDays($i);
            return [
                'label' => $tanggal->translatedFormat('l'),
                'total' => Payment::whereDate('tanggal', $tanggal)->sum('jumlah_dibayar'),
            ];
        });

        // ── Ringkasan Status Cucian (order yang belum Selesai) 
        $statuses = collect([
            ['label' => 'Menunggu',    'color' => 'warning', 'icon' => 'fa-clock'],
            ['label' => 'Dicuci',      'color' => 'info',    'icon' => 'fa-soap'],
            ['label' => 'Dikeringkan', 'color' => 'primary', 'icon' => 'fa-wind'],
            ['label' => 'Disetrika',   'color' => 'danger',  'icon' => 'fa-ruler'],
            ['label' => 'Siap Diambil','color' => 'success', 'icon' => 'fa-check-circle'],
        ])->map(function ($s) {
            $s['count'] = Order::where('status', $s['label'])->count();
            return $s;
        });

        // ── Order Terbaru 
        $orders = Order::with(['customer', 'package'])->latest()->take(5)->get();

        return view('dashboard.index', compact(
            'orderHariIni', 'selisihOrder', 'sedangDiproses', 'siapDiambil',
            'pendapatanHariIni', 'persenPendapatan', 'grafik', 'statuses', 'orders'
        ));
    }
}