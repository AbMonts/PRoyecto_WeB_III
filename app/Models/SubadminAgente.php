<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Usuario;


class SubadminAgente extends Model
{
    protected $table = 'subadmin_agente';
    public $timestamps = false;

    protected $fillable = ['subadmin_id', 'agente_id'];

    public function subadmin()
    {
        return $this->belongsTo(Usuario::class, 'subadmin_id');
    }

    public function agente()
    {
        return $this->belongsTo(Usuario::class, 'agente_id');
    }
}
