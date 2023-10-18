<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriaClinica extends Model
{
    use HasFactory;

    protected $table = 'historias_clinicas';
    protected $fillable = ['padecimiento_salud', 'tipo_enfermedad', 'intervencion_quirurgica', 'tipo_intervencion', 'sufrido_accidente', 
    'tipo_accidente', 'alergia_medicamento', 'tipo_alergia'];
}
