<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonificacion extends Model
{
    use HasFactory;

    protected $table = 'bonificaciones';
    protected $fillable = ['bono', 'cantidad', 'calculado', 'tipos_bonificaciones_id'];
}
