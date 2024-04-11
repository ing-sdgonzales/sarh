<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PirEmpleado extends Model
{
    use HasFactory;

    protected $table = 'pir_empleados';
    protected $fillable = [
        'nombre', 'observacion', 'activo', 'is_regional_i', 'pir_reporte_id', 'pir_grupo_id', 'pir_direccion_id', 'region_id', 'departamento_id'
    ];
}
