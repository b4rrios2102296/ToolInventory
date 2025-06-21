<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActualizarUltimoAcceso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // app/Http/Middleware/ActualizarUltimoAcceso.php
    public function handle($request, \Closure $next)
    {
        if (auth()->check()) {
            \Log::info('Actualizando acceso para usuario: ' . auth()->user()->nombre_usuario);
            auth()->user()->update(['ultimo_acceso' => now()]);
        }

        return $next($request);
    }


}
