<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    use HasFactory;

    protected $table = 'descuentos';

    protected $primaryKey = 'Id_descuento';

    protected $fillable = [
        'Valor_descuento',
        'Fecha_inicio',
        'Fecha_fin',
        'Id_usuario',
    ];

    // Relación: Un descuento pertenece a un usuario
    public function usuario()
    {
        return $this->belongsTo(UsuarioSistema::class, 'Id_usuario', 'Id_usuario');
    }
}
