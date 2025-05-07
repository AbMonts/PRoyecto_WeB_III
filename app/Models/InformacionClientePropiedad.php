<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class InformacionClientePropiedad extends Model
{
    protected $table = 'informacion_cliente_propiedad';

    protected $fillable = [
        'cliente_id',
        'propiedad_id',
        'ine_url',
        'comprobante_ingresos_url',
        'rfc',
        'ocupacion',
        'otros',
    ];
}
