<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'admin') return redirect()->route('admin.dashboard');
            if ($role === 'bk') return redirect()->route('bk.dashboard');
            return redirect()->route('siswa.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        // Coba login dengan username
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            if ($role === 'admin') return redirect()->route('admin.dashboard')->with('login_success', true);
            if ($role === 'bk') return redirect()->route('bk.dashboard')->with('login_success', true);
            return redirect()->route('siswa.dashboard')->with('login_success', true);
        }

        // Coba login dengan email (fallback)
        if (Auth::attempt(['email' => $credentials['username'], 'password' => $credentials['password']], $remember)) {
            $request->session()->regenerate();
            $role = Auth::user()->role;
            if ($role === 'admin') return redirect()->route('admin.dashboard')->with('login_success', true);
            if ($role === 'bk') return redirect()->route('bk.dashboard')->with('login_success', true);
            return redirect()->route('siswa.dashboard')->with('login_success', true);
        }

        return back()
            ->withErrors(['username' => 'Username atau password tidak valid.'])
            ->withInput($request->only('username'));
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
