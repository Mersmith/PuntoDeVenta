<?php

namespace App\Http\Livewire\Administrador\Producto;

use Livewire\Component;

class ProductoTodoLivewire extends Component
{
    public function render()
    {
        return view('livewire.administrador.producto.producto-todo-livewire')->layout('layouts.administrador.index');
    }
}
