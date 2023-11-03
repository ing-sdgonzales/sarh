<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudioActualEmpleado extends Model
{
    use HasFactory;

    protected $table = 'estudios_actuales_empleados';
    protected $fillable = ['carrera', 'establecimiento', 'horario', 'empleados_id'];
}
