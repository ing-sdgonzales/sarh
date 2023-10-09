<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AplicacionCandidato extends Model
{
    use HasFactory;

    protected $table = 'aplicaciones_candidatos';
    protected $fillable = ['observacion', 'fecha_aplicacion', 'candidatos_id', 'puestos_nominales_id'];
}
