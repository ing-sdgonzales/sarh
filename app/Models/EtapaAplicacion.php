<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtapaAplicacion extends Model
{
    use HasFactory;

    protected $table = 'etapas_aplicaciones';
    protected $fillable = ['fecha_inicio', 'fecha_fin', 'etapas_procesos_id', 'aplicaciones_candidatos_id'];
}
