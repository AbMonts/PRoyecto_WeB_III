<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Venta extends Model
{
    protected $table = 'ventas';
    public $timestamps = false;

    protected $fillable = ['propiedad_id', 'agente_id', 'cliente_id', 'precio_final'];

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
