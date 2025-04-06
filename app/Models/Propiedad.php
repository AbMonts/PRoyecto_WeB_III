<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propiedad extends Model
{
    use HasFactory;

    protected $table = 'propiedades';
    protected $fillable = [
        'tipo', 'direccion', 'referencias', 'descripcion', 'precio',
        'habitaciones', 'banos', 'dimensiones', 'estado', 'garage', 'usuario_id'
    ];

    protected $casts = [
        'garage' => 'boolean',
        'precio' => 'decimal:2'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'propiedad_id');
    }

    public function usuariosQueDestacaron()
    {
        return $this->belongsToMany(Usuario::class, 'destacados');
    }

    public function getTotalDestacadosAttribute()
{
    return $this->usuariosQueDestacaron()->count();
}



    public function historialVistas()
    {
        return $this->hasMany(HistorialVista::class);
    }

}
