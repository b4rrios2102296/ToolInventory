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
        // If user is not authenticated, redirect to login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user has the required permission
        if (Auth::user()->hasPermission($permission)) {
            return $next($request);
        }

        // If no permission, redirect to dashboard with error
        return redirect()->route('dashboard')
               ->with('error', 'No tienes permiso para acceder a esta sección.');
    }
}