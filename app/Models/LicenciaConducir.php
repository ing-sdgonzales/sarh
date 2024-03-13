<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenciaConducir extends Model
{
    use HasFactory;

    protected $table = 'licencias_conducir';
    protected $fillable = ['licencia', 'fecha_vencimiento', 'tipos_licencias_id', 'empleados_id'];
}
