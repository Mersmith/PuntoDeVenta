<?php

namespace App\Http\Livewire\Administrador\Producto;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ProductoCrearLivewire extends Component
{
    use WithFileUploads;

    protected $listeners = ['cambiarPosicionImagenes'];

    public $categorias, $proveedores, $imagenes = [];

    public $categoria_id = "",  $proveedor_id = "";

    public
        $nombre = null,
        $slug = null,
        $sku = null,
        $precio_venta = 1,
        $precio_real = 1,
        $stock_total = 0,
        $descripcion = null,
        $informacion = null,
        $puntos_ganar = 0,
        $link_video = null,
        $incluye_igv = false,
        $tiene_detalle = false,
        $detalle = null,
        $estado = 1;

    protected $rules = [
        'categoria_id' => 'required',
        'proveedor_id' => 'required',
        'nombre' => 'required',
        'slug' => 'required|unique:productos',
        'sku' => 'required|unique:productos',
        'precio_venta' => 'required',
        'precio_real' => 'required',
        'stock_total' => 'required',
        'descripcion' => 'required',
        'informacion' => 'required',
        'puntos_ganar' => 'required',
        'incluye_igv' => 'required',
        'tiene_detalle' => 'required',
        'estado' => 'required',
        'imagenes' => 'required',
    ];

    protected $validationAttributes = [
        'categoria_id' => 'categoria',
        'proveedor_id' => 'proveedor',
        'nombre' => 'nombre',
        'slug' => 'slug',
        'sku' => 'sku',
        'precio_venta' => 'precio de venta',
        'precio_real' => 'precio real',
        'stock_total' => 'stock',
        'descripcion' => 'descripción',
        'informacion' => 'información',
        'puntos_ganar' => 'puntos a ganar',
        'link_video' => 'iframe del video',
        'tiene_detalle' => 'detalle',
        'detalle' => 'detalle',
        'incluye_igv' => 'igv',
        'estado' => 'estado',
        'imagenes' => 'imagenes',
    ];

    protected $messages = [
        'categoria_id.required' => 'La :attribute es requerido.',
        'proveedor_id.required' => 'El :attribute es requerido.',
        'nombre.required' => 'El :attribute es requerido.',
        'slug.required' => 'El :attribute es requerido.',
        'sku.required' => 'El :attribute es requerido.',
        'precio_venta.required' => 'El :attribute es requerido.',
        'precio_real.required' => 'El :attribute es requerido.',
        'stock_total.required' => 'El :attribute es requerido.',
        'descripcion.required' => 'La :attribute es requerido.',
        'informacion.required' => 'La :attribute es requerido.',
        'puntos_ganar.required' => 'Los :attribute es requerido.',
        'link_video.required' => 'El :attribute es requerido.',
        'tiene_detalle.required' => 'El :attribute es requerido.',
        'detalle.required' => 'El :attribute es requerido.',
        'incluye_igv.required' => 'El :attribute es requerido.',
        'estado.required' => 'El :attribute es requerido.',
        'imagenes.required' => 'Las :attribute son requerido.',
    ];

    public function mount()
    {
        $this->categorias = Categoria::all();
        $this->proveedores = Proveedor::all();
    }

    public function updatedNombre($value)
    {
        $this->slug = Str::slug($value);
        $this->sku = trim(mb_strtoupper(mb_substr($value, 0, 2)) . "-" . "S" . rand(1, 500) . strtoupper(mb_substr($value, -2)));
    }

    public function updatedPrecioReal($value)
    {
        $this->precio_venta = $value;
    }

    public function eliminarImagen($index)
    {
        array_splice($this->imagenes, $index, 1);
    }

    public function cambiarPosicionImagenes($sorts)
    {
        $sorted = [];

        foreach ($sorts as  $position) {
            $existe = $this->imagenes[$position];
            array_push($sorted, $existe);
        }

        $this->imagenes = $sorted;
    }

    public function crearProducto()
    {
        $rules = $this->rules;

        if ($this->tiene_detalle) {
            $rules['detalle'] = 'required';
        } else {
            $this->detalle = null;
        }

        if ($this->link_video) {
            $rules['link_video'] = 'required';
        } else {
            $this->link_video = null;
        }

        $this->validate($rules);

        $producto = new Producto();

        $producto->categoria_id  = $this->categoria_id;
        $producto->proveedor_id  = $this->proveedor_id;
        $producto->nombre = $this->nombre;
        $producto->slug = $this->slug;
        $producto->sku = $this->sku;
        $producto->precio_venta = $this->precio_venta;
        $producto->precio_real = $this->precio_real;
        $producto->descripcion = $this->descripcion;
        $producto->informacion = $this->informacion;
        $producto->puntos_ganar = $this->puntos_ganar;
        $producto->link_video = $this->link_video;
        $producto->incluye_igv = $this->incluye_igv;
        $producto->tiene_detalle = $this->tiene_detalle;
        $producto->detalle = $this->detalle;
        $producto->estado  = $this->estado;

        $producto->save();

        foreach ($this->imagenes as $key => $imagen) {
            $urlImagen = Storage::put('productos', $imagen);

            $producto->imagenes()->create([
                'imagen_ruta' => $urlImagen,
                'posicion' => $key + 1,
            ]);
        }

        $re_extractImages = '/src=["\']([^ ^"^\']*)["\']/ims';

        if ($re_extractImages) {
            preg_match_all($re_extractImages, $this->informacion, $matches);
            $imagenesCkeditors = $matches[1];

            foreach ($imagenesCkeditors as  $imgckeditor) {
                $urlImagenCkeditor = 'ckeditor/' . pathinfo($imgckeditor, PATHINFO_BASENAME);

                $producto->ckeditors()->create([
                    'imagen_ruta' => $urlImagenCkeditor
                ]);
            }
        }

        $this->emit('mensajeCreado', "Creado.");

        return redirect()->route('administrador.producto.editar', $producto);
    }

    public function render()
    {
        return view('livewire.administrador.producto.producto-crear-livewire')->layout('layouts.administrador.index');
    }
}
