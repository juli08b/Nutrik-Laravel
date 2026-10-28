<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioLogro extends Model
{
    protected $table = 'usuario_logros';

    protected $primaryKey = 'Id_usuario_logro';

    protected $fillable = [
        'Id_usuario',
        'Id_logro',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioSistema::class, 'Id_usuario', 'Id_usuario');
    }

    public function logro()
    {
        return $this->belongsTo(Logro::class, 'Id_logro', 'Id_logro');
    }
}
