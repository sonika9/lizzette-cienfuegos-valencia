<?php

use App\Livewire\Productos\EditarProducto;
use Illuminate\Support\Facades\Route;
use App\Livewire\Productos\CrearProducto;
use App\Livewire\Tienda\ListaProductos;

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('productos', 'productos')
    ->middleware(['auth', 'verified'])
    ->name('productos');

Route::view('pedidos', 'pedidos')
    ->middleware(['auth', 'verified'])
    ->name('pedidos');

Route::get('productos/crear', CrearProducto::class)
    ->middleware(['auth', 'verified'])
    ->name('productos.crear');

Route::get('productos/{producto}/editar', EditarProducto::class)
    ->middleware(['auth', 'verified'])
    ->name('productos.editar');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/', ListaProductos::class)
    ->name('productos.lista');

require __DIR__.'/auth.php';
