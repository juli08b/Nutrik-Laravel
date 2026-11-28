<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoCompra extends Model
{
    use HasFactory;

    protected $table = 'carrito_compras';
    protected $primaryKey = 'id_carrito';

    protected $fillable = [
        'id_producto',
        'nombre_producto',
        'precio_unitario',
        'imagen',
        'cantidad',
        'id_usuario',
    ];

    protected $casts = [
        'precio_unitario' => 'float',
        'cantidad'        => 'integer',
    ];

    // Un ítem de carrito pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(UsuarioSistema::class, 'id_usuario', 'id_usuario');
    }

    // Un ítem de carrito pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}