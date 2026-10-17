<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Membatasi akses halaman admin hanya untuk pengguna dengan role "admin".
 * User/siswa yang mencoba membuka URL admin akan mendapat respon 403.
 */
class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isAdmin()) {
            abort(Response::HTTP_FORBIDDEN, 'Halaman ini hanya dapat diakses oleh admin.');
        }

        return $next($request);
    }
}
