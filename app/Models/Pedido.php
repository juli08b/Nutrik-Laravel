<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';

    protected $fillable = [
        'estado',
        'fecha_salida',
        'fecha_llegada',
        'metodo_pago',
        'subtotal',
        'costo_envio',
        'total',
        'direccion_envio',
        'ciudad_envio',
        'id_usuario',
    ];

    protected $casts = [
        'fecha_salida'  => 'date',
        'fecha_llegada' => 'date',
        'subtotal'      => 'float',
        'costo_envio'   => 'float',
        'total'         => 'float',
    ];

    // Pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(UsuarioSistema::class, 'id_usuario', 'id_usuario');
    }

    // Un pedido tiene muchos detalles de compra
    public function detallesCompra()
    {
        return $this->hasMany(DetalleCompra::class, 'id_pedido', 'id_pedido');
    }
}