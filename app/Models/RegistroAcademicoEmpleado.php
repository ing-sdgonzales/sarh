<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroAcademicoEmpleado extends Model
{
    use HasFactory;

    protected $table = 'registros_academicos_empleados';
    protected $fillable = ['establecimiento', 'titulo', 'registros_academicos_id', 'empleados_id'];
}
