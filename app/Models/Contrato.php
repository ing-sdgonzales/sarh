<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $table = 'contratos';
    protected $fillable = [
        'numero', 'salario', 'acuerdo_aprobacion', 'acuerdo_rescicion', 'nit_autorizacion',
        'fianza', 'vigente', 'puestos_nominales_id', 'empleados_id', 'tipos_contrataciones_id'
    ];
}
