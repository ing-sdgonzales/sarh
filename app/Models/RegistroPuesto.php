<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroPuesto extends Model
{
    use HasFactory;

    protected $table = 'registros_puestos';
    protected $fillable = [
        'fecha_inicio', 'fecha_fin', 'observacion', 'contratos_id', 'primer_puesto_id', 'puestos_funcionales_id',
        'dependencias_funcionales_id', 'regiones_id'
    ];
}
