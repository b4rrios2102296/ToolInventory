<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\ResguardoController;
use App\Http\Controllers\HerramientaController;
use Illuminate\Contracts\View\View;

Route::get('/', fn(): View => view('welcome'))->name('home');

// Rutas públicas (sin autenticación)
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    // Herramientas (accesibles para todos los autenticados)
    Route::get('/herramientas', [HerramientaController::class, 'index'])->name('herramientas');
    Route::post('/herramientas', [HerramientaController::class, 'store'])->name('herramientas.store');
    Route::get('/herramientas/crear', [HerramientaController::class, 'create'])->name('herramientas.create');

    // Resguardos (accesibles para todos los autenticados)
    Route::get('/resguardos/crear', [ResguardoController::class, 'create'])->name('resguardos.create');
    Route::get('/resguardos', [ResguardoController::class, 'index'])->name('resguardos');
    Route::post('/resguardos', [ResguardoController::class, 'store'])->name('resguardos.store');
    Route::get('/buscar-colaborador', [ResguardoController::class, 'buscarColaborador']);

    // Colaboradores
    Route::get('/colaboradores', [ColaboradorController::class, 'index'])->name('colaboradores');
    Route::get('/buscar-colaborador', [ColaboradorController::class, 'buscarColaborador']);
    Route::post('/guardar-resguardo', [ResguardoController::class, 'store']);

    // Dashboard y logout
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::post('/logout', [Login::class, 'logout'])->name('logout');

    // Rutas solo para usuarios admin (God)
    Route::middleware('permission:user_audit')->group(function () {
        Route::get('/user-audit', fn() => view('audit.user'))->name('audit.user');
        Route::get('/activity-logs', fn() => view('audit.logs'))->name('audit.logs');
        Route::get('/register', action: Register::class)->name('register');

    });
});
