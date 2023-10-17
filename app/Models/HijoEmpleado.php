<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HijoEmpleado extends Model
{
    use HasFactory;

    protected $table = 'hijos_empleados';
    protected $fillable = ['nombre', 'empleados_id'];
}
