<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuestoFuncional extends Model
{
    use HasFactory;

    protected $table = 'puestos_funcionales';
    protected $fillable = ['puesto', 'dependencias_funcionales_id'];
}
