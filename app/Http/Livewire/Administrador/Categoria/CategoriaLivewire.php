<?php

namespace App\Http\Livewire\Administrador\Categoria;

use App\Models\Categoria;
use Livewire\Component;
use Illuminate\Support\Str;

class CategoriaLivewire extends Component
{
    public $categorias, $categoria;

    protected $listeners = ['eliminarCategoria'];

    public $crearFormulario = [
        'nombre' => null,
        'slug' => null,
        'descripcion' => null,
    ];

    public $editarFormulario = [
        'abierto' => false,
        'nombre' => null,
        'slug' => null,
        'descripcion' => null,
    ];

    protected $rules = [
        'crearFormulario.nombre' => 'required|unique:categorias,nombre',
        'crearFormulario.slug' => 'required|unique:categorias,slug',
    ];

    protected $validationAttributes = [
        'crearFormulario.nombre' => 'nombre',
        'crearFormulario.slug' => 'slug',
        'crearFormulario.descripcion' => 'descripción',

        'editarFormulario.nombre' => 'nombre',
        'editarFormulario.slug' => 'slug',
        'editarFormulario.descripcion' => 'descripción',
    ];

    protected $messages = [
        'crearFormulario.nombre.required' => 'El :attribute es requerido.',
        'crearFormulario.nombre.unique' => 'El :attribute ya existe.',
        'crearFormulario.slug.required' => 'El :attribute es requerido.',
        'crearFormulario.slug.unique' => 'El :attribute ya existe.',
        'crearFormulario.descripcion.required' => 'La :attribute es requerido.',

        'editarFormulario.nombre.required' => 'El :attribute es requerido.',
        'editarFormulario.nombre.unique' => 'El :attribute ya existe.',
        'editarFormulario.slug.required' => 'El :attribute es requerido.',
        'editarFormulario.slug.unique' => 'El :attribute ya existe.',
        'editarFormulario.descripcion.required' => 'La :attribute es requerido.',
    ];

    public function traerCategorias()
    {
        $this->categorias = Categoria::all();
    }

    public function mount()
    {
        $this->traerCategorias();
    }

    public function updatedCrearFormularioNombre($value)
    {
        $this->crearFormulario['slug'] = Str::slug($value);
    }

    public function updatedEditarFormularioNombre($value)
    {
        $this->editarFormulario['slug'] = Str::slug($value);
    }

    public function crearCategoria()
    {
        $rules = $this->rules;

        if ($this->crearFormulario['descripcion']) {
            $rules['crearFormulario.descripcion'] = 'required';
        }

        $this->validate($rules);

        Categoria::create($this->crearFormulario);

        $this->traerCategorias();

        $this->emit('mensajeCreado', "Creado.");
        $this->reset('crearFormulario');
    }

    public function editarCategoria(Categoria $categoria)
    {
        $this->resetValidation();

        $this->categoria = $categoria;

        $this->editarFormulario['abierto'] = true;
        $this->editarFormulario['nombre'] = $categoria->nombre;
        $this->editarFormulario['slug'] = $categoria->slug;
        $this->editarFormulario['descripcion'] = $categoria->descripcion;
    }

    public function actualizarCategoria()
    {
        $rules = [
            'editarFormulario.nombre' => 'required|unique:categorias,nombre,' . $this->categoria->id,
            'editarFormulario.slug' => 'required|unique:categorias,slug,' . $this->categoria->id,
        ];

        if ($this->editarFormulario['descripcion']) {
            $rules['editarFormulario.descripcion'] = 'required';
        }else{
            $this->editarFormulario['descripcion'] = null;
        }

        $this->validate($rules);

        $this->categoria->update($this->editarFormulario);

        $this->traerCategorias();
        $this->reset('editarFormulario');
        $this->emit('mensajeActualizado', "Actualizado.");
    }

    public function eliminarCategoria(Categoria $categoria)
    {
        $categoria->delete();        
        $this->traerCategorias();
        $this->emit('mensajeEliminado', "Eliminado.");
    }

    public function render()
    {
        return view('livewire.administrador.categoria.categoria-livewire')->layout('layouts.administrador.index');
    }
}
