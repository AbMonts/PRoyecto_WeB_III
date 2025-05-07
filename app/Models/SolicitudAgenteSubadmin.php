<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
class SolicitudAgenteSubadmin extends Model
{
    protected $table = 'solicitudes_agente_subadmin';
    public $timestamps = false;

    protected $fillable = ['agente_id', 'propiedad_id', 'tipo_solicitud', 'estado'];

    public function agente()
    {
        return $this->belongsTo(Usuario::class, 'agente_id');
    }

    public function propiedad()
    {
        return $this->belongsTo(Propiedad::class);
    }
}
