<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodoContrato extends Model
{
    use HasFactory;

    protected $table = 'periodos_contratos';
    protected $fillable = ['fecha_inicio', 'fecha_fin', 'contratos_id'];
}
