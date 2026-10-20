<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        // Kalau sudah login, jangan tampilkan form login lagi, langsung ke dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('login');
    }


    /**
     * Proses login: cek email & password ke database.
     */
    public function login(Request $request)
    {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    $remember = $request->boolean('remember');

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect sesuai role
        return match ($user->role->nama) {
            'Kasir' => redirect()->route('kasir.index')
                ->with('success', 'Login berhasil, selamat datang!'),
            'Owner' => redirect()->route('dashboard')
                ->with('success', 'Login berhasil, selamat datang!'),
            default => redirect()->intended(route('dashboard'))
                ->with('success', 'Login berhasil, selamat datang!'),
        };
    }

    return back()
        ->withErrors(['email' => 'Email atau password salah.'])
        ->onlyInput('email');
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Hancurkan session lama, buat token CSRF baru
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('Home')->with('success', 'Anda berhasil logout.');
    }
}
