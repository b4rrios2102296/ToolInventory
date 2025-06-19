<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\ResguardoController;
use App\Http\Controllers\HerramientaController;
use App\Http\Controllers\UserActionsController;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\UserActionsPDFController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserEditorController;

Route::get('/', fn(): View => view('welcome'))->name('home');
Route::get('/test', fn(): View => view('livewire.test'))->name('test');

// Rutas públicas (sin autenticación)
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    // Herramientas
    Route::get('/resguardos/pdf', [ResguardoController::class, 'generarPDF'])->name('resguardos.pdf');
    Route::get('/resguardo/{folio}/pdf', [ResguardoController::class, 'viewPDF'])->name('resguardo.pdf');
    Route::get('/resguardos/excel', [ResguardoController::class, 'generarExcel'])->name('resguardos.excel');
    Route::get('/herramientas/pdf', [HerramientaController::class, 'generarPDF'])->name('herramientas.pdf');
    Route::get('/herramientas/excel', [HerramientaController::class, 'generarExcel'])->name('herramientas.excel');
    Route::get('/herramientas', [HerramientaController::class, 'index'])->name('herramientas.index');
    Route::get('/resguardos/{folio}/pdf', [ResguardoController::class, 'viewPDF'])
        ->name('resguardos.viewPDF');
    // Exportaciones para todos los usuarios autenticados
    Route::resource('herramientas', HerramientaController::class)->only(['index', 'create', 'store']);
    Route::get('/herramientas/buscar', [HerramientaController::class, 'buscarHerramienta'])->name('herramientas.buscar');
    Route::get('/herramientas/{herramienta}/edit', [HerramientaController::class, 'edit'])->name('herramientas.edit');
    Route::put('/herramientas/{herramienta}', [HerramientaController::class, 'update'])->name('herramientas.update');
    Route::get('/herramientas/{herramienta}', [HerramientaController::class, 'show'])->name('herramientas.show');
    Route::patch('/herramientas/{id}/baja', [HerramientaController::class, 'baja'])->name('herramientas.baja');


    // Resguardos
    Route::get('/resguardos/crear', [ResguardoController::class, 'create'])->name('resguardos.create');
    Route::get('/resguardos', [ResguardoController::class, 'index'])->name('resguardos.index');
    Route::post('/resguardos', [ResguardoController::class, 'store'])->name('resguardos.store');
    Route::get('/buscar-colaborador', [ResguardoController::class, 'buscarColaborador'])->name('resguardos.buscar');
    Route::get('/resguardos/{resguardo}/edit', [ResguardoController::class, 'edit'])->name('resguardos.edit');
    Route::put('/resguardos/{resguardo}', [ResguardoController::class, 'update'])->name('resguardos.update');
    Route::patch('/resguardos/{resguardo}/cancel', [ResguardoController::class, 'cancel'])->name('resguardos.cancel');
    Route::get('/resguardos/{resguardo}', [ResguardoController::class, 'show'])->name('resguardos.show');
    Route::patch('/resguardos/{folio}/change-status', [ResguardoController::class, 'changeStatus'])
        ->name('resguardos.change-status');




    // Colaboradores
    Route::get('/colaboradores', [ColaboradorController::class, 'index'])->name('colaboradores');

    // Dashboard y logout
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [Login::class, 'logout'])->name('logout');

    // Rutas solo para administradores
    Route::middleware(['auth', 'check.permission:user_audit'])->group(function () {
        Route::get('/user-audit', [UserActionsController::class, 'index']);

        Route::prefix('admin')->group(function () {
            Route::get('/user-editor', [UserEditorController::class, 'index'])
                ->name('admin.user-editor');

            Route::put('/user-editor/update/{usuario}', [UserEditorController::class, 'update'])
                ->name('admin.user-update');
        });


        Route::get('/acciones', [UserActionsController::class, 'index'])->name('acciones');
        Route::get('/register', Register::class)->name('register');
        Route::delete('/resguardos/{folio}', [ResguardoController::class, 'destroy'])->name('resguardos.delete');
        Route::delete('/herramientas/{id}', [HerramientaController::class, 'destroy'])->name('herramientas.delete');
        Route::get('/acciones/export', [UserActionsController::class, 'export'])->name('acciones.excel');
        Route::get('/acciones/pdf', [UserActionsController::class, 'exportPDF'])->name('acciones.pdf');
    });
});
