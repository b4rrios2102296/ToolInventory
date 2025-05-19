<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;

Route::get('/', fn () => view('welcome'))->name('home');

// Rutas para invitados (no autenticados)
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    Route::post('/logout', [Login::class, 'logout'])->name('logout');
    
    // Rutas para usuarios normales
    Route::middleware('permission:basic_access')->group(function () {
        Route::get('/tools', fn () => view('tools.index'))->name('tools.index');
        // Add more normal user routes here
    });
    
    // Rutas solo para usuarios God
    Route::middleware('permission:user_audit')->group(function () {
        Route::get('/user-audit', fn () => view('audit.user'))->name('audit.user');
        Route::get('/activity-logs', fn () => view('audit.logs'))->name('audit.logs');
        // Add more admin-only routes here
    });
});