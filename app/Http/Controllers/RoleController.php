<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::latest()->get();

        return view('pengguna.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengguna' => 'nullable|string|max:255',
            'nama'        => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
            'warna_badge' => 'required|string|max:20',
            'status'      => 'required|boolean',
        ]);

        $validated['status'] = $validated['status'] ? true : false;
        Role::create($validated);

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Role berhasil ditambahkan.');
    }

    public function edit(Role $role)
    {
        return view('pengguna.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'nama_pengguna' => 'nullable|string|max:255',
            'nama'        => 'required|string|max:100',
            'deskripsi'   => 'nullable|string',
            'warna_badge' => 'required|string|max:20',
        ]);

        $role->update($validated);

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role)
    {
        // TODO: setelah tabel users punya role_id, tambahkan pengecekan
        // agar role yang masih dipakai user tidak bisa dihapus sembarangan.
        $role->delete();

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Role berhasil dihapus.');
    }
}
