<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $table = 'contactos';

    protected $primaryKey = 'Id_contacto';

    protected $fillable = [
        'Nombre',
        'Email',
        'Tipo_solicitud',
        'Asunto',
        'Mensaje',
    ];
}
