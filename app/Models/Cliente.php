<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'nombre',
        'apellido',
        'dni',
        'ruc',
        'email',
        'celular',
        'direccion'
    ];

    public function imagen()
    {
        return $this->morphOne(Imagen::class, "imagenable");
    }

    public function ordenes()
    {
        return $this->hasMany(Orden::class);
    }
}
