<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reto extends Model
{
    use HasFactory;

    protected $table = 'retos';
    protected $primaryKey = 'id_reto';

    protected $fillable = [
        'titulo',
        'descripcion',
        'categoria',
        'icono',
        'puntos',
        'activo',
    ];

    protected $casts = [
        'puntos' => 'integer',
        'activo' => 'boolean',
    ];

    public function usuarioRetos()
    {
        return $this->hasMany(UsuarioReto::class, 'id_reto', 'id_reto');
    }
}