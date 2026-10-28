<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoCompra extends Model
{
    use HasFactory;

    protected $table = 'carrito_compras';

    protected $primaryKey = 'Id_carrite';

    protected $fillable = [
        'Id_producto',
        'Nombre_producto',
        'Precio_unitario',
        'Imagen',
        'Cantidad',
        'Total',
        'Id_usuario',
    ];

    // Relación: Un ítem de carrito pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(UsuarioSistema::class, 'Id_usuario', 'Id_usuario');
    }
}
