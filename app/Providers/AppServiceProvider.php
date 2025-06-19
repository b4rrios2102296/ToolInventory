<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire; // <-- Agrega esta línea

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::component('auth.login', \App\Http\Livewire\Auth\Login::class);
        Livewire::component('auth.register', \App\Http\Livewire\Auth\Register::class);

        
    }
}