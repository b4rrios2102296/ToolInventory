<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Permitir archivos sin restricciones
        if (
            $request->is('resguardos/pdf') || $request->is('herramientas/pdf') ||
            $request->is('resguardos/excel') || $request->is('herramientas/excel')
        ) {
            return $next($request);
        }

        // Si el usuario no está autenticado, redirigir a login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Verificar permisos
        if (Auth::check() && Auth::user()->hasPermission($permission)) {
            return $next($request);
        }

        // Si no tiene permiso, redirigir al dashboard
        return redirect()->route('dashboard')
            ->with('error', 'No tienes permiso para acceder a esta sección.');

    }

}