<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'package']);

        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $query->where('status', $request->status);
        }

        $items = $query->latest()->get();

        return view('status.index', compact('items'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:Menunggu,Dicuci,Dikeringkan,Disetrika,Siap Diambil,Selesai',
        ]);

        $order->update($validated);

        return redirect()
            ->route('status.index')
            ->with('success', "Status order {$order->no_order} berhasil diubah menjadi {$order->status}.");
    }
}