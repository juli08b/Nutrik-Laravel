<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logro extends Model
{
    protected $table = 'logros';

    protected $primaryKey = 'Id_logro';

    protected $fillable = [
        'Nombre',
        'Descripcion',
        'Icono',
        'Condicion',
        'Meta',
    ];

    protected $casts = [
        'Meta' => 'integer',
    ];

    public function usuarioLogros()
    {
        return $this->hasMany(UsuarioLogro::class, 'Id_logro', 'Id_logro');
    }
}
