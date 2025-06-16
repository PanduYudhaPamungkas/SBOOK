<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login pengguna.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        return match ($user->role) {
            'pemilik' => redirect()->route('pemilik.dashboard'),
            'pelanggan' => redirect()->route('pelanggan.dashboard'),
            default => redirect('/'),
        };
    }

    /**
     * Logout pengguna dan hapus sesi.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // /**
    //  * Tampilkan halaman reset password (gunakan forgot-password.blade.php).
    //  */
    // public function showResetForm(): View
    // {
    //     return view('auth.forgot-password'); // ← Satu form untuk email + password baru
    // }

    // /**
    //  * Proses reset password lokal (tanpa email).
    //  */
    // public function resetPasswordLokal(Request $request): RedirectResponse
    // {
    //     dd('MASUK FORM', $request->all());
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|min:6|confirmed',
    //     ]);

    //     $user = User::where('email', $request->email)->first();

    //     if (!$user) {
    //         return back()->with('error', 'Email tidak ditemukan.');
    //     }

    //     $user->password = Hash::make($request->password);
    //     $user->save();

    //     return redirect()->route('login')->with('status', 'Password berhasil direset.');
    // }

}
