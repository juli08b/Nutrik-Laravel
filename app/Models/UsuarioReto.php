<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioReto extends Model
{
    protected $table = 'usuario_retos';

    protected $primaryKey = 'Id_usuario_reto';

    protected $fillable = [
        'Id_usuario',
        'Id_reto',
        'Fecha',
        'Completado',
        'Completado_en',
        'Puntos_obtenidos',
    ];

    protected $casts = [
        'Fecha' => 'date',
        'Completado' => 'boolean',
        'Completado_en' => 'datetime',
        'Puntos_obtenidos' => 'integer',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioSistema::class, 'Id_usuario', 'Id_usuario');
    }

    public function reto()
    {
        return $this->belongsTo(Reto::class, 'Id_reto', 'Id_reto');
    }
}
