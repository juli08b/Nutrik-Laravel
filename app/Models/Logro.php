<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logro extends Model
{
    use HasFactory;

    protected $table = 'logros';
    protected $primaryKey = 'id_logro';

    protected $fillable = [
        'nombre',
        'descripcion',
        'icono',
        'tipo',
        'condicion',
        'meta',
    ];

    protected $casts = [
        'meta' => 'integer',
    ];

    public function usuarios()
    {
        return $this->hasMany(UsuarioLogro::class, 'id_logro', 'id_logro');
    }
}