<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = Auth::user();

    // Cek apakah user memiliki role
    if ($user->hasRole('Admin')) {
        return redirect('/admin');
    } elseif ($user->hasRole('KepalaSekolah')) {
        return redirect()->route('kepsek.index');
    } elseif ($user->hasRole('Guru')) {
        return redirect()->route('guru.index');
    } elseif ($user->hasRole('Siswa')) {
        return redirect()->route('siswa.index');
    }

    // Jika tidak memiliki role
    Auth::logout(); // Logout user
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('status', 'Login gagal: Anda tidak memiliki hak akses.');
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
