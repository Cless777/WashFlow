<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Package;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CashierController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        $packages = Package::all();
        $orders = Order::with(['customer', 'package'])
            ->whereDate('tanggal_masuk', today())
            ->latest()
            ->get();

        return view('kasir.index', compact('customers', 'packages', 'orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'package_id'  => 'required|exists:packages,id',
            'berat'       => 'required|numeric|min:0.1',
        ]);

        $package = Package::findOrFail($request->package_id);
        $total = $package->harga * $request->berat;

        Order::create([
            'no_order'         => 'ORD-' . strtoupper(Str::random(6)),
            'customer_id'      => $request->customer_id,
            'package_id'       => $request->package_id,
            'berat'            => $request->berat,
            'total'            => $total,
            'tanggal_masuk'    => now(),
            'estimasi_selesai' => $request->estimasi_selesai,
            'status'           => 'Menunggu',
            'catatan'          => $request->catatan,
        ]);

        return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
        ]);

        \App\Models\Customer::create([
            'kode'   => \App\Models\Customer::generateKode(),
            'nama'   => $request->nama,
            'no_hp'  => $request->no_hp,
            'status' => 'Aktif',
        ]);

        return redirect()->route('kasir.index')->with('success', 'Pelanggan baru berhasil ditambahkan!');
    }
}