<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renta extends Model
{
    use HasFactory;

    protected $table = 'rentas';
    public $timestamps = false;

    protected $fillable = [
        'propiedad_id',
        'agente_id',
        'cliente_id',
        'precio_mensual',
        'fecha_inicio',
        'fecha_fin'
    ];

    public function propiedad()
    {
        return $this->belongsTo(Propiedad::class, 'propiedad_id');
    }

    public function agente()
    {
        return $this->belongsTo(Usuario::class, 'agente_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Usuario::class, 'cliente_id');
    }
}
