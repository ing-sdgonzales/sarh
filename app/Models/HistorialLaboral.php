<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialLaboral extends Model
{
    use HasFactory;

    protected $table = 'historiales_laborales';
    protected $fillable = ['empresa', 'direccion', 'telefono', 'jefe_inmediato', 'cargo', 'desde', 'hasta', 'ultimo_sueldo', 'motivo_salida', 
    'verificar_informacion', 'razon_informacion', 'empleados_id'];
}
