<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelefonoEmpleado extends Model
{
    use HasFactory;

    protected $table = 'telefonos_empleados';
    protected $fillable = ['telefono', 'telefono_casa', 'empleados_id'];
}
