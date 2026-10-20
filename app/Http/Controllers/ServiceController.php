<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $layanan = Service::latest()->get();

        return view('layanan.index', compact('layanan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'kategori'   => 'required|string|max:50',
            'harga'      => 'required|numeric|min:0',
            'satuan'     => 'required|string|max:30',
            'keterangan' => 'nullable|string',
            'status'     => 'required|in:Aktif,Non-aktif',
        ]);

        $validated['icon']  = 'fa-soap';
        $validated['warna'] = 'primary';

        Service::create($validated);

        return redirect()
            ->route('layanan.index')
            ->with('success', 'Layanan laundry berhasil ditambahkan.');
    }

    public function edit(Service $layanan)
    {
        return view('layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Service $layanan)
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'kategori'   => 'required|string|max:50',
            'harga'      => 'required|numeric|min:0',
            'satuan'     => 'required|string|max:30',
            'keterangan' => 'nullable|string',
            'status'     => 'required|in:Aktif,Non-aktif',
        ]);

        $layanan->update($validated);

        return redirect()
            ->route('layanan.index')
            ->with('success', 'Layanan laundry berhasil diperbarui.');
    }

    public function destroy(Service $layanan)
    {
        $layanan->delete();

        return redirect()
            ->route('layanan.index')
            ->with('success', 'Layanan laundry berhasil dihapus.');
    }
}
