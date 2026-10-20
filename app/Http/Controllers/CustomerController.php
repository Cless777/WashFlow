<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Tampilkan daftar pelanggan, dengan search & filter status.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'Semua Status') {
            $query->where('status', $request->status);
        }

        $pelanggan = $query->latest()->paginate(10)->withQueryString();

        return view('pelanggan.index', compact('pelanggan'));
    }

    /**
     * Simpan pelanggan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'no_hp'  => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $validated['kode'] = Customer::generateKode();

        Customer::create($validated);

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit pelanggan.
     */
    public function edit(Customer $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update data pelanggan.
     */
    public function update(Request $request, Customer $pelanggan)
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'no_hp'  => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $pelanggan->update($validated);

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * Hapus pelanggan.
     */
    public function destroy(Customer $pelanggan)
    {
        $pelanggan->delete();

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}
