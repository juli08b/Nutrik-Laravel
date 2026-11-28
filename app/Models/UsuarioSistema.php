<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class UsuarioSistema extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'usuarios_sistemas';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'tipo_usuario',
        'nombre_usuario',
        'apellidos_usuario',
        'email',
        'telefono',
        'contrasena',
        'direccion',
        'ciudad',
        'genero',
        'alergias',
        'dieta',
        'objetivo_salud',
        'nivel_actividad',
        'tipo_productos',
        'nombre_tienda',
        'horario_atencion',
        'razon_social',
        'rubro',
        'foto',
        'fotoPosition',
    ];

    protected $hidden = [
        'contrasena',
    ];

    // Relaciones
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_usuario', 'id_usuario');
    }

    public function descuentos()
    {
        return $this->hasMany(Descuento::class, 'id_usuario', 'id_usuario');
    }

    public function carritos()
    {
        return $this->hasMany(CarritoCompra::class, 'id_usuario', 'id_usuario');
    }

    public function esAdmin(): bool
    {
        return in_array(strtolower((string) $this->tipo_usuario), ['admin', 'administrador'], true);
    }
}