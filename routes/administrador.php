<?php

use App\Http\Controllers\Administrador\Ckeditor5Controller;
use App\Http\Livewire\Administrador\Categoria\CategoriaLivewire;
use App\Http\Livewire\Administrador\Producto\ProductoCrearLivewire;
use App\Http\Livewire\Administrador\Producto\ProductoEditarLivewire;
use App\Http\Livewire\Administrador\Producto\ProductoTodoLivewire;
use App\Http\Livewire\Administrador\Proveedor\ProveedorLivewire;
use Illuminate\Support\Facades\Route;

Route::get('prueba-administrador', function () {
    return "Amdministrador";
});

Route::get('categorias', CategoriaLivewire::class)->name('categoria.index');

Route::get('proveedores', ProveedorLivewire::class)->name('proveedor.index');

Route::get('productos', ProductoTodoLivewire::class)->name('producto.index');
Route::get('producto/crear', ProductoCrearLivewire::class)->name('producto.crear');
Route::get('producto/{producto}/editar', ProductoEditarLivewire::class)->name('producto.editar');
Route::post('ckeditor-upload', [Ckeditor5Controller::class, 'upload'])->name('ckeditor.upload');
