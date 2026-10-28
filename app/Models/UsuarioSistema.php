<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens; // <-- 1. Importa el trait

class UsuarioSistema extends Model
{
    use HasApiTokens; // <-- 2. Agrégalo dentro de la clase

    // Si tu tabla no usa los nombres de columnas estándar de Laravel (id, created_at, updated_at)
    // o tiene una llave primaria personalizada, asegúrate de declararla aquí, por ejemplo:
    // protected $primaryKey = 'Id_usuario';

    // ... el resto de tu código

    protected $table = 'usuarios_sistemas';

    protected $primaryKey = 'Id_usuario';

    protected $fillable = [
        'Tipo_usuario',
        'NombreUno_usuario',
        'NombreDos_usuario',
        'ApellidoDos_usuario',
        'SegundoApellido',
        'Telefono',
        'Email',
        'Contrasena',
        'Direccion',
        'Fecha_nacimiento',
        'Genero',
        'Estatura',
        'Peso',
        'Actividad',
        'Objetivo',
        'Alergia',
        'Dieta',
        'Restricciones',
        'NombreNegocio',
        'Nit',
        'Ciudad',
        'TipoProductos',
        'DescripcionNegocio',
        'Foto',
        'FotoPosicion',
    ];

    protected $hidden = [
        'Contrasena',
    ];

    // Relaciones
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'Id_usuario', 'Id_usuario');
    }

    public function descuentos()
    {
        return $this->hasMany(Descuento::class, 'Id_usuario', 'Id_usuario');
    }

    public function carrito()
    {
        return $this->hasMany(CarritoCompra::class, 'Id_usuario', 'Id_usuario');
    }
}
