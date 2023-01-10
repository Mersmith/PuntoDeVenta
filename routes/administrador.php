<?php

use App\Http\Livewire\Administrador\Categoria\CategoriaLivewire;
use Illuminate\Support\Facades\Route;

Route::get('prueba-administrador', function () {
    return "Amdministrador";
});

Route::get('categorias', CategoriaLivewire::class)->name('categoria.index');
