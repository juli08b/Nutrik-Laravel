<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioRacha extends Model
{
    protected $table = 'usuario_rachas';

    protected $primaryKey = 'Id_racha';

    protected $fillable = [
        'Id_usuario',
        'Racha_actual',
        'Mejor_racha',
        'Dias_completados',
        'Ultima_fecha',
    ];

    protected $casts = [
        'Racha_actual' => 'integer',
        'Mejor_racha' => 'integer',
        'Dias_completados' => 'integer',
        'Ultima_fecha' => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioSistema::class, 'Id_usuario', 'Id_usuario');
    }
}
