<?php

namespace App\Http\Controllers;

use App\Models\Order;

class QueueController extends Controller
{
    public function index()
    {
        // Ambil order yang tanggal masuknya HARI INI, urutkan dari yang paling awal dibuat
        $orders = Order::with(['customer', 'package'])
            ->whereDate('tanggal_masuk', today())
            ->orderBy('created_at')
            ->get();

        // Cari order yang statusnya "sedang diproses" (bukan Menunggu, bukan Selesai)
        $sedangDilayani = $orders->first(function ($o) {
            return in_array($o->status, ['Dicuci', 'Dikeringkan', 'Disetrika', 'Siap Diambil']);
        });

        // Cari order paling awal yang masih Menunggu
        $antreanBerikutnya = $orders->first(function ($o) {
            return $o->status === 'Menunggu';
        });

        // Cari nomor urut antrean (index + 1) dari dua order di atas, untuk ditampilkan di card
        $noSedangDilayani = $sedangDilayani ? $orders->search($sedangDilayani) + 1 : null;
        $noAntreanBerikutnya = $antreanBerikutnya ? $orders->search($antreanBerikutnya) + 1 : null;

        return view('antrean.index', [
            'orders'              => $orders,
            'noSedangDilayani'    => $noSedangDilayani,
            'noAntreanBerikutnya' => $noAntreanBerikutnya,
            'totalHariIni'        => $orders->count(),
        ]);
    }
}