<?php

use App\Livewire\Productos\EditarProducto;
use Illuminate\Support\Facades\Route;
use App\Livewire\Productos\CrearProducto;
Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('productos', 'productos')
    ->middleware(['auth', 'verified'])
    ->name('productos');

Route::get('productos/crear', CrearProducto::class)
    ->middleware(['auth', 'verified'])
    ->name('productos.crear');

Route::get('productos/{producto}/editar', EditarProducto::class)
    ->middleware(['auth', 'verified'])
    ->name('productos.editar');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
