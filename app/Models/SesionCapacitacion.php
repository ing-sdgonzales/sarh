<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesionCapacitacion extends Model
{
    use HasFactory;

    protected $table = 'sesiones_capacitaciones';
    protected $fillable = ['fecha', 'hora_inicio', 'hora_fin', 'ubicacion', 'capacitaciones_id'];
}
