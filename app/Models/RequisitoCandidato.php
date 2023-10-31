<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitoCandidato extends Model
{
    use HasFactory;

    protected $table = 'requisitos_candidatos';
    protected $fillable = ['ubicacion', 'observacion', 'valido', 'revisado', 'fecha_carga', 'fecha_revision', 'candidatos_id', 'puestos_nominales_id', 'requisitos_id'];
}
