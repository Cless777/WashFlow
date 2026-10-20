<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    // Menyimpan pesan dari halaman Hubungi Kami
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:30',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string|max:5000',
            'persetujuan_privasi' => 'accepted',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'no_hp.required' => 'Nomor telepon wajib diisi.',
            'subjek.required' => 'Subjek pesan wajib diisi.',
            'pesan.required' => 'Isi pesan wajib diisi.',
            'persetujuan_privasi.accepted' => 'Persetujuan privasi wajib dicentang.',
        ]);

        unset($data['persetujuan_privasi']);

        ContactMessage::create($data);

        return redirect('/#kontak')
            ->with(
                'pesan_terkirim',
                'Pesan berhasil dikirim. Terima kasih telah menghubungi WashFlow!'
            );
    }

    // Menampilkan daftar pesan masuk
    public function index()
    {
        $contactMessages = ContactMessage::latest()->get();

        return view(
            'contact-messages.index',
            compact('contactMessages')
        );
    }

    // Memperbarui status pesan
    public function update(
        Request $request,
        ContactMessage $contactMessage
    ) {
        $data = $request->validate([
            'status' => 'required|in:Baru,Dibaca,Selesai',
        ], [
            'status.required' => 'Status pesan wajib dipilih.',
            'status.in' => 'Status pesan tidak valid.',
        ]);

        $contactMessage->update($data);

        return redirect()
            ->route('contact-messages.index')
            ->with('success', 'Status pesan berhasil diperbarui.');
    }

    // Menghapus pesan masuk
    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()
            ->route('contact-messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
