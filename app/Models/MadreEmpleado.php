<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MadreEmpleado extends Model
{
    use HasFactory;

    protected $table = 'madres_empleados';
    protected $fillable = ['nombre', 'ocupacion', 'telefono', 'empleados_id'];
}
