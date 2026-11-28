<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $primaryKey = 'id_producto';

    protected $fillable = [
        'nombre_producto',
        'precio',
        'id_categoria',
        'descripcion',
        'stock',
        'imagen',
        'estado',
        'vendedor',
    ];

    protected $casts = [
        'precio' => 'float',
        'stock'  => 'integer',
    ];

    // Pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    // Un producto puede estar en muchos detalles de compra
    public function detallesCompras()
    {
        return $this->hasMany(DetalleCompra::class, 'id_producto', 'id_producto');
    }
}