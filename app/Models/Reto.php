<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reto extends Model
{
    protected $table = 'retos';

    protected $primaryKey = 'Id_reto';

    protected $fillable = [
        'Nombre',
        'Descripcion',
        'Categoria',
        'Icono',
        'Puntos',
        'Activo',
    ];

    protected $casts = [
        'Puntos' => 'integer',
        'Activo' => 'boolean',
    ];

    public function usuarioRetos()
    {
        return $this->hasMany(UsuarioReto::class, 'Id_reto', 'Id_reto');
    }
}
