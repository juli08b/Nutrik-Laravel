<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recompensa extends Model
{
    use HasFactory;

    protected $table = 'recompensas';
    protected $primaryKey = 'id_recompensa';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'costo_puntos',
        'valor',
        'repetible',
        'activo',
    ];

    protected $casts = [
        'costo_puntos' => 'integer',
        'valor'        => 'float',
        'repetible'    => 'boolean',
        'activo'       => 'boolean',
    ];

    public function canjes()
    {
        return $this->hasMany(Canje::class, 'id_recompensa', 'id_recompensa');
    }
}