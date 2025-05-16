<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;

Route::get('/', fn () => view('welcome'))->name('home');

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');
    
    Route::post('/logout', [Login::class, 'logout'])->name('logout');
});
