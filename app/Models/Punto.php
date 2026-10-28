<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Punto extends Model
{
    protected $table = 'puntos';

    protected $primaryKey = 'Id_punto';

    protected $fillable = [
        'Id_usuario',
        'Cantidad',
        'Motivo',
        'Origen',
        'Referencia',
    ];

    protected $casts = [
        'Cantidad' => 'integer',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioSistema::class, 'Id_usuario', 'Id_usuario');
    }
}
