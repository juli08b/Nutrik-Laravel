<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioLogro extends Model
{
    use HasFactory;

    protected $table = 'usuario_logros';
    protected $primaryKey = 'id_usuario_logro';

    protected $fillable = [
        'id_usuario',
        'id_logro',
        'desbloqueado_en',
    ];

    protected $casts = [
        'desbloqueado_en' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioSistema::class, 'id_usuario', 'id_usuario');
    }

    public function logro()
    {
        return $this->belongsTo(Logro::class, 'id_logro', 'id_logro');
    }
}