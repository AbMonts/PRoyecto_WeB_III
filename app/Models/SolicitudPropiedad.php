<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;


class SolicitudPropiedad extends Model
{
    protected $table = 'solicitudes_propiedades';

    protected $fillable = [
        'cliente_id', 'tipo', 'direccion', 'referencias', 'descripcion',
        'precio', 'habitaciones', 'banos', 'dimensiones', 'estado',
        'garage', 'documentos', 'estado_solicitud', 'mensaje_admin',
        'editable', 'admin_id'
    ];

    protected $casts = [
        'garage' => 'boolean',
        'precio' => 'decimal:2',
        'editable' => 'boolean',
    ];

    public function cliente()
    {
        return $this->belongsTo(Usuario::class, 'cliente_id');
    }

    public function admin()
    {
        return $this->belongsTo(Usuario::class, 'admin_id');
    }
}
