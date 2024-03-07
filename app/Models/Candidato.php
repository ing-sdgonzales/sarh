<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Candidato extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'candidatos';
    protected $fillable = [
        'dpi', 'nit', 'iggs', 'nombre', 'email', 'imagen', 'fecha_nacimiento', 'fecha_registro', 'fecha_ingreso',
        'direccion', 'estado', 'aprobado', 'contratado', 'estados_civiles_id', 'municipios_id', 'tipos_contrataciones_id'
    ];
}
