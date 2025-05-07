<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Calificacion extends Model
{
    protected $table = 'calificaciones';
    public $timestamps = false;

    protected $fillable = ['cliente_id', 'agente_id', 'comentario', 'puntuacion'];

    public function cliente()
    {
        return $this->belongsTo(Usuario::class, 'cliente_id');
    }

    public function agente()
    {
        return $this->belongsTo(Usuario::class, 'agente_id');
    }
}
