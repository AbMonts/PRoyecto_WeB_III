<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialVista extends Model
{
    protected $table = 'historial_vistas';
    public $timestamps = false;

    protected $fillable = ['usuario_id', 'propiedad_id', 'visto_en'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function propiedad()
    {
        return $this->belongsTo(Propiedad::class);
    }
}
