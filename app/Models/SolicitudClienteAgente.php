<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudClienteAgente extends Model
{
    use HasFactory;

    // App\Models\SolicitudClienteAgente
    protected $table = 'solicitudes_cliente_agente';

    public $timestamps = false;
    
    protected $fillable = [
        'cliente_id',
        'agente_id',
        'propiedad_id',
        'estado',
        'aprobado_por_subadmin',
        'tipo_representacion',
    ];

        // App\Models\SolicitudClienteAgente

    public function cliente()
    {
        return $this->belongsTo(Usuario::class, 'cliente_id');
    }

    public function agente()
    {
        return $this->belongsTo(Usuario::class, 'agente_id');
    }

    public function propiedad()
    {
        return $this->belongsTo(Propiedad::class, 'propiedad_id');
    }

}
