<?php

namespace App\Http\Livewire\Administrador\Producto;

use Livewire\Component;

class ProductoEditarLivewire extends Component
{
    public function render()
    {
        return view('livewire.administrador.producto.producto-editar-livewire')->layout('layouts.administrador.index');
    }
}
