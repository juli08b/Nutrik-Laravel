<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $primaryKey = 'Id_producto';

    protected $fillable = [
        'Nombre_producto',
        'Precio',
        'Id_categoria',
        'Descripcion',
        'Stock',
        'Imagen',
        'Estado',
        'Vendedor',
    ];

    protected $casts = [
        'Precio' => 'float',
        'Stock' => 'integer',
    ];

    // Relación: Un producto pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'Id_categoria', 'Id_categoria');
    }

    // Relación: Un producto puede estar en muchos detalles de compra
    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class, 'Id_producto', 'Id_producto');
    }
}
