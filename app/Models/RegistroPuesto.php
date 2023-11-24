<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroPuesto extends Model
{
    use HasFactory;

    protected $table = 'registros_puestos';
    protected $fillable = ['observacion', 'contratos_id', 'puestos_nominales_id', 'tipos_contrataciones_id', 
        'puestos_funcionales_id', 'dependencias_funcionales_id'];
}
