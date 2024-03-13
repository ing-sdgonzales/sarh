<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PruebaPsicometrica extends Model
{
    use HasFactory;

    protected $table = 'pruebas_psicometricas';
    protected $fillable = ['prueba', 'fecha', 'candidatos_id'];
    protected $casts = ['prueba' => 'datetime:Y-m-d'];
}
