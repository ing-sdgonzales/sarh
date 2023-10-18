<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deuda extends Model
{
    use HasFactory;

    protected $table = 'deudas';
    protected $fillable = ['monto', 'tipos_deudas_id', 'empleados_id'];
}
