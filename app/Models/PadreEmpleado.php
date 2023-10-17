<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PadreEmpleado extends Model
{
    use HasFactory;

    protected $table = 'padres_empleados';
    protected $fillable = ['nombre', 'ocupacion', 'telefono', 'empleados_id'];
}
