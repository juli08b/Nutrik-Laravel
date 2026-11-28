<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioRacha extends Model
{
    use HasFactory;

    protected $table = 'usuario_rachas';
    protected $primaryKey = 'id_racha';

    protected $fillable = [
        'id_usuario',
        'racha_actual',
        'mejor_racha',
        'dias_completados',
        'ultima_fecha',
    ];

    protected $casts = [
        'racha_actual'     => 'integer',
        'mejor_racha'      => 'integer',
        'dias_completados' => 'integer',
        'ultima_fecha'     => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioSistema::class, 'id_usuario', 'id_usuario');
    }
}