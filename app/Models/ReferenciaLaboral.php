<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenciaLaboral extends Model
{
    use HasFactory;

    protected $table = 'referencias_laborales';
    protected $fillable = ['nombre', 'empresa', 'telefono', 'empleados_id'];
}
