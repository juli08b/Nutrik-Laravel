<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioReto extends Model
{
    use HasFactory;

    protected $table = 'usuario_retos';
    protected $primaryKey = 'id_usuario_reto';

    protected $fillable = [
        'id_usuario',
        'id_reto',
        'fecha',
        'completado',
        'completado_en',
        'puntos_obtenidos',
    ];

    protected $casts = [
        'fecha'            => 'date',
        'completado'       => 'boolean',
        'completado_en'    => 'datetime',
        'puntos_obtenidos' => 'integer',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioSistema::class, 'id_usuario', 'id_usuario');
    }

    public function reto()
    {
        return $this->belongsTo(Reto::class, 'id_reto', 'id_reto');
    }
}