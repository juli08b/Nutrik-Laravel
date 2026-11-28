<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $table = 'detalles_compras';
    protected $primaryKey = 'id_detalle';

    protected $fillable = [
        'precio_unitario',
        'subtotal',
        'cantidad',
        'id_pedido',
        'id_producto',
    ];

    protected $casts = [
        'precio_unitario' => 'float',
        'subtotal'        => 'float',
        'cantidad'        => 'integer',
    ];

    // Pertenece a un pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }

    // Pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}