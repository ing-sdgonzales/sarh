<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformeEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'informes_evaluaciones';
    protected $fillable = ['fecha_carga', 'ubicacion', 'aplicaciones_candidatos_id'];
}
