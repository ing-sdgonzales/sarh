<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PirPuesto extends Model
{
    use HasFactory;

    protected $table = 'pir_puestos';
    protected $fillable = ['catalogo_puesto_id', 'pir_empleado_id'];
}
