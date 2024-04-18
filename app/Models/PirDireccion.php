<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PirDireccion extends Model
{
    use HasFactory;

    protected $table = 'pir_direcciones';
    protected $fillable = ['direccion', 'hora_actualizacion', 'habilitado', 'pir_seccion_id'];
}
