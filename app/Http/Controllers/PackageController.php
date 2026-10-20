<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $paket = Package::latest()->get();

        return view('paket.index', compact('paket'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'harga'         => 'required|numeric|min:0',
            'satuan'        => 'required|string|max:20',
            'estimasi_hari' => 'required|integer|min:1',
            'keterangan'    => 'nullable|string',
            'status'        => 'required|in:Aktif,Non-aktif',
        ]);

        $validated['icon']  = 'fa-box-open';
        $validated['warna'] = 'primary';

        Package::create($validated);

        return redirect()
            ->route('paket.index')
            ->with('success', 'Paket laundry berhasil ditambahkan.');
    }

    public function edit(Package $paket)
    {
        return view('paket.edit', compact('paket'));
    }

    public function update(Request $request, Package $paket)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:255',
            'harga'         => 'required|numeric|min:0',
            'satuan'        => 'required|string|max:20',
            'estimasi_hari' => 'required|integer|min:1',
            'keterangan'    => 'nullable|string',
            'status'        => 'required|in:Aktif,Non-aktif',
        ]);

        $paket->update($validated);

        return redirect()
            ->route('paket.index')
            ->with('success', 'Paket laundry berhasil diperbarui.');
    }

    public function destroy(Package $paket)
    {
        $paket->delete();

        return redirect()
            ->route('paket.index')
            ->with('success', 'Paket laundry berhasil dihapus.');
    }
}
