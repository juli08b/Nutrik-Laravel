<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canje extends Model
{
    use HasFactory;

    protected $table = 'canjes';
    protected $primaryKey = 'id_canje';

    protected $fillable = [
        'id_usuario',
        'id_recompensa',
        'puntos_usados',
        'estado',
        'fecha',
    ];

    protected $casts = [
        'puntos_usados' => 'integer',
        'fecha'         => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioSistema::class, 'id_usuario', 'id_usuario');
    }

    public function recompensa()
    {
        return $this->belongsTo(Recompensa::class, 'id_recompensa', 'id_recompensa');
    }
}