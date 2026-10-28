<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recompensa extends Model
{
    protected $table = 'recompensas';

    protected $primaryKey = 'Id_recompensa';

    protected $fillable = [
        'Nombre',
        'Descripcion',
        'Costo_puntos',
        'Tipo',
        'Valor',
        'Icono',
        'Repetible',
        'Activo',
    ];

    protected $casts = [
        'Costo_puntos' => 'integer',
        'Valor' => 'float',
        'Repetible' => 'boolean',
        'Activo' => 'boolean',
    ];

    public function canjes()
    {
        return $this->hasMany(Canje::class, 'Id_recompensa', 'Id_recompensa');
    }
}
