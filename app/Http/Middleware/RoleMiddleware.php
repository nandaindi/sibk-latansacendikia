<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        if (! Auth::user()->hasRole($role)) {
            $userRole = Auth::user()->getRoleNames()->first();
            
            if ($userRole === 'admin') {
                return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak! Anda tidak dapat mengakses halaman tersebut.');
            } elseif ($userRole === 'bk') {
                return redirect()->route('bk.dashboard')->with('error', 'Akses ditolak! Anda tidak dapat mengakses halaman tersebut.');
            } elseif ($userRole === 'siswa') {
                return redirect()->route('siswa.dashboard')->with('error', 'Akses ditolak! Anda tidak dapat mengakses halaman tersebut.');
            }

            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
