<?php

namespace App\Http\Middleware;

use App\Models\User;
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
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // Autentikasi default di environment lokal untuk preview browser jika sesi belum terbentuk
        if (! $user && app()->environment('local') && ! app()->runningUnitTests()) {
            $user = User::whereIn('role', $roles)->first() ?? User::first();
            if ($user) {
                Auth::setUser($user);
            }
        }

        if (! $user || ! in_array($user->role, $roles, true)) {
            abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
