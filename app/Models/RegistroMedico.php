<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroMedico extends Model
{
    use HasFactory;

    protected $table = 'registros_medicos';
    protected $fillable = ['fecha_consulta', 'consulta', 'receta', 'proxima_consulta', 'empleados_id'];
}
