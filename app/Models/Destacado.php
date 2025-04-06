<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destacado extends Model
{
    protected $table = 'destacados';
    public $timestamps = false;

    protected $fillable = ['usuario_id', 'propiedad_id'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function propiedad()
    {
        return $this->belongsTo(Propiedad::class);
    }
}
