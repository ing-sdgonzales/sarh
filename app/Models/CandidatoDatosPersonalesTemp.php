<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatoDatosPersonalesTemp extends Model
{
    use HasFactory;

    protected $table = 'candidatos_datos_personales_temp';
    protected $fillable = [
        'imagen', 'dpi', 'nit', 'igss', 'nombre', 'email', 'fecha_nacimiento', 'telefono', 'direccion',
        'estados_civiles_id', 'municipios_id'
    ];
}
