<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = true;
    protected $table = 'usuarios';
    protected $fillable = [
        'tipo', 'nombre', 'email', 'telefono', 'username', 'password', 'disponible'
    ];

    protected $hidden = ['password'];

    // En App\Models\Usuario
        public function esCliente()
        {
            return $this->tipo === 'cliente';
        }

        public function esAgente()
        {
            return $this->tipo === 'agente';
        }

        public function esAdmin()
        {
            return $this->tipo === 'admin';
        }

        public function esSubadmin()
        {
            return $this->tipo === 'subadmin';
        }

    
    // Mutator para encriptar la contraseña antes de guardarla en la BD
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function propiedades()
    {
        return $this->hasMany(Propiedad::class, 'usuario_id');
    }

    public function calificacionesRecibidas()
    {
        return $this->hasMany(Calificacion::class, 'agente_id');
    }

    public function calificacionesHechas()
    {
        return $this->hasMany(Calificacion::class, 'cliente_id');
    }


    public function propiedadesDestacadas()
    {
        return $this->belongsToMany(Propiedad::class, 'destacados');
    }

    public function historialVistas()
    {
        return $this->hasMany(HistorialVista::class);
    }


    public function agentes()
{
    return $this->belongsToMany(Usuario::class, 'subadmin_agente', 'subadmin_id', 'agente_id');
}


public function solicitudesRecibidas()
{
    return $this->hasMany(SolicitudClienteAgente::class, 'agente_id');
}
// Usuario.php
public function solicitudesClienteAgente()
{
    return $this->hasMany(SolicitudClienteAgente::class, 'cliente_id');
}


    public function solicitudesEnviadas()
    {
        return $this->hasMany(SolicitudClienteAgente::class, 'cliente_id');
    }

    public function mensajesEnviados()
    {
        return $this->hasMany(MensajeInteraccion::class, 'emisor_id');
    }

    public function mensajesRecibidos()
    {
        return $this->hasMany(MensajeInteraccion::class, 'receptor_id');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'agente_id');
    }
}


