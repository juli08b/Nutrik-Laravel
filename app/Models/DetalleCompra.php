<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $table = 'detalle_compras';

    protected $primaryKey = 'Id_Detalle';

    protected $fillable = [
        'Id_pedido',
        'Id_producto',
        'Precio_unitario',
        'Subtotal',
        'Cantidad',
    ];

    // Relación: Pertenece a un pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'Id_pedido', 'Id_pedido');
    }

    // Relación: Pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'Id_producto', 'Id_producto');
    }
}
