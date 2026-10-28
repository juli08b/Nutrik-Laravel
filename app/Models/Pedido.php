<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $primaryKey = 'Id_pedido';

    protected $fillable = [
        'Estado',
        'Fecha_salida',
        'Fecha_Llegada',
        'Id_usuario',
        'Metodo_pago',
        'Subtotal',
        'Costo_envio',
        'Total_pedido',
        'Direccion_envio',
        'Ciudad_envio',
    ];

    // Relación: Un pedido pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(UsuarioSistema::class, 'Id_usuario', 'Id_usuario');
    }

    // Relación: Un pedido tiene muchos detalles de compra
    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class, 'Id_pedido', 'Id_pedido');
    }
}
