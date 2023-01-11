<?php

use App\Http\Livewire\Administrador\Categoria\CategoriaLivewire;
use App\Http\Livewire\Administrador\Proveedor\ProveedorLivewire;
use Illuminate\Support\Facades\Route;

Route::get('prueba-administrador', function () {
    return "Amdministrador";
});

Route::get('categorias', CategoriaLivewire::class)->name('categoria.index');

Route::get('proveedores', ProveedorLivewire::class)->name('proveedor.index');
