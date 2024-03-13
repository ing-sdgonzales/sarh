<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenciaPersonal extends Model
{
    use HasFactory;

    protected $table = 'referencias_personales';
    protected $fillable = ['nombre', 'lugar_trabajo', 'telefono', 'empleados_id'];
}
