<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PirSolicitud extends Model
{
    use HasFactory;

    protected $table = 'pir_solicitudes';
    protected $fillable = ['fecha_solicitud', 'fecha_aprobacion', 'aprobada', 'pir_direccion_id'];
}
