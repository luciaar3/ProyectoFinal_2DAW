<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Comprobamos si el usuario está autenticado y si su rol es admin
        if (Auth::check() && Auth::user()->rol === 'Admin') {
            return $next($request);
        }

        // Si no es admin, lo mandamos al dashboard o al home con un error
        return redirect('/account');
    }
}
