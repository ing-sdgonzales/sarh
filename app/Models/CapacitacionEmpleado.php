<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapacitacionEmpleado extends Model
{
    use HasFactory;

    protected $table = 'capacitaciones_empleados';
    protected $fillable = ['empleados_id', 'sesiones_capacitaciones_id'];
}
