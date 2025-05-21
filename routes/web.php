<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Http\Controllers\ColaboradorController;

Route::get('/', fn () => view('welcome'))->name('home');

// Rutas públicas (sin autenticación)

Route::get('/colaboradores', [ColaboradorController::class, 'index'])->name('colaboradores');
Route::get('/buscar-colaborador', [ColaboradorController::class, 'buscarColaborador']);
Route::post('/guardar-resguardo', [ResguardoController::class, 'store']);

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
        Route::get('/tools', fn () => view('herramientas'))->name('herramientas');
    });

    // Rutas solo para usuarios God
    Route::middleware('permission:user_audit')->group(function () {
        Route::get('/user-audit', fn () => view('audit.user'))->name('audit.user');
        Route::get('/activity-logs', fn () => view('audit.logs'))->name('audit.logs');
    });
});
