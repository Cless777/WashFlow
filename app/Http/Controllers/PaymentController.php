<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['order.customer']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_transaksi', 'like', "%{$search}%")
                  ->orWhereHas('order.customer', function ($qc) use ($search) {
                      $qc->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $query->where('status', $request->status);
        }

        if ($request->filled('metode') && $request->metode !== 'Semua Metode') {
            $query->where('metode', $request->metode);
        }

        $payments = $query->latest()->get();

        // Statistik untuk 3 card di atas
        $totalLunas      = Payment::where('status', 'Lunas')->sum('jumlah_dibayar');
        $totalDp         = Payment::where('status', 'DP')->sum('jumlah_dibayar');
        $totalBelumBayar = Order::whereDoesntHave('payment')->orWhereHas('payment', function ($q) {
                $q->where('status', 'Belum Bayar');
            })->with('payment')->get()->sum(function ($order) {
                return $order->total - ($order->payment->jumlah_dibayar ?? 0);
            });

        // Order yang belum punya pembayaran sama sekali, untuk dropdown "Catat Pembayaran"
        $ordersBelumBayar = Order::whereDoesntHave('payment')->with('customer')->get();

        return view('pembayaran.index', compact(
            'payments', 'totalLunas', 'totalDp', 'totalBelumBayar', 'ordersBelumBayar'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id'       => 'required|exists:orders,id',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'metode'         => 'required|in:Cash,Transfer,QRIS',
            'status'         => 'required|in:Lunas,DP,Belum Bayar',
        ]);

        $validated['no_transaksi'] = Payment::generateNoTransaksi();
        $validated['tanggal'] = now();

        Payment::create($validated);

        return redirect()
            ->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function edit(Payment $pembayaran)
    {
        return view('pembayaran.edit', ['payment' => $pembayaran]);
    }

    public function update(Request $request, Payment $pembayaran)
    {
        $validated = $request->validate([
            'jumlah_dibayar' => 'required|numeric|min:0',
            'metode'         => 'required|in:Cash,Transfer,QRIS',
            'status'         => 'required|in:Lunas,DP,Belum Bayar',
        ]);

        $pembayaran->update($validated);

        return redirect()
            ->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil diperbarui.');
    }
}
