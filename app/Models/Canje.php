<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Canje extends Model
{
    protected $table = 'canjes';

    protected $primaryKey = 'Id_canje';

    protected $fillable = [
        'Id_usuario',
        'Id_recompensa',
        'Puntos_usados',
        'Estado',
        'Fecha',
    ];

    protected $casts = [
        'Puntos_usados' => 'integer',
        'Fecha' => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioSistema::class, 'Id_usuario', 'Id_usuario');
    }

    public function recompensa()
    {
        return $this->belongsTo(Recompensa::class, 'Id_recompensa', 'Id_recompensa');
    }
}
