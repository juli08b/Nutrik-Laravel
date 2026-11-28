<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoPunto extends Model
{
    use HasFactory;

    protected $table = 'movimientos_puntos';
    protected $primaryKey = 'id_movimiento';

    protected $fillable = [
        'id_usuario',
        'puntos',
        'concepto',
        'referencia',
    ];

    protected $casts = [
        'puntos' => 'integer',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioSistema::class, 'id_usuario', 'id_usuario');
    }
}