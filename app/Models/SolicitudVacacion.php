<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudVacacion extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_vacaciones';
    protected $fillable = ['fecha_salida', 'fecha_ingreso', 'year', 'duracion', 'aprobada', 'observacion', 'empleados_id'];
}
