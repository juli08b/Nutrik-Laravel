<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    use HasFactory;

    protected $table = 'descuentos';
    protected $primaryKey = 'id_descuento';

    protected $fillable = [
        'valor_descuento',
        'fecha_inicio',
        'fecha_fin',
        'id_usuario',
    ];

    protected $casts = [
        'valor_descuento' => 'float',
        'fecha_inicio'    => 'date',
        'fecha_fin'       => 'date',
    ];

    // Un descuento pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(UsuarioSistema::class, 'id_usuario', 'id_usuario');
    }
}