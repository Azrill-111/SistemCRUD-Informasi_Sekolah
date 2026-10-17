<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Satu halaman login untuk admin maupun user/siswa.
 */
class LoginController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login lalu arahkan sesuai role pengguna.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ]);
        }

        // Cegah session fixation setelah login berhasil.
        $request->session()->regenerate();

        // Sesuai ketentuan: admin diarahkan ke Dashboard Admin,
        // user/siswa diarahkan ke Halaman Informasi.
        return redirect()
            ->to($this->homeFor($request->user()))
            ->with('status', 'Selamat datang, '.$request->user()->name.'.');
    }

    /**
     * Proses logout pengguna.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Anda telah keluar dari sistem.');
    }

    /**
     * Halaman utama berdasarkan role.
     */
    private function homeFor(?User $user): string
    {
        return $user?->isAdmin()
            ? route('admin.dashboard')
            : route('informasi.index');
    }
}
