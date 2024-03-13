<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramaComputacion extends Model
{
    use HasFactory;

    protected $table = 'programas_computacion';
    protected $fillable = ['programa', 'valoracion', 'empleados_id'];

}
