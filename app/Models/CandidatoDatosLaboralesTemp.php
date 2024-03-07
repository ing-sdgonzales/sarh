<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatoDatosLaboralesTemp extends Model
{
    use HasFactory;

    protected $table = 'candidatos_datos_laborales_temp';
    protected $fillable = ['dpi', 'titulo', 'titulo_universitario', 'colegiado', 'colegios_id', 'registros_academicos_id'];
}
