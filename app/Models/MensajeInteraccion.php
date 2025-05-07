<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensajeInteraccion extends Model
{
    protected $table = 'mensajes_interaccion';

    protected $fillable = [
        'emisor_id',
        'receptor_id',
        'propiedad_id',
        'mensaje',
        'leido',
        'enviado_en', // Incluye el campo para que Eloquent lo reconozca
    ];

    public $timestamps = false; // Ya que no estás usando created_at/updated_at de Laravel

    protected $casts = [
        'leido' => 'boolean',
        'enviado_en' => 'datetime', // Puedes usarlo como objeto Carbon
    ];

    public function emisor()
{
    return $this->belongsTo(Usuario::class, 'emisor_id');
}

public function receptor()
{
    return $this->belongsTo(Usuario::class, 'receptor_id');
}

public function propiedad()
{
    return $this->belongsTo(Propiedad::class);
}
}
