<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'package']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_order', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($qc) use ($search) {
                    $qc->where('nama', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->get();
        $customers = Customer::all();
        $packages = Package::all();

        return view('order.index', compact('orders', 'customers', 'packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'      => 'required|exists:customers,id',
            'package_id'       => 'required|exists:packages,id',
            'berat'            => 'required|numeric|min:0.1',
            'tanggal_masuk'    => 'required|date',
            'estimasi_selesai' => 'nullable|date',
            'status'           => 'required|in:Menunggu,Dicuci,Dikeringkan,Disetrika,Siap Diambil,Selesai',
            'catatan'          => 'nullable|string',
        ]);

        $package = Package::findOrFail($validated['package_id']);

        $validated['no_order'] = Order::generateNoOrder();
        $validated['total']    = $package->harga * $validated['berat'];

        Order::create($validated);

        return redirect()
            ->route('order.index')
            ->with('success', 'Order laundry berhasil dibuat.');
    }

    public function edit(Order $order)
    {
        $customers = Customer::all();
        $packages = Package::all();

        return view('order.edit', compact('order', 'customers', 'packages'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_id'      => 'required|exists:customers,id',
            'package_id'       => 'required|exists:packages,id',
            'berat'            => 'required|numeric|min:0.1',
            'tanggal_masuk'    => 'required|date',
            'estimasi_selesai' => 'nullable|date',
            'status'           => 'required|in:Menunggu,Dicuci,Dikeringkan,Disetrika,Siap Diambil,Selesai',
            'catatan'          => 'nullable|string',
        ]);

        $package = Package::findOrFail($validated['package_id']);
        $validated['total'] = $package->harga * $validated['berat'];

        $order->update($validated);

        return redirect()
            ->route('order.index')
            ->with('success', 'Order laundry berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('order.index')
            ->with('success', 'Order laundry berhasil dihapus.');
    }
}
