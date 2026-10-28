<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $primaryKey = 'Id_categoria';

    protected $fillable = [
        'Nombre_categoria',
        'Descripccion',
        'Tipo_producto',
    ];

    // Relación: Una categoría tiene muchos productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'Id_categoria', 'Id_categoria');
    }
}
