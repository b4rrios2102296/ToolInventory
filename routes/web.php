<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\ResguardoController;
use App\Http\Controllers\HerramientaController;
use Illuminate\Contracts\View\View;

Route::get('/', fn(): View => view('welcome'))->name(name: 'home');
Route::get('/test', fn(): View => view('livewire.test'))->name(name: 'test');


// Rutas públicas (sin autenticación)
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');



});

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    // Herramientas
    Route::resource('herramientas', HerramientaController::class)
        ->only(['index', 'create', 'store']);

    // Resguardos
    Route::get('/resguardos/crear', [ResguardoController::class, 'create'])
        ->name('resguardos.create');
    Route::get('/resguardos', [ResguardoController::class, 'index'])
        ->name('resguardos.index');
    Route::post('/resguardos', [ResguardoController::class, 'store'])
        ->name('resguardos.store');
    Route::get('/buscar-colaborador', [ResguardoController::class, 'buscarColaborador'])
        ->name('resguardos.buscar');
        Route::get('/resguardos/{resguardo}/edit', [ResguardoController::class, 'edit'])->name('resguardos.edit');
    // Update
    Route::put('/resguardos/{resguardo}', [ResguardoController::class, 'update'])->name('resguardos.update');
    // Delete
    Route::delete('/resguardos/{resguardo}', [ResguardoController::class, 'destroy'])->name('resguardos.destroy');
    Route::get('/resguardos/{resguardo}', [ResguardoController::class, 'show'])->name('resguardos.show');

    // Colaboradores
    Route::get('/colaboradores', [ColaboradorController::class, 'index'])
        ->name('colaboradores');

    // Dashboard y logout
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::post('/logout', [Login::class, 'logout'])->name('logout');

    // Rutas solo para usuarios admin
    Route::middleware('permission:user_audit')->group(function () {
        Route::get('/user-audit', fn() => view('audit.user'))->name('audit.user');
        Route::get('/register', Register::class)->name('register');
        Route::get('/herramientas/buscar', [HerramientaController::class, 'buscarHerramienta'])->name('herramientas.buscar');
    });
});