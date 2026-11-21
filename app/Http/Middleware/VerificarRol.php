<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarRol
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $rolRequerido): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $rolUsuario = $request->user()->rol ?? 'cliente';

        if ($rolUsuario !== $rolRequerido) {
            if ($rolUsuario === 'admin') {
                return redirect()->route('admin.pedidos.index');
            }

            return redirect()->route('catalogo.index');
        }

        return $next($request);
    }
}
