<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;


class Propiedad extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'propiedades';

    protected $fillable = [
        'tipo', 'direccion', 'referencias', 'descripcion',
        'precio', 'habitaciones', 'banos', 'dimensiones',
        'estado', 'garage', 'usuario_id', 'documentos', 'vistas'
    ];
    
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    
    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'propiedad_id');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'propiedad_id');
    }

    public function rentas()
    {
        return $this->hasMany(Renta::class, 'propiedad_id');
    }
    
    public function agente()
    {
        return $this->belongsTo(Usuario::class, 'agente_id');
    }



    
    protected $casts = [
        'garage' => 'boolean',
        'precio' => 'decimal:2'
    ];

   

    public function mensajes()
    {
        return $this->hasMany(MensajeInteraccion::class);
    }

   

    public function usuariosQueDestacaron()
    {
        return $this->belongsToMany(Usuario::class, 'destacados');
    }

    public function getTotalDestacadosAttribute()
    {
        return $this->usuariosQueDestacaron()->count();
    }

    public function destacadaPor() {
        return $this->belongsToMany(Usuario::class, 'destacados', 'propiedad_id', 'usuario_id');
    }
    

    public function historialVistas()
    {
        return $this->hasMany(HistorialVista::class);
    }

}
