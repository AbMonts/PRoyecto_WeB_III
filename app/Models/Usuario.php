<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $fillable = [
        'tipo',
        'nombre',
        'email',
        'telefono',
        'username',
        'password',
    ];

    protected $hidden = ['password'];

    public $timestamps = true;
    
    // Mutator para encriptar la contraseña antes de guardarla en la BD
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function propiedades()
    {
        return $this->hasMany(Propiedad::class, 'usuario_id');
    }

    public function propiedadesDestacadas()
    {
        return $this->belongsToMany(Propiedad::class, 'destacados');
    }



    public function historialVistas()
    {
        return $this->hasMany(HistorialVista::class);
    }

}


