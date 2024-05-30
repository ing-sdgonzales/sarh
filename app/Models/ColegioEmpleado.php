<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColegioEmpleado extends Model
{
    use HasFactory;

    protected $table = 'colegios_empleados';
    protected $fillable = ['colegiado', 'profesion', 'empleados_id', 'colegios_id'];
}
