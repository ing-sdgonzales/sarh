<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $table = 'contratos';
    protected $fillable = ['numero', 'fecha_inicio', 'fecha_fin', 'salario', 'puestos_nominales_id', 'empleados_id'];
}
